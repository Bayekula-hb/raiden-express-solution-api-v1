<?php

namespace App\Http\Middleware\API\Package;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageValidationMiddleware
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
            'name_package' => ['required', 'min:3', 'max:100'],
            'destination_package' => ['required', 'string', 'min:2', 'max:100'],
            'description' => ['min:6'],
            'departure_date' => ['required', 'date'],
            'arrival_date' => ['required', 'date'],
            'step' => ['required', 'string', 'min:3'],
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
