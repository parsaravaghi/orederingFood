<?php

namespace App\Http\Controllers;

use App;
use App\Models\User;
use Auth;
use Cookie;
use Firebase\JWT\JWT;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class Authentication extends Controller
{
    //
    public function Register(Request $request)
    {
        $user = new \App\Models\User();

        try {
            // trying to create user 

            $inputs = $request->input;

            User::insert(["name" => $request->input("username") , "password" =>Hash::make($request->input("password")) , "email" => $request->input("email")]);
        } 
        catch (\Throwable $th) 
        {
            return new JsonResponse(["message"=>"this username is userd before"]);
        }

        return new JsonResponse(["message" => "user created successfully"]);
    }
    public function Login(Request $request)
    {
        //checking user is authenticated or not

        $res = Response();
        $key = env("public_key");
        $user = User::where("name" , $request->input("username"))->get();
        if($user->count())
        {
            $user = $user[0];
            if(Hash::check($request->input('password') , $user->password))
            {
                $jwt_token = JWT::encode(["userId" => $user->id] , $key);

                Auth::login($user);
                Cookie::forget("jwt-token");
                $cookie = Cookie::make("jwt-token" , $jwt_token , 60);
                Cookie::queue($cookie);
                return $res->json(["message" => "u logged in successfully"] , 202);

            }
            return new JsonResponse(["message" => "password is not valid"] , 406);
        }
        return new JsonResponse(["message" => "username is not valid"] , 406);
    }
    public function Logout(Request $request)
    {
        return new JsonResponse(["message" => "you logged out successfully"] , 202);
        
    }
    public function Test(Request $request)
    {
        if(Cookie::has("jwt-token"))
        {
            return new JsonResponse(["jwt-token" => Cookie::get("jwt-token")]);
        }
        return new JsonResponse(["mesage"=>"authentication error"]);
    }
}
