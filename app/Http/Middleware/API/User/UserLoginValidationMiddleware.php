<?php

namespace App\Http\Middleware\API\User;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserLoginValidationMiddleware
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
        $validated = Validator::make($request->all(), [
            'username' => ['required','min:2','max:100'],
            'password' => ['required','min:8']
        ]);

        if($validated->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Please, correct errors',
                'error_message' => $validated->errors()
            ], 400);
        }
        
        return $next($request);
    }
}
