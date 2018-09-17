<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Author;
use App\Models\Notification;
use App\Models\Publication;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\UpdatePasswordUser;
use App\Http\Requests\StoreFollow;
use App\Http\Requests\UserList;
use App\Utils\Obscure;

class UserController extends Controller
{   
    public function me(Request $request)
    {
        return response()->json(['msg' => "Seus dados", "data" => User::me($this->authId($request))]);
    }
    
    public function feed(Request $request, $offset = 0, $last = 0){
        $publication = Publication::byFollowing($this->authId($request), $offset, $last);
        return response()->json(['msg' => "Publicações para o feed", 'data' => $publication]);
    }
    
    public function profile(Request $request, $userId){
        $profile = User::profile($this->authId($request), $userId);
        if(!empty($profile)){
            return response()->json(['msg' => 'Perfil', 'data' => $profile]);
        }
        return response()->json(['msg' => 'Este perfil não existe']);
    }
    
    public function saved(Request $request, $offset = 0){
        return response()->json(['msg' => "Publicações salvas", 'data' => User::saved_publications($this->authId($request), $offset)]);
    }
    
    public function liked(Request $request, $offset = 0){
        return response()->json(['msg' => "Publicações curtidas", 'data' => User::liked_publications($this->authId($request), $offset)]);
    }
    
    public function follow(StoreFollow $request){
        if(User::follow($request->users, $request)){
            return response()->json(['msg' => 'Usuário seguido com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Houve um erro interno ao finalizarmos o seu seguimento']);
        }
    }
    
    public function unfollow(Request $request, $userId){
        if(User::unfollow($this->authId($request), $userId)){
            return response()->json(['msg' => 'Usuário retirado de sua lista de seguidos', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Não foi possível retirar o usuário de sua lista de seguidos']);
        }
    }
    
    public function authorToFeed(Request $request){
        return response()->json(['msg' => 'Autores para o feed', 'data' => User::authorToFeed($this->authId($request))]);
    }
    
    public function following(Request $request, $offset = 0){
        return response()->json(['msg' => 'Autores seguidos', 'data' => User::following($this->authId($request), $offset)]);
    }
    
    
    public function clearUnreadNotification(Request $request, $action, $actionId = 0){
        if(Notification::clearUnreadNotification($this->authId($request), $action, $actionId)){
            return response()->json(['msg' => 'Notificações não-lidas deletadas com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Não foi possível deletar as notificação não-lidas']);
        }
    }
    
    public function readNotifications(Request $request){
        Notification::readNotifications($this->authId($request));
        return response()->json(['msg' => 'Leitura das notificações']);
    }
    
    public function like(Request $request){
        if(User::like($request, Obscure::unpublication($request->publicationId))){
            return response()->json(['msg' => 'Publicação curtida com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'A publicação já foi curtida']);
        }
    }
    
    public function unlike(Request $request, $publicationId){
        if(User::unlike($this->authId($request), $publicationId)){
            return response()->json(['msg' => 'Publicação "descurtida" com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Esta publicação não estava "curtida", portanto, não foi "descurtida"']);
        }
    }
    
    public function save(Request $request){
        if(User::savePublication($this->authId($request), Obscure::unpublication($request->publicationId))){
            return response()->json(['msg' => 'Publicação salva com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'A publicação já foi salva']);
        }
    }
    
    public function unsave(Request $request, $publicationId){
        if(User::unsave($this->authId($request), $publicationId)){
            return response()->json(['msg' => 'Publicação "descartada" com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Esta publicação não estava "salva", portanto, não foi "darcartada"']);
        }
    }
    
    public function mute(Request $request, $userId){
        if(User::mute($this->authId($request), $userId)){
            return response()->json(['msg' => 'Usuário silenciado com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Não foi possível silenciar o usuario']);
        }
    }
    
    public function unmute(Request $request, $userId){
        if(User::unmute($this->authId($request), $userId)){
            return response()->json(['msg' => 'O usuário não está mais silenciado', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Não foi possível retirar o silencio do usuario']);
        }
    }
    
    public function storeImage(Request $request){
        $filename = User::storeImage($this->authId($request), $request->monadaImage);
        if($filename){
            return response()->json(['msg' => 'Imagem inserida com sucesso', 'data' => $filename]);
        }else{
            return response()->json(['msg' => 'Não foi possível inserir a imagem de perfil']);
        }
    }
    
    public function update(UpdateUser $request){
        User::updateUser($request);
        return response()->json(['msg' => 'Usuário atualizado com sucesso', 'data' => true]);
    }
    
    public function updatePassword(UpdatePasswordUser $request){
        if(User::updateUserPassword($request)){
             return response()->json(['msg' => 'Senha do usuário atualizada com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Ocorreu um erro interno ao tentarmos alterar a senha']);
        }
    }
    
    public function checkUsername(Request $request, $username){
        if(Validator::make(['username' => $username], ['username' => $this->authId($request) ? Rule::unique('user')->ignore($request->auth->username, 'username') : 'unique:user,username'])->fails()){
            return response()->json(['msg' => 'O usuário já está em uso', 'data' => false]);
        }
        return response()->json(['msg' => 'Usuário disponível', 'data' => true]);
    }
    
    public function checkEmail(Request $request, $email){
        if(Validator::make(['email' => $email], ['email' => $this->authId($request) ? Rule::unique('user')->ignore($request->auth->email, 'email') : 'unique:user,email'])->fails()){
            return response()->json(['msg' => 'O email já está em uso', 'data' => false]);
        }
        return response()->json(['msg' => 'Email disponível', 'data' => true]);
    }
    
    public function checkInvite(Request $request, $invite){
        if(Validator::make(['invite' => $invite], ['invite' => 'exists:invite,id'])->fails()){
            return response()->json(['msg' => 'Código de autor inválido', 'data' => false]);
        }
        return response()->json(['msg' => 'Código de autor válido', 'data' => true]);
    }
    
    public function notifications(Request $request, $offset = 0){
        return response()->json(['msg' => 'Notificações do usuário', 'data' => Notification::show($this->authId($request), $offset)]);
    }
    
    public function list(UserList $request, $offset = 0){
        return response()->json(['msg' => "Lista de usuários", "data" => User::list($request, $offset)]);
    }
    
    private function authId($request){
        return $request->auth->userId ?? 0;
    }

}
