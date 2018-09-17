<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $data = [
            'name'        => 'required|max:40|regex:/(^[A-Za-z ]+$)+/',
            'username'    => ['required','regex:/(^[A-Za-z_]+$)+/','max:20',Rule::unique('user')->ignore($this->input('auth')->username, 'username')],
            'email'       => ['required','email','max:191',Rule::unique('user')->ignore($this->input('auth')->email, 'email')],
            'removeImage' => 'boolean'
        ];
        
        if($this->input('auth')->authorId){
            $data['bio']       = 'string|max:191|nullable';
            $data['site']      = 'max:191|regex:/^(https?:\/\/)*[a-z0-9-]+(\.[a-z0-9-]+)+(\/[a-z0-9-]+)*\/?$/';
            $data['gab']       = 'max:191|regex:/(^[A-z0-9_-]+$)+/';
            $data['youtube']   = 'max:191|regex:/(^[A-z0-9._-]+$)+/';
            $data['facebook']  = 'max:191|regex:/(^[A-z0-9.]+$)+/';
            $data['instagram'] = 'max:191|regex:/(^[A-z0-9_]+$)+/';
            $data['twitter']   = 'max:191|regex:/(^[A-z0-9_]+$)+/';
        }
        
        return $data;
    }
    
    public function messages()
    {
        return [
            'removeImage.boolean'  => 'É preciso que o campo que indica a remoção da imagem seja verdadeiro ou falso',
            
            'name.required'  => 'O nome é necessário',
            'name.regex'     => 'O nome necessita somente de letras',
            'name.max'       => 'O nome não pode exceder 40 caracteres',
            
            'username.required' => 'O usuário é necessário',
            'username.regex'    => 'O usuário aceita somente letras, numeros e _',
            'username.max'      => 'O usuário não pode exceder 20 caracteres',
            'username.unique'   => 'Este usuário já está em uso',
            
            'email.required' => 'O email é necessário',
            'email.email'    => 'Digite um email válido',
            'email.max'      => 'O email não pode exceder 191 caracteres',
            'email.unique'   => 'Este email já está em uso',
            
            'bio.string' => 'A biografia deve obedecer o formato texto',
            'bio.max'    => 'A biografia não pode exceder 191 caracteres',
            
            'site.regex' => 'O site precisa ser válido',
            'site.max'   => 'O site não pode exceder 191 caracteres',
            
            'gab.regex' => 'O nome de usuário do GAB precisa ser válido',
            'gab.max'   => 'O GAB não pode exceder 191 caracteres',
            
            'youtube.regex' => 'O nome de usuário do Youtube precisa ser válido',
            'youtube.max'   => 'O Youtube não pode exceder 191 caracteres',
            
            'facebook.regex' => 'O nome de usuário do facebook precisa ser válido',
            'facebook.max'   => 'O Facebook não pode exceder 191 caracteres',
            
            'instagram.regex' => 'O nome de usuário do instagram precisa ser válido',
            'instagram.max'   => 'O Instagram não pode exceder 191 caracteres',
            
            'twitter.regex' => 'O nome de usuário do twitter precisa ser válido',
            'twitter.max'   => 'O Twitter não pode exceder 191 caracteres',
        ];
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
    
}
