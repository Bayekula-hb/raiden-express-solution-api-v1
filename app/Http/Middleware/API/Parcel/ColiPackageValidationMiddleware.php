<?php

namespace App\Http\Middleware\API\Parcel;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColiPackageValidationMiddleware
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
            'items' => ['required', 'min:3'],
            'weight' => ['required', 'string'],
            'volume' => ['required', 'string'],
            'description' => ['min:6'],
            'sender' => ['required', 'string', 'min:3'],
            'receives' => ['required', 'string', 'min:3'],
            'customer_id' => ['required', 'integer', 'min:1'],
            'typetransaction_id' => ['required', 'integer', 'min:1'],
            'destination' => ['required', 'string', 'min:2', 'max:100'],
            'using_raiden_point' => ['required', 'boolean'],
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
