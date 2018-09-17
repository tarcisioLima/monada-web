<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreFolder extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        return [
            'name' => 'required|string|max:100|'
        ];
    }
    
    public function messages()
    {
        return [
            'name.required'  => 'O nome é necessário',
            'name.string'    => 'O nome precisa possuir atributos de um texto',
            'name.max'       => 'O nome não pode exceder 100 caracteres',
        ];
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
