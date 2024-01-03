<?php

namespace App\Http\Middleware\API\RoutingTransMoney;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoutingTransMoneyMiddleware
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
            'name_type' => ['required', 'string', 'min:2'],
            'description_type' => ['required', 'string', 'min:2', 'max:300'],
            'percentage' => ['required', 'numeric', 'min:0'],
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
