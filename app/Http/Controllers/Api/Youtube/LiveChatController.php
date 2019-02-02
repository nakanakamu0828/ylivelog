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

        $video = Auth::user()->videos()->firstOrNew(['v' => $request->id]);
        if (!$video->id) {
            $videoResponse = $youtube->videos->listVideos('snippet', array(
                'id' => $request->id
            ));
    
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

        $broadcastsResponse = $youtube->liveBroadcasts->listLiveBroadcasts(
            'id,snippet',
            [
                'id' => $request->id,
            ]
        );

        if (
            empty($broadcastsResponse['items'])
            || !isset($broadcastsResponse['items'][0]["snippet"]["liveChatId"])
        ) {
            return response()->json([
                'status' => 404,
                'message' => 'データが見つかりませんでした',
            ], 404);
        }

        $liveChatId = $broadcastsResponse['items'][0]["snippet"]["liveChatId"];

        $option = [];
        if ($request->nextPageToken) {
            $option['pageToken'] = $request->nextPageToken;
        }
        $liveChatMessages = $youtube->liveChatMessages->listLiveChatMessages($liveChatId, 'snippet,authorDetails', $option);
        $posts = array_map(function($item) use($video) {
            $publishedAt = new Carbon($item['snippet']['publishedAt']);
            $publishedAt->setTimezone(config('app.timezone'));
            return [
                'id'                    => $item['id'],
                 'v'                    => $video->id,

                'liveChatId'            => $item['snippet']['liveChatId'],
                'publishedAt'           => $publishedAt->format('Y-m-d H:i:s'),
                'message'               => $item['snippet']['displayMessage'],

                'autorChannelId'        => $item['authorDetails']['channelId'],
                'autorChannelUrl'       => $item['authorDetails']['channelUrl'],
                'autorDisplayName'      => $item['authorDetails']['displayName'],
                'autorProfileImageUrl'  => $item['authorDetails']['profileImageUrl'],
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
            'title' => $video->title,
            'image_url' => $video->image_url,
            'posts' => $posts,
            'nextPageToken' => $liveChatMessages['nextPageToken'],
        ];
    }
}
