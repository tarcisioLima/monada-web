<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $table = 'user';
    protected $fillable = ['name', 'email', 'password'];
    public $timestamps = false;
    
    public static function follow($users, $me){
        $data = array();
        foreach($users as $user){
            if($user == $me){
                return ['msg' => 'Você não pode você seguir a si próprio'];
            }
            if(DB::table('relation')->where('followerId', $me)->where('followingId', $user)->first()){
                return ['msg' => 'Você já está seguindo este usuário'];
            }
            if(User::find($user)){
                $data[] = ['followerId' => $me, 'followingId' => $user, 'muted' => false];
            }
        }
        if(empty($data)){
            return ['msg' => 'O usuário não existe'];
        }
        if(!DB::table('relation')->insert($data)){
            return ['msg' => 'Houve um erro ao seguir este usuário'];
        }
        return ['msg' => 'Usuário seguido com sucesso', 'data' => true];
    }
    
}
