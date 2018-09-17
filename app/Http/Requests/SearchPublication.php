<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class SearchPublication extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if(!$this->input('term') &&
        !$this->input('author') &&
        !$this->input('since') &&
        !$this->input('until') &&
        !$this->input('authorId') &&
        !$this->input('folderId') &&
        empty($this->input('category'))){
            return ['searchEmpty' => 'required'];
        }
        
        $rules = [
            'term'        => 'max:191|string|nullable',
            'author'      => 'max:40|string|nullable',
            'since'       => 'date',
            'until'       => 'date',
            'category'    => 'array',
            'folderId'    => 'integer',
            'authorId'    => 'integer',
            //'category.*'  => 'exists:category,id|distinct'
        ];

        return $rules;
    }
    
    public function messages()
    {
        $rules = [
            'term.max'    => 'O termo não pode exceder 191 caracteres',
            'term.string' => 'O termo precisa ser um texto',
            
            'author.max'    => 'O autor não pode exceder 40 caracteres',
            'author.string' => 'O autor precisa ser um texto',

            'searchEmpty.required' => 'A pesquisa está vazia',
            
            'since.date' => 'A data "de" necessita ser correspondente a uma data',
            'until.date' => 'A data "até" necessita ser correspondente a uma data',

            'category.array' => 'É preciso que a categoria seja uma lista de categoria(as)',
            
            'folderId.integer' => 'É preciso que o identificador da pasta seja um número inteiro',
            
            'authorId.integer' => 'É preciso que o identificador do autor seja um número inteiro',
        ];

        return $rules;
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
