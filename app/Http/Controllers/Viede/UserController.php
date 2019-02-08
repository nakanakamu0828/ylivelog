<?php

namespace App\Http\Controllers\Viede;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Post;
use Auth;

class UserController extends Controller
{
    private $users = [];

    public function download(Request $request, int $id)
    {

        $video = Auth::user()->videos()->findOrFail($id);
        return  new StreamedResponse(
            function () use($video) {
                $stream = fopen('php://output', 'w');
                Post::where('v', $video->id)->orderBy('published_at', 'desc')->chunk(100, function ($posts) use ($stream) {
                    foreach ($posts as $post) {
                        if (!in_array($post->autor_display_name, $this->users, true)) {
                            fputcsv($stream, [ $post->autor_display_name ]);
                            $this->users[] = $post->autor_display_name;
                        }
                    }
                });
                fclose($stream);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="video_' . $video->v . '_users.csv"',
            ]
        );
    }

}
