<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUser extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'     => 'required|max:40|regex:/(^[A-Za-z ]+$)+/',
            'email'    => 'required|email|max:191|unique:user',
            'username' => 'required|max:20|unique:user',
            'password' => 'required|max:30|min:6',
            'term'     => 'required|boolean|in:1',
            'fcm'      => 'max:191',
            'invite'   => 'exists:invite,id|nullable',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required'  => 'O nome é necessário',
            'name.regex'     => 'O nome necessita somente de letras',
            'name.max'       => 'O nome não pode exceder 40 caracteres',
            
            'email.required' => 'O email é necessário',
            'email.email'    => 'Digite um email válido',
            'email.max'      => 'O email não pode exceder 191 caracteres',
            'email.unique'   => 'Este email já está em uso',
            
            'username.required' => 'O nome de usuário é necessário',
            'username.max'      => 'O nome de usuário não pode exceder 20 caracteres',
            'username.unique'   => 'Este nome de usuário já está em uso',
            
            'password.required' => 'A senha é necessário',
            'password.min'      => 'A senha precisa no mínimo de 6 caracteres',
            'password.max'      => 'A senha não pode exceder 30 caracteres',
            
            'term.required' => 'É necessário o campo que indique a resposta aos termos e condições de uso',
            'term.boolean'  => 'É preciso que a resposta aos termos e condições de uso seja verdadeiro ou falso',
            'term.in'       => 'É preciso que você concorde com os termos e condições de uso',
            
            'fcm.max'      => 'O token FCM disponibilizado pelo Device não pode exceder 191 caracteres',
            
            'invite.exists' => 'O convite de autor inserido é inválido',
        ];
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
