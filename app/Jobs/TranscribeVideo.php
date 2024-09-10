<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranscribeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Send video to Deepgram API for transcription
            $videoPath = $this->video->path;

            $response = Http::withHeaders([
                'Authorization' => 'Token ' . env('DEEPGRAM_API_KEY'),
            ])->attach('file', fopen($videoPath, 'r'), basename($videoPath))
            ->post('https://api.deepgram.com/v1/listen');

            $transcription = $response['results']['channels'][0]['alternatives'][0]['transcript'];

            $this->video->update(['transcription' => $transcription]);

            if ($transcription) {
                SummarizeTranscription::dispatch($this->video);
            } else {
                $this->video->update(['status' => 'completed']);
            }

        } catch (\Exception $e) {
            Log::error('Error transcribing video ID: ' . $this->video->id . ' - ' . $e->getMessage());

            $this->video->update(['status' => 'failed']);
        }
    }
}
