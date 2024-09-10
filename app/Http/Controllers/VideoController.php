<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessVideo;

class VideoController extends Controller
{
        public function store(Request $request)
        {
            $validatedData = $request->validate([
                'video' => 'required|file|mimes:mp4,mkv,webm,mp3|max:20480',
                'trim_from' => 'nullable|integer|min:0',
                'trim_to' => 'nullable|integer|min:0',
            ]);
            
            $destinationPath = storage_path('app/videos');

            $storedFileName = $request->file('video')->getClientOriginalName(); 
            $videoPath = $request->file('video')->move($destinationPath, $storedFileName);
        
            $absolutePath = $videoPath->getRealPath();
        

            $video = Video::create([
                'user_id' => Auth::id(),
                'title' => $request->file('video')->getClientOriginalName(),
                'status' => 'pending',
                'path' => $absolutePath,
                'length' => null,
                'transcription' => null,
                'summary' => null,
                'trim_from' => $validatedData['trim_from'] ?? null,
                'trim_to' => $validatedData['trim_to'] ?? null,
            ]);
    
            // Dispatch video processing to the queue
            ProcessVideo::dispatch($video);
    
            return response()->json(['message' => 'Video uploaded successfully and processing started.', 'video' => $video], 201);
        }
    
        /**
         * @param $id
         * 
         * get video status
         */
        public function getVideoStatus($id)
        {
            $video = Video::where('id', $id)->firstOrFail();
    
            if ($video->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
    
            return response()->json([
                'status' => $video->status,
                'length' => $video->length,
                'transcription' => $video->transcription,
                'summary' => $video->summary
            ]);
        }
    
        /**
         * @param Request $request
         * 
         * List videos for authenticated user
         */
        public function listUserVideos(Request $request)
        {
            $user = Auth::user();
            $videos = $user->userVideos()->paginate(10);
    
            return response()->json($videos);
        }
}
