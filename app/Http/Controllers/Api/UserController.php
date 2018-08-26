<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Author;
use App\Models\Notification;
use Validator;

class UserController extends Controller
{   
    
    public function profile(Request $request, $userId){
        $profile = User::profile($this->me($request), $userId);
        if(!empty($profile)){
            return response()->json(['msg' => 'Perfil', 'data' => $profile]);
        }
        return response()->json(['msg' => 'Este perfil não existe']);
    }
    
    public function follow(Request $request){
        if(is_array($request->users) && !empty($request->users) && array_product(array_map('is_numeric', $request->users)) && count($request->users) === count(array_flip($request->users))){
            return response()->json(User::follow($request->users, $request->auth->id));
        }
        return response()->json(['msg' => 'Os dados não foram inseridos corretamente']);
    }
    
    public function unfollow(Request $request, $userId){
        if(User::unfollow($request->auth->id, $userId)){
            return response()->json(['msg' => 'Usuário retirado de sua lista de seguidos', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Não foi possível retirar o usuário de sua lista de seguidos']);
        }
    }
    
    public function authorToFeed(Request $request){
        return response()->json(['msg' => 'Autores para o feed', 'data' => User::authorToFeed($request->auth->id)]);
    }
    
    public function following(Request $request, $offset = 0){
        return response()->json(['msg' => 'Autores seguidos', 'data' => User::following($request->auth->id, $offset)]);
    }
    
    public function clearUnreadNotification(Request $request, $action, $actionId = 0){
        if(Notification::clearUnreadNotification($request->auth->id, $action, $actionId)){
            return response()->json(['msg' => 'Notificações não-lidas deletadas com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Não foi possível deletar as notificação não-lidas']);
        }
    }
    
    public function like(Request $request){
        if(User::like($request->auth->id, $request->publicationId)){
            return response()->json(['msg' => 'Publicação curtida com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'A publicação já foi curtida']);
        }
    }
    
    public function unlike(Request $request, $publicationId){
        if(User::unlike($request->auth->id, $publicationId)){
            return response()->json(['msg' => 'Publicação "descurtida" com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Esta publicação não estava "curtida", portanto, não foi "descurtida"']);
        }
    }
    
    public function save(Request $request){
        if(User::savePublication($request->auth->id, $request->publicationId)){
            return response()->json(['msg' => 'Publicação salva com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'A publicação já foi salva']);
        }
    }
    
    public function unsave(Request $request, $publicationId){
        if(User::unsave($request->auth->id, $publicationId)){
            return response()->json(['msg' => 'Publicação "descartada" com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Esta publicação não estava "salva", portanto, não foi "darcartada"']);
        }
    }
    
    public function mute(Request $request, $userId){
        if(User::mute($request->auth->id, $userId)){
            return response()->json(['msg' => 'Usuário silenciado com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Não foi possível silenciar o usuario']);
        }
    }
    
    public function unmute(Request $request, $userId){
        if(User::unmute($request->auth->id, $userId)){
            return response()->json(['msg' => 'O usuário não está mais silenciado', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Não foi possível retirar o silencio do usuario']);
        }
    }
    
    private function me($request){
        return $request->auth->id ? $request->auth->id : 0;
    }

}
