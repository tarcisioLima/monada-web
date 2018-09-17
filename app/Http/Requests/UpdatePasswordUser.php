<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UpdatePasswordUser extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {   
        $data = [
            'newPassword' => 'required|max:30|min:6'
        ];
        if(!Hash::check($this->input('password'), DB::table('user')->where('id', $this->input('auth')->userId)->value('password'))){
            $data['incorrectPassword'] = 'required';
        }
        return $data;
    }
    
    public function messages()
    {
        return [
            
            'newPassword.required' => 'A nova senha é necessário',
            'newPassword.min'      => 'A nova senha precisa no mínimo de 6 caracteres',
            'newPassword.max'      => 'A nova senha não pode exceder 30 caracteres',
            
            'incorrectPassword.required' => 'A sua senha atual está incorreta'
        ];
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
