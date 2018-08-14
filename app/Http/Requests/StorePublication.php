<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class StorePublication extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->input('title') && (!$this->input('description') && !$this->input('link') && !$this->input('images'))){
            return ['onlyTitleNotPossible' => 'required'];
        }
        if(!$this->input('title') && !$this->input('description') && !$this->input('link') && !$this->input('images')){
            return ['publicationEmpty' => 'required'];
        }
        $rules = [
            'title'       => 'max:100|string',
            'description' => 'string',
            'link'        => 'max:191|url',
            'category'    => 'array|max:3',
            'category.*'  => 'exists:category,id|distinct',
            'folderId'    => 'integer|exists:folder,id',
            'draft'       => 'boolean',
            'images'      => 'max:5',
            'images.*'    => 'image|mimes:jpeg,jpg,png,gif|max:5000'
        ];

        return $rules;
    }
    
    public function messages()
    {
        $rules = [
            'title.max'      => 'O título não pode exceder 100 caracteres',
            'title.string'   => 'O título precisa ser um texto',
            
            'onlyTitleNotPossible.required' => "O título precisa estar acompanhado pela descrição ou por uma mídia",
            'publicationEmpty.required' => 'A sua publicação está vazia',
            
            'description.string' => 'A descrição precisa ser um texto',
            
            'link.url' => 'A url precisa ser válida',
            'link.max' => 'O link não pode exceder 191 caracteres',
            
            'category.max'       => 'Você pode colocar no máximo 3 categorias',
            'category.array'      => 'É preciso que a categoria seja uma lista de categoria(as)',
            'category.*.exists'   => 'Uma das categorias não foi encontrada em nosso sistema',
            'category.*.distinct' => 'Uma das categorias está sendo repetida',
            
            'folderId.integer' => 'É preciso que o identificador da pasta selecionada seja um número inteiro',
            'folderId.exists'  => 'A pasta selecionada não foi encontrada em nosso sistema',
            
            'images.max'    => 'Você pode colocar no máximo 5 imagens',
            'images.*.image' => 'Uma das "imagens" não correspondem a um arquivo de imagem',
            'images.*.mimes' => 'Uma das imagens não atendem as extensões JPEG, JPG, PNG ou GIF',
            'images.*.max'   => 'Uma das imagens excedeu 5MB',
        
            'draft.boolean' => 'É preciso que a opção de rascunho seja verdadeiro ou falso',
        ];

        return $rules;
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
