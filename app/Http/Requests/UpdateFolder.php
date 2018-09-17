<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\Obscure;

class UpdateFolder extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    protected function prepareForValidation(){
        $input = $this->all();
        $input['folderId'] = Obscure::unfolder($this->input('folderId'));
        $this->replace($input);
    }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:100|',
            'removeImage' => 'boolean',
            'folderId'    => 'required|integer|exists:folder,id'
        ];
    }
    
    public function messages()
    {
        return [
            'folderId.required' => 'Um identificador válido da pasta é necessário',
            'folderId.integer'  => 'É preciso que o identificador da pasta inserido seja um número inteiro',
            'folderId.exists'   => 'A pasta inserida não foi encontrada em nosso sistema',
            
            'removeImage.boolean'  => 'É preciso que o campo que indica a remoção da imagem seja verdadeiro ou falso',
            
            'name.required'  => 'O nome é necessário',
            'name.string'    => 'O nome precisa possuir atributos de um texto',
            'name.max'       => 'O nome não pode exceder 100 caracteres',
        ];
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}