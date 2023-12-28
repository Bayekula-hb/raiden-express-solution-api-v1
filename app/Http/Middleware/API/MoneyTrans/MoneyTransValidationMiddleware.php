<?php

namespace App\Http\Middleware\API\MoneyTrans;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoneyTransValidationMiddleware
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
            'step' => ['required'],
            'amount_send' => ['required', 'string'],
            'costs' => ['required', 'string'],
            'receives' => ['required', 'string', 'min:3'],
            'customer_id' => ['required', 'integer', 'min:1'],
            'typetransaction_id' => ['required', 'integer', 'min:1'],
            'destination' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        if($validated->fails()){
            return response()->json([
                'error' => 'true',
                'message' => 'Please, you can check your data sending',
                'error_message' => $validated->errors()
            ], 422);
        }
        
        return $next($request);
    }
}
