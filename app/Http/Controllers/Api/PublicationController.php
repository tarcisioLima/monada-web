<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\User;
use App\Models\Notification;
use App\Models\Author;
use App\Http\Requests\StorePublication;
use App\Http\Requests\SearchPublication;

class PublicationController extends Controller
{
    public function store(StorePublication $request){
        $request->merge(['authorId' => $request->auth->authorId]);
        $publication = Publication::create($request->all());
        if($publication){
            Publication::addCategory($request->category ? $request->category : [], $publication->id);
            Publication::addImages($request->images ? $request->images : [], $publication->id);
            $followers = Author::followers($request->auth->id);
            Notification::addUnreadPublication($followers, $request->auth->authorId);
            Notification::sendPublication($request->auth, $followers, $publication);
            return response()->json(['msg' => "Publicação cadastrada com sucesso."]);
        }else{
            return response()->json(['msg' => "Houve um erro ao cadastrar a publicação. Tente novamente"]);
        }
    }
    
    public function show(Request $request, $offset = 0, $last = 0){
        $publication = Publication::byFollowing($request->auth->id, $offset, $last);
        return response()->json(['msg' => "Publicações", 'data' => $publication]);
    }
    
    public function highlights(Request $request, $offset = 0){
        $publication = Publication::highlights($request->auth->id, $offset);
        return response()->json(['msg' => "Publicações em destaque", 'data' => $publication]);
    }
    
    public function search(SearchPublication $request, $offset = 0){
        $publication = Publication::search($request->auth->id, $request->term, $request->author, $request->category, $request->since, $request->until, $offset, $request->folderId, $request->authorId);
        return response()->json(['msg' => "Publicações pesquisadas", 'data' => $publication]);
    }
    
    public function categories(Request $request){
        return response()->json(['msg' => "Categorias", 'data' => Publication::categories()]);
    }
    
}
