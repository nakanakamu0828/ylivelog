<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Auth;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        return Auth::user()->videos()->orderBy('created_at', 'desc')->paginate();
    }

    public function show(Request $request, $id)
    {
        $video = Auth::user()->videos()->findOrFail($id);
        $posts = Post::where('v', $video->id)->orderBy('published_at', 'desc')->paginate(100);
        return [
            'video' => $video,
            'posts' => $posts,
            'next'  => $posts->lastPage() > $posts->currentPage() ? $posts->currentPage() + 1 : null,
        ];
    }

}
