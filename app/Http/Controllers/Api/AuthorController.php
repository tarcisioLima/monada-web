<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Support\Facades\Storage;
use DOMDocument;

class AuthorController extends Controller
{
    public function search(Request $request, $filter, $offset){
        return response()->json(['msg' => 'Usuários', 'data' => Author::search($filter, $offset)]);
    }
    
    public function suggestion(Request $request, $offset){
        return response()->json(['msg' => 'Usuários', 'data' => Author::suggestion($offset)]);
    }
    
    public function teste(Request $request){
        //$tags = get_meta_tags('https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c');
        //$tags = $this->fetch("https://monada-web-tarcisiolima.c9users.io/");
        return response()->json(['msg' => 'Meta tags', 'data' => $request->auth]);
    }
    
    public function fetch($url){
        $html = $this->curl_get_contents($url);

        /**
         * parsing starts here:
         */
        $doc = new DOMDocument();
        @$doc->loadHTML('<?xml encoding="utf-8" ?>'.$html);


        $tags = $doc->getElementsByTagName('meta');
        $metadata = array();

        foreach ($tags as $tag) {
            if ($tag->hasAttribute('property') && strpos($tag->getAttribute('property'), 'og:') === 0) {
                $key = strtr(substr($tag->getAttribute('property'), 3), '-', '_');
                $value = $tag->getAttribute('content');
            }
            if (!empty($key)) {
                $metadata[$key] = $value;
            }
        }

        return $metadata;
    }

    protected function curl_get_contents($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FAILONERROR, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
