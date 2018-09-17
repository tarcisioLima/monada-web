<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\Obscure;
use Illuminate\Support\Facades\DB;

class StoreFollow extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $data = [
            'users'       => 'array',
            'users.*'     => 'exists:user,id|distinct'
        ];
        
        if(DB::table('relation')->where('followerId', $this->input('auth')->userId)
           ->whereIn('followingId', $this->input('users'))->first()){
            $data['followed'] = 'required';
        }
        foreach($this->input('users') as $user)
            if($user == $this->input('auth')->userId) $data['yourself'] = 'required';
        
        return $data;
    }
    
    protected function prepareForValidation(){
        $input = $this->all();
        $input['users'] = array_map(function($x){
            return Obscure::unuser($x);
        }, $this->input('users') ? $this->input('users') : []);
        $this->replace($input);
    }
    
    public function messages()
    {
        $rules = [
            'followed.required'   => 'O usuário já é seguido',
            'yourself.required'   => 'Você não pode seguir si próprio',
            
            'users.array'      => 'É preciso que o campo usuários seja uma lista',
            'users.*.exists'   => 'Um dos usuários inseridos não foi encontrado em nosso sistema',
            'users.*.distinct' => 'Uma dos usuários está sendo repetido',
        ];

        return $rules;
    }
    
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    }
}
