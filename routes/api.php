<?php

use App\Http\Controllers\API\ColiPackageController;
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
})->middleware('cors');


Route::prefix('v1')->group(function () {
    
    Route::prefix('')->middleware(['cors','auth:admin-api'])->group(function () {
        
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
            Route::get("/limit", [PackageController::class, 'getLimitedPackage']);
            Route::post("", [PackageController::class, 'store'])
                        ->middleware(['validation.package']);
            Route::put("/{id}", [PackageController::class, 'update'])
                    ->middleware(['validation.package']);  
        });

        //ColiParcel roads
        Route::prefix('/coli-parcel')->group(function () {
            Route::get("", [ColiPackageController::class, 'index']);
            Route::get("/{id}", [ColiPackageController::class, 'show']);
            Route::post("", [ColiPackageController::class, 'store'])
                    ->middleware(['validation.coli']);
            Route::put("/{id}", [ColiPackageController::class, 'update'])
                    ->middleware(['validation.coli']);                    
            Route::delete("/{id}", [ColiPackageController::class, 'destroy']);
        });

    });

    //Auth
    Route::post('/auth/login', [UserController::class, 'auth'])->middleware(['validation.auth.user']);

    // User roads
    Route::prefix('/check_parcel')->group( function () {
        Route::post("", [ParcelController::class, 'check_parcel']);
                    // ->middleware(['validation.user.add']);
    });
    // User check roads 
    Route::prefix('/check-coli')->group( function () {
        Route::post("", [ColiPackageController::class, 'check_colis']);
    });

});

Route::fallback(function () {
    return response()->json([
        'error' => true,
        'message' => 'Route not found'
    ], 404);
});