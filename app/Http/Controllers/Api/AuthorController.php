<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Publication;
use App\Models\Folder;
use App\Utils\LinkHelper;
use Illuminate\Support\Facades\Storage;
use App\Utils\Obscure;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookSDKException;
use Abraham\TwitterOAuth\TwitterOAuth;
use Validator;

class AuthorController extends Controller
{
    public function store(Request $request){
        if($request->auth->authorId){
            return response()->json(['msg' => 'Já és um autor!']);
        }
        if(Validator::make(['invite' => $request->invite], ['invite' => 'exists:invite,id'])->fails()){
            return response()->json(['msg' => 'Código de autor inválido', 'data' => false]);
        }
        if($authorId = Author::store($request->auth->userId, $request->invite)){
            return response()->json(['msg' => 'Agora és um autor', 'data' => array('authorId' => Obscure::author($authorId))]);
        }
        return response()->json(['msg' => 'Não foi possível tornar-te um autor', 'data' => false]);
    }
    
    public function search(Request $request, $filter, $offset){
        return response()->json(['msg' => 'Usuários', 'data' => Author::search($this->authId($request), $filter, $offset)]);
    }
    
    public function suggestion(Request $request, $offset){
        return response()->json(['msg' => 'Usuários', 'data' => Author::suggestion($offset)]);
    }
    
    public function folder(Request $request, $authorId){
        return response()->json(['msg' => 'Pastas do autor', 'data' => Folder::show($authorId)]);
    }
    
    public function publication(Request $request, $id, $offset = 0, $last = 0){
        $publication = Publication::byAuthor($this->authId($request), $id, $offset, $last);
        return response()->json(['msg' => "Publicações do autor", 'data' => $publication]);
    }
    
    public function publicationInFolder(Request $request, $id, $folderId, $offset = 0){
        $publication = Publication::byAuthor($this->authId($request), $id, $offset, null, $folderId);
        return response()->json(['msg' => "Publicações do autor em uma pasta", 'data' => $publication]);
    }
    
    private function authId($request){
        return $request->auth->userId ?? 0;
    }
    
}
