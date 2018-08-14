<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Author;
use Validator;

class UserController extends Controller
{
    public function follow(Request $request){
        if(is_array($request->users) && !empty($request->users) && array_product(array_map('is_numeric', $request->users)) && count($request->users) === count(array_flip($request->users))){
            return response()->json(User::follow($request->users, $request->auth->id));
        }
        return response()->json(['msg' => 'Os dados não foram inseridos corretamente']);
    }

}
