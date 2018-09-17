<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\Obscure;

class StoreImageFolder extends FormRequest
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
            'folderId'    => 'required|integer|exists:folder,id',
            'monadaImage' => 'image|mimes:jpeg,jpg,png,gif|max:5000'
        ];
    }
    
    public function messages()
    {
        $rules = [
            'folderId.required' => 'Um identificador válido da pasta é necessário',
            'folderId.integer' => 'É preciso que o identificador da pasta inserido seja um número inteiro',
            'folderId.exists'  => 'A pasta inserida não foi encontrada em nosso sistema',
            
            'monadaImage.image' => 'A "imagem" não corresponde a um arquivo de imagem',
            'monadaImage.mimes' => 'A imagem não atende as extensões JPEG, JPG, PNG ou GIF',
            'monadaImage.max'   => 'Uma das imagens excedeu 5MB',
        ];

        return $rules;
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
