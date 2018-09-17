<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;

class MonadaAuthorAuth
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if($token){
            $auth = Device::join('user', 'device.userId', '=', 'user.id')
                        ->join('author', 'user.id', '=', 'author.userId')
                        ->where('token', $token)
                        ->first(['name', 'email', 'token', 'user.id AS userId', 'device.id AS deviceId', 'author.id AS authorId', 'user.username', 'user.image']);
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
