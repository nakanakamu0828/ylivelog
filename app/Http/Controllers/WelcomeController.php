<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  SahusoftCom\YoutubeApi\AuthService;

class WelcomeController extends Controller
{
    public function index()
    {        
        return view('welcome');
    }
}
