<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use Auth;

class OAuthLoginController extends Controller
{

    /**
     * OAuth認証 リクエスト
     * @return mixed
     */
    public function redirector($provider)
    {
        $method = 'scope' . ucfirst($provider);
        $scopes = method_exists($this, $method) ? $this->{ $method }() : [];
        return Socialite::driver($provider)
            ->scopes($scopes)
            ->with(["access_type" => "offline", "prompt" => "consent select_account"]) 
            ->redirect()
        ;
    }

    /**
     * OAuth認証 コールバック
     */
    public function callback($provider)
    {
        $authUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate(
            ['name' => $authUser->name ],
            ['email' => $authUser->email]
        );


        // Set token for the Google API PHP Client
        $google_client_token = [
            'access_token' => $authUser->token,
            'refresh_token' => $authUser->refreshToken,
            'expires_in' => $authUser->expiresIn
        ];

        session()->put('google_client_token', $google_client_token);

        Auth::login($user);

        // $client = new \Google_Client();
        // $client->setClientId(config('services.google.client_id'));
        // $client->setClientSecret(config('services.google.client_secret'));
        // $client->setAccessToken(json_encode($google_client_token));
        // $youtube = new \Google_Service_YouTube($client);

        // $broadcastsResponse = $youtube->liveBroadcasts->listLiveBroadcasts(
        //     'id,snippet',
        //     [
        //         'mine' => 'true',
        //     ]
        // );
    
        // dd($broadcastsResponse, $google_client_token);


        return redirect()->intended('/');
    }


    protected function scopeGoogle()
    {
        return  [
            'https://www.googleapis.com/auth/plus.me',
            'https://www.googleapis.com/auth/plus.profile.emails.read',
            'https://www.googleapis.com/auth/youtube'
        ];
    }
}
