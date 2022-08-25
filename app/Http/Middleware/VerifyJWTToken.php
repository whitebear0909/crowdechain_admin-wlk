<?php

namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $token = $request->header('token')?$request->header('token'):($request->input('token')?$request->input('token'):$request->cookie('token'));
            $user = JWTAuth::toUser($token);
        } catch (JWTException $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error'=> ['code' => 'GEN-WRONG-ARGS', 'http_code' => 401, 'message' => 'Your token is expired']], $e->getStatusCode());
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error'=> ['code' => 'GEN-WRONG-ARGS', 'http_code' => 400, 'message' => 'The token is invalid']], $e->getStatusCode());
            }else{
                return response()->json(['error'=> ['code' => 'GEN-WRONG-ARGS', 'http_code' => 401, 'message' => 'Token is required']]);
            }
        }
       return $next($request);
    }
}