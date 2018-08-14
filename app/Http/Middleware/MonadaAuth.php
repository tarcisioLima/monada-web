<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;

class MonadaAuth
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if($token){
            $auth = Device::join('user', 'device.userId', '=', 'user.id')
                        ->leftjoin('author', 'user.id', '=', 'author.userId')
                        ->where('token', $token)
                        ->first(['name', 'email', 'token', 'user.id', 'device.id AS deviceId', 'author.id AS authorId', 'author.username', 'author.image']);
            if($auth){
                $request->merge(compact('auth'));
                return $next($request);
            }
        }
        return response()->json([
            'msg' => 'Autenticação inválida para esta API.',
        ], 401);
    }
}


