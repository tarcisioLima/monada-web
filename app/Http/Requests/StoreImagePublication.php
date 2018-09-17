<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use App\Utils\Obscure;

class StoreImagePublication extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    protected function prepareForValidation(){
        $input = $this->all();
        //$input['publicationId'] = Obscure::unfolder($this->input('publicationId'));
        $this->replace($input);
    }
    
    public function rules()
    {
        $rules = [
            //'publicationId' => 'integer|exists:folder,id',
            'monadaImage'   => 'image|mimes:jpeg,jpg,png,gif|max:5000'
        ];
        
        // if(DB::table('image')->where('publicationId', $this->input('publicationId'))->count() >= 5){
        //     $rules['imageLimit'] = 'required';
        // }

        return $rules;
    }
    
    public function messages()
    {
        $rules = [
            // 'imageLimit.required' => 'Está publicação já possui o limite de imagens que é 5',
            
            // 'publicationId.required' => 'Um identificador válido da publicação é necessário',
            // 'publicationId.integer' => 'É preciso que o identificador da publicação inserido seja um número inteiro',
            // 'publicationId.exists'  => 'A publicação inserida não foi encontrada em nosso sistema',
            
            'monadaImage.image' => 'A "imagem" não corresponde a um arquivo de imagem',
            'monadaImage.mimes' => 'A imagem não atende as extensões JPEG, JPG, PNG ou GIF',
            'monadaImage.max'   => 'Uma das imagens excedeu 5MB',
        ];

        return $rules;
    }
    
    protected function failedValidation(Validator $validator){ 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
