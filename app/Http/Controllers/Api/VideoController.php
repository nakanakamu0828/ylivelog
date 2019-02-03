<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        return Auth::user()->videos()->orderBy('created_at', 'desc')->paginate();
    }
}
