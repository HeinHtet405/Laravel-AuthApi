<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class SampleAuthController extends Controller
{
     public $successStatus = 200;

    public function login(){
    	if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
    		$user = Auth::user();
    		$success['name'] = $user->name;
    		$success['email'] = $user->email;
    		$success['created_at'] = $user->created_at->format('m/d/Y');
    		$success['updated_at'] = $user->updated_at->format('m/d/Y');
    	    return response()->json(['success' => $success], $this->successStatus);
    	} else {
    		return response()->json(['error' => 'Unauthorised'], 401);
    	}
    }

    public function register(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
        	return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        return response()->json(['success' => $user], $this->successStatus);
    }
}
