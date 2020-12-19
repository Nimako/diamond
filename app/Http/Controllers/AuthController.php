<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Login(){

        $credentials = request(['email', 'password']);

        if(empty($credentials['email'])){
            return response()->json(['statusCode'=>500, 'message' => 'Username is required']);
        }
        if(empty($credentials['password'])){
            return response()->json(['statusCode'=>500, 'message' => 'Password is required']);
        }

        if (Auth::attempt($credentials)){
            $returnData = [
                         "fullName" => Auth()->User()->fullName,
                         "email"    => Auth()->User()->email,
                         "phoneNum" => Auth()->User()->phoneNum,
            ];

            return response()->json(['statusCode'=>200, "data"=>$returnData, 'message' => 'Login successfully']);

        }else{
            return response()->json(['statusCode'=>500, 'message' => 'invalid_credentials']);
        }

        return $this->respondWithToken($token);
    }


    
    public function signup(Request $request){

        $rules = [
            'email'            => "required|unique:customer_tbl",
            'firstName'        => "required",
            'lastName'         => "required",
            "phoneNum"         => "required|unique:customer_tbl|max:10",
            "password"         =>  "min:8",
            //'password'         => 'min:8|required_with:confirm_password|same:confirm_password',
            //'confirm_password' => 'min:8'
         ];
         $validator = Validator::make($request->all(), $rules);
         if($validator->fails()) {

            return response()->json(['statusCode'=>500, 'message' => $validator->errors()]);
         }

        $user = User::create([
            'id'       => Str::uuid(),
            'email'    => $request->email,
            'fullName' => $request->firstName." ".$request->lastName,
            'password' => Hash::make($request->password),
            'phoneNum' => $request->phoneNum,
            'idType'   => null,
        ]);

        if($user){
            return response()->json(['statusCode'=>200, 'message' => 'Success']);
        }else{
            return response()->json(['statusCode'=>500, 'message' => 'faild to to create a user']);
        }

    }


}
