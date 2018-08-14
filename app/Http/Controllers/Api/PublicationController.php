<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\User;
use App\Models\Notification;
use App\Models\Author;
use App\Http\Requests\StorePublication;

class PublicationController extends Controller
{
    public function store(StorePublication $request){
        $request->merge(['authorId' => $request->auth->authorId]);
        $publication = Publication::create($request->all());
        if($publication){
            Publication::addCategory($request->category ? $request->category : [], $publication->id);
            Publication::addImages($request->images ? $request->images : [], $publication->id);
            $followers = Author::followers($request->auth->id);
            Notification::addUnreadPublication($followers, $publication->id);
            Notification::sendPublication($request->auth, $followers, $publication);
            return response()->json(['msg' => "Publicação cadastrada com sucesso."]);
        }else{
            return response()->json(['msg' => "Houve um erro ao cadastrar a publicação. Tente novamente"]);
        }
    }
}
