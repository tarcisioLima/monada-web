<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use App\Utils\Obscure;

class UserList extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'type'          => 'required|in:FOLLOWING,FOLLOWERS,FOLLOWED,LIKED,COMMENTED',
            'publicationId' => 'integer|exists:publication,id|nullable',
            'userId'        => 'integer|exists:user,id|nullable',
        ];

        return $rules;
    }
    
    protected function prepareForValidation(){
        $input = $this->all();
        $input['userId']        = Obscure::unuser($this->input('userId'));
        $input['publicationId'] = Obscure::unpublication($this->input('publicationId'));
        $this->replace($input);
    }
    
    public function messages()
    {
        $rules = [
            'type.required' => 'O tipo da lista é necessário',
            'type.in'  => 'Tipo de lista inválido',
            
            'publicationId.integer' => 'É preciso que o identificador da publicação seja um número inteiro',
            'publicationId.exists' => 'Identificador da publicação inexistente',
            
            'userId.integer' => 'É preciso que o identificador do usuário seja um número inteiro',
            'userId.exists' => 'Identificador do usuário inexistente',
        ];

        return $rules;
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}

