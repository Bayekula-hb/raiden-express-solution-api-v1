<?php

namespace App\Http\Middleware\API\User;

use App\Models\TypeUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserIsAdminMiddleware
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
        $type_user = TypeUser::find([ 'id' => $request->user()->type_user_id]);

        if($type_user[0]->name_type != 'admin' && $type_user[0]->name_type != 'supervisor'){
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 400);
        }
        
        return $next($request);
    }
}
