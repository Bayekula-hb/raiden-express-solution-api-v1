<?php

use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\ParcelController;
use App\Http\Controllers\API\TypeUserController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (Request $request){
    return response()->json([
        'message' => 'Bienvenu sur l\'api de Raiden Express Solution',
        'version' => 'C\'est la version beta de cet API merci',
        'Developpeur' => 'Developper par hobedbayekula@gmail.com',
    ]);
});


Route::prefix('v1')->group(function () {
    
    Route::prefix('')->middleware('auth:admin-api')->group(function () {
        
        // TypeUser roads
        Route::prefix('/typeuser')->group( function () {
            Route::get("", [TypeUserController::class, 'index']);
            Route::post("", [TypeUserController::class, 'store'])
                        ->middleware(['validation.typeuser.add']);
        });
        
        // User roads
        Route::prefix('/user')->group( function () {
            Route::get("", [UserController::class, 'index']);
            Route::post("", [UserController::class, 'store'])
                        ->middleware(['validation.user.add']);
        });

        //Parcel roads
        Route::prefix('/parcel')->group(function () {
            Route::get("", [ParcelController::class, 'index']);
        });

        //Package roads
        Route::prefix('/package')->group(function () {
            Route::get("", [PackageController::class, 'index']);
        });

    });

    //Auth
    Route::post('/auth/login', [UserController::class, 'auth'])->middleware(['validation.auth.user']);

    // User roads
    Route::prefix('/check_parcel')->group( function () {
        Route::post("", [ParcelController::class, 'check_parcel']);
                    // ->middleware(['validation.user.add']);
    });

});

Route::fallback(function () {
    return response()->json([
        'error' => true,
        'message' => 'Route not found'
    ], 404);
});