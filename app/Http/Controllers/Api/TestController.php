<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use App\Utils\ActionEnum;
use App\Builder\PushBuilder;
use Goutte;

class TestController extends Controller
{
    
    public function storeSystemNotification(Request $request){
        $id = DB::table('system_notification')->insertGetId([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $request->image
        ]);
        Notification::insertSystem(ActionEnum::SYSTEM, $id);
        PushBuilder::system($request->title, $request->description, $request->image);
    }
    
    public function testeFacebook(Request $request){
        $config = config('services.facebook');
        $facebook = new Facebook([
                'app_id' => $config['client_id'],
                'app_secret' => $config['client_secret'],
                'default_graph_version' => $config['default_graph_version'],
        ]);
        $params = array(
            "url" => "https://image.slidesharecdn.com/ceciestuntest2-1212011503842739-8/95/teste-de-inteligencia-1-728.jpg",
            "published" => false
        );
        $userId = "142162896733720";
        $accessToken = "EAADXUCbq0fsBAKfRJXG3BCIZAu2r9LLhyE7o3HsTjQ0KdSNZCA78hHWC1SwfZAKafNfHOfS14PbyGrzg1rFiDJfkDf5o8tm10oUPIOtXkJZCAKHatoWPXZCg6IwfY3hAAhA7ZCDmiilCSjYVOwbxhF5wstM4GhVB3ENtPqZBkyBqVDe5BTgIiXqScxfCFBiRpxCZBkS4d0Lg2ZAaUK8bxxbWf8D0ZB7SkOAmhXESuuuvJ0Y4NxGZA9YzyB7";
        
        return response()->json(['msg' => 'Meta tags', 'data' => $facebook->post("/".$userId."/photos", $params, $accessToken)]);
    }
    
    public function teste(Request $request){
        
    }
    
    public function twitter(Request $request){
        $access_token = "166203471-8p4QnPu6PtnMCF5nnvztVJVDjdGPAYMO3bognMJK";
        $access_token_secret = "yDVUW3AG3goKbGzivNg9wyvUmeOaz38p1CVggBd49E1w3";
        $consumer_key = "SobmAsU6aLeCiUPlNpGKVuRWZ";
        $consumer_secret = "TBu3UlHAONzVNZ3t4SCF7a1MWESmaJHbjxFtN338c6N5P8tYZs";
        $conn = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
        return response()->json(['msg' => 'Tweets', 'data' => 
            $conn->get('statuses/user_timeline', ['screen_name' => 'allantercalivre', 'since_id' => 1037314722318569473])
        ]);
    }
}
