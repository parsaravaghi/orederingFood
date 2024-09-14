<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Cookie;
use Firebase\JWT\JWT;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // skiping when request method is get
        if(request()->method() == "GET" ) return $next($request);

        // getting public key from env file
        $key = env("public_key");

        $wrongMessage = new JsonResponse( ["message" => "jwt token is wrong"]  , 403);

        try 
        {
            // checking for is jwt header valid or not
            $jwt_result = JWT::decode($request->header("jwt-token"), $key, array('HS256', 'HS384', 'HS512', 'RS256', 'RS384', 'RS512'));
        } 
        catch (\Throwable $th) 
        {
            Cookie::forget("jwt-token");
            Cookie::queue( Cookie::forget("jwt-token") );
            $token = JWT::encode([ "userId" =>null] , $key );
            Cookie::queue(Cookie::make("jwt-token" , $token , 500));

            return $wrongMessage;
        }

        return $next($request);
    }
}
