<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if ($request->bearerToken()==null) {
                return response()->json(["status"=>401,'message' => "Invalid token or token not found","data"=>[]], 401);
            }
            $user = User::where('remember_token',$request->bearerToken())->first();
            if (!$user) {
                return response()->json(["status"=>401,'message' => "Invalid token or token not found","data"=>[]], 401);
            }

            $request['userId'] = $user->id;

        } catch (Exception $e) {
            return response()->json(["status"=>401,'message' => "Invalid token or token not found","data"=>[]], 401);
        }
        return $next($request);
    }
}
