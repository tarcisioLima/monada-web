<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\Obscure;
use Illuminate\Validation\Rule;

class UpdatePublication extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->input('title') && (!$this->input('description') && !$this->input('link') && empty($this->input('images')))){
            return ['onlyTitleNotPossible' => 'required'];
        }
        if(!$this->input('title') && !$this->input('description') && !$this->input('link') && empty($this->input('images'))){
            return ['publicationEmpty' => 'required'];
        }
        // foreach($this->input('images') as $imageId){
        //     if(DB::table('image')->whereIn('id', $imageId)->whereNotNull('publicationId')->exists()){
        //         return ['usedImage' => 'required'];
        //     }
        // }
        // if(DB::table('image')->whereIn('id', $this->input('images'))->whereNotNull('publicationId')->exists()){
        //     return ['usedImage' => 'required'];
        // }
        $id = $this->input('id');
        $authorId = $this->input('auth')->authorId;
        $rules = [
            'id'          => ['required','integer', Rule::exists('publication')
                                ->where(function ($query) use ($id)       { $query->where('id', $this->input('id'));})
                                ->where(function ($query) use ($authorId) { $query->where('authorId', $this->input('auth')->authorId);})
                             ],
            'title'       => 'nullable|max:100|string',
            'description' => 'nullable|string',
            'link'        => 'max:191',
            'category'    => 'array|max:3',
            'category.*'  => 'exists:category,id|distinct',
            'folderId'    => 'nullable|integer|exists:folder,id',
            'draft'       => 'boolean',
            'images'      => 'array|max:5',
            'images.*'    => ['distinct', Rule::exists('image', 'id')
                                ->where(function ($query) use ($id){
                                    $query->whereNull('publicationId')
                                          ->orWhere('publicationId', $id);
                                })
                             ],
        ];

        return $rules;
    }
    
    protected function prepareForValidation(){
        $input = $this->all();
        $input['images']   = array_map(function($x){
                                return Obscure::unimage($x);
                             }, $this->input('images') ? $this->input('images') : []);
        $input['folderId'] = Obscure::unfolder($this->input('folderId'));
        $input['id']       = Obscure::unpublication($this->input('id'));
        $this->replace($input);
    }
    
    public function messages()
    {
        $rules = [
            'id.integer'  => 'É preciso que o identificador da publicação selecionada seja um número inteiro',
            'id.required' => 'O identificador da publicação é necessário',
            'id.exists'   => 'O identificador da publicação não foi encontrado em sua lista de publicações',
            
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
        
            'draft.boolean' => 'É preciso que a opção de rascunho seja verdadeiro ou falso',
            
            'images.max'        => 'Você pode colocar no máximo 5 imagens',
            'images.array'      => 'É preciso que o campo imagem seja uma lista de imagens',
                'images.*.exists'   => 'Uma das imagens não está disponível em nosso sistema',
            'images.*.distinct' => 'Uma das imagens está sendo repetida',
        ];

        return $rules;
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
