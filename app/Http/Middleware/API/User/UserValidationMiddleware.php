<?php

namespace App\Http\Middleware\API\User;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidationMiddleware
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
            'first_name' => ['required', 'string','min:2', 'max:100'],
            'middle_name' => ['min:2', 'string','max:100'],
            'last_name' => ['required', 'string','min:2', 'max:100'],
            'phone_number' => ['required', 'min:10', 'max:15'],
            'email' => ['required', 'email', 'unique:users,email'],
            'gender' => ['required', 'max:1', 'in:M,F'],
            'type_user_id' => ['required', 'integer', 'min:1'],
            'password' => ['required','min:8']
        ]);

        if($validated->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Please, you can check your data sending and retry',
                'error_message' => $validated->errors()
            ], 400);
        }
        
        return $next($request);
    }
}
