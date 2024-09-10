<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use FFMpeg\Format\Audio\DefaultAudio;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        try {
            $inputPath = $this->video->path;
            $trimmedPath = storage_path('app/videos/' . $this->video->id . '_trimmed.mp4');
            $audioPath = storage_path('app/videos/' . $this->video->id . '.aac');
        
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open($inputPath);
    
            if ($this->video->trim_from !== null && $this->video->trim_to !== null) {
                $video->filters()
                    ->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($this->video->trim_from), \FFMpeg\Coordinate\TimeCode::fromSeconds($this->video->trim_to - $this->video->trim_from))
                    ->synchronize();
            }
            $trimmedFormat = new X264();
            $trimmedFormat->setKiloBitrate(1000);
            $trimmedFormat->setAudioCodec('aac');
            $video->save($trimmedFormat, $trimmedPath);
    
            $command = "ffmpeg -i " . escapeshellarg($trimmedPath) . " -vn -c:a aac -b:a 192k " . escapeshellarg($audioPath);
            exec($command, $output, $returnVar);
    
            if ($returnVar !== 0) {
                throw new \Exception("FFMpeg command failed with return code $returnVar: " . implode("\n", $output));
            }

            $this->video->update([
                'path' => $audioPath,
                'status' => 'processing',
            ]);
    
            TranscribeVideo::dispatch($this->video);
        } catch (\Exception $e) {
            Log::error('Error processing video ID: ' . $this->video->id . ' - ' . $e->getMessage());
            $this->video->update(['status' => 'failed']);
        }
    }
}
