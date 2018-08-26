<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Publication;
use App\Models\LinkHelper;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function search(Request $request, $filter, $offset){
        return response()->json(['msg' => 'Usuários', 'data' => Author::search($request->auth->id, $filter, $offset)]);
    }
    
    public function suggestion(Request $request, $offset){
        return response()->json(['msg' => 'Usuários', 'data' => Author::suggestion($offset)]);
    }
    
    public function folder(Request $request, $folderId = 0){
        return response()->json(['msg' => 'Pastas', 'data' => Author::folder($request->auth->authorId, $folderId)]);
    }
    
    public function profileFolders(Request $request, $authorId){
        return response()->json(['msg' => 'Pastas do autor', 'data' => Author::folder($authorId)]);
    }
    
    public function publication(Request $request, $id, $offset = 0, $last = 0){
        $publication = Publication::byAuthor($this->me($request), $id, $offset, $last);
        return response()->json(['msg' => "Publicações do autor", 'data' => $publication]);
    }
    
    public function publicationInFolder(Request $request, $id, $folderId, $offset = 0){
        $publication = Publication::byAuthor($this->me($request), $id, $offset, null, $folderId);
        return response()->json(['msg' => "Publicações do autor em uma pasta", 'data' => $publication]);
    }
    
    public function teste(Request $request){
        $url = 'https://medium.com/';
        $tags = LinkHelper::getMetaTagOG($url);
        $data = array(
                    "url"   => $url,
                    "title" => $tags['title'] ?? null,
                    "description" => $tags['description'] ?? null,
                    "image" => $tags['image'] ?? null
                );
        //$tags = $this->fetch("https://monada-web-tarcisiolima.c9users.io/");
        return response()->json(['msg' => 'Meta tags', 'data' => $data]);
    }
    
    private function me($request){
        return $request->auth->id ? $request->auth->id : 0;
    }
    
}
