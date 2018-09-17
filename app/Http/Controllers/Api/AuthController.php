<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Device;
use App\Models\Author;
use App\Models\ResetPassword;
use Validator;
use App\Http\Requests\RegisterUser;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Utils\Obscure;

class AuthController extends Controller
{
    private $monadaToken, $ip, $platform;

    public function __construct(Request $request)
    {
        $this->monadaToken = uniqid(base64_encode(str_random(60)));
        $this->platform = $request->server('HTTP_USER_AGENT');
        $this->ip = $request->ip();
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)){
            $device = Device::where('platform', $this->platform)->where('ip', $this->ip)->where('userId', $user->id)->first();
            if($device){
                Device::where('id', $device->id)->update(['token' => $this->monadaToken, 'fcm' => $request->fcm, 'date' => date("Y-m-d H:i:s")]);
            }else{
                $device = new Device;
                $device->userId   = $user->id;
                $device->ip       = $this->ip;
                $device->fcm      = $request->fcm;
                $device->token    = $this->monadaToken;
                $device->platform = $this->platform;
                $device->save();
            }
            return response()->json(['msg' => "Logado", 'data' => ['token' => $this->monadaToken, 'user' => User::me($user->id)]]);
        }
        return response()->json(['msg' => "Email e/ou Senha estão incorretos", 'data' => null]);
    }

    public function register(RegisterUser $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        $user = User::create($request->all());
        $device = new Device;
        $device->userId   = $user->id;
        $device->ip       = $this->ip;
        $device->fcm      = $request->fcm;
        $device->token    = $this->monadaToken;
        $device->platform = $this->platform;
        $device->save();
        $data = array(
            'token'  => $device->token,
            'userId' => Obscure::user($user->id)
        );
        if($request->invite){
            if($authorId = Author::store($user->id, $request->invite)){
                $data['authorId'] = Obscure::author($authorId);
                return response()->json(['msg' => "Cadastrado com sucesso", 'data' => $data]);
            }
            return response()->json(['msg' => "Cadastrado, porém, houve uma falha ao gerarmos seu perfil de author.", 'data' => $data]);
        }
        return response()->json(['msg' => "Cadastrado com sucesso", 'data' => $data]);
    }

    public function logout(Request $request)
    {
        Device::destroy($request->auth->deviceId);
        return response()->json(['msg' => 'Deslogado']);
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user){
            $resetPassword = ResetPassword::where('email', $request->email)->first();
            if($resetPassword){
                ResetPassword::where('email', $request->email)->update(['token' => $this->monadaToken, 'date' => date("Y-m-d H:i:s")]);
            }else{
                ResetPassword::create(['email' => $request->email, 'token' => $this->monadaToken]);
            }
            Mail::to($request->email)->send(new ResetPasswordMail(['link' => url('reset-password/'.$this->monadaToken), 'name' => $user->name]));
            if(Mail::failures()){
                return response()->json(['msg' => 'Ocorreu um erro e não foi possível enviarmos o Email. Tente novamente']);
            }
            return response()->json(['msg' => 'O email para alteração de senha foi enviado!']);
        }
        return response()->json(['msg' => 'Não localizamos o email informado. Você o cadastrou?']);
    }

}
