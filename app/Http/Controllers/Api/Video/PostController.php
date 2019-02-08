<?php

namespace App\Http\Controllers\Api\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Auth;

class PostController extends Controller
{
    public function index(Request $request, int $id)
    {
        $video = Auth::user()->videos()->findOrFail($id);
        $posts = Post::where('v', $video->id)->orderBy('published_at', 'desc')->paginate(100);
        return [
            'posts' => $posts,
            'next'  => $posts->lastPage() > $posts->currentPage() ? $posts->currentPage() + 1 : null,
        ];
    }
}
