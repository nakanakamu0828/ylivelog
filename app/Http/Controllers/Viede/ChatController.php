<?php

namespace App\Http\Controllers\Viede;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Post;
use Auth;

class ChatController extends Controller
{

    public function download(Request $request, int $id)
    {
        $video = Auth::user()->videos()->findOrFail($id);
        return  new StreamedResponse(
            function () use($video) {
                $stream = fopen('php://output', 'w');
                Post::where('v', $video->id)->orderBy('published_at', 'desc')->chunk(100, function ($posts) use ($stream) {
                    foreach ($posts as $post) {
                        fputcsv($stream, [$post->published_at, $post->autor_display_name, $post->message]);
                    }
                });
                fclose($stream);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="video_' . $video->v . '_chats.csv"',
            ]
        );
    }
}
