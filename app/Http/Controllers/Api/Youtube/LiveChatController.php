<?php

namespace App\Http\Controllers\Api\Youtube;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Auth;

class LiveChatController extends Controller
{
    public function index(Request $request)
    {
        $google_client_token = session()->get('google_client_token');

        $client = new \Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setAccessToken(json_encode($google_client_token));
        $youtube = new \Google_Service_YouTube($client);


        $broadcasts = session()->get('broadcasts');
        if (
            isset($broadcasts['live_chat_id'])
            && isset($broadcasts['expire'])
            && (Carbon::now())->lte(Carbon::parse($broadcasts['expire']))
        ) {
            $liveChatId = $broadcasts['live_chat_id'];
            $video = $broadcasts['video'];
        } else {
            $params = [];
            $params['broadcastStatus'] = 'active';
            $params['broadcastType'] = 'all';
            $broadcastsResponse = $youtube->liveBroadcasts->listLiveBroadcasts(
                'id,snippet', $params            
            );
    
            if (
                empty($broadcastsResponse['items'])
                || !isset($broadcastsResponse['items'][0]["id"])
                || !isset($broadcastsResponse['items'][0]["snippet"]["liveChatId"])
            ) {
                return response()->json([
                    'status' => 404,
                    'message' => 'データが見つかりませんでした',
                ], 404);
            }
    
            $videoId = $broadcastsResponse['items'][0]["id"];
            $video = Auth::user()->videos()->firstOrNew(['v' => $videoId]);
            if (!$video->id) {
                $videoResponse = $youtube->videos->listVideos('snippet', [
                    'id' => $videoId
                ]);
        
                if (
                    empty($videoResponse['items'])
                    || !isset($videoResponse['items'][0]["snippet"]["title"])
                ) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'データが見つかりませんでした',
                    ], 404);
                }
        
                $video->title = $videoResponse['items'][0]["snippet"]["title"];
                $video->image_url = isset($videoResponse['items'][0]["snippet"]["thumbnails"]['standard']['url']) ? $videoResponse['items'][0]["snippet"]["thumbnails"]['standard']['url'] : null;
                $video->save();
            }

            $liveChatId = $broadcastsResponse['items'][0]["snippet"]["liveChatId"];
            $now = Carbon::now();
            $now->addSecond(600);
            session()->put('broadcasts', [
                'live_chat_id' => $liveChatId,
                'video' => $video,
                'expire' => $now->format('Y-m-d H:i:s'),
            ]);
        }


        $option = [];
        if ($request->next_page_token) {
            $option['pageToken'] = $request->next_page_token;
        }
        $liveChatMessages = $youtube->liveChatMessages->listLiveChatMessages($liveChatId, 'snippet,authorDetails', $option);
        $posts = array_map(function($item) use($video) {
            $publishedAt = new Carbon($item['snippet']['publishedAt']);
            $publishedAt->setTimezone(config('app.timezone'));
            return [
                'id'                        => $item['id'],
                 'v'                        => $video->id,

                'live_chat_id'              => $item['snippet']['liveChatId'],
                'published_at'              => $publishedAt->format('Y-m-d H:i:s'),
                'message'                   => $item['snippet']['displayMessage'],

                // 'autor_channel_id'          => $item['authorDetails']['channelId'],
                // 'autor_channel_url'         => $item['authorDetails']['channelUrl'],
                'autor_display_name'        => $item['authorDetails']['displayName'],
                'autor_profile_image_url'   => $item['authorDetails']['profileImageUrl'],
            ];
        }, $liveChatMessages['items']);

        if (count($posts)) {
            foreach($posts as $post) {
                $id = $post['id'];
                $p = $post;
                unset($p['id']);
                Post::firstOrCreate(['id' => $id], $p);
            }
        }

        return [
            'video' => $video,
            'posts' => $posts,
            'next_page_token' => $liveChatMessages['nextPageToken'],
        ];
    }
}
