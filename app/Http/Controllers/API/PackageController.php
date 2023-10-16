<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Throwable;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {   
            $parcels = Package::orderBy('id', 'desc')->get();

            return response()->json([
                'error'=>false,
                'message'=> 'Data received successfully', 
                'data'=>$parcels
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'data' => $e,
            ], 400);
        }
    }

    public function getLimitedPackage()
    {
        try {   
            $parcels = Package::orderBy('id', 'desc')->limit(10)->get();

            return response()->json([
                'error'=>false,
                'message'=> 'Data received successfully', 
                'data'=>$parcels
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'data' => $e,
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $package = Package::create([
                'name_package' => $request->name_package,
                'destination_package' => $request->destination_package,
                'description' => $request->description,
                'departure_date' => $request->departure_date,
                'arrival_date' => $request->arrival_date,
                'step' =>  $request->step,
            ]);

            return response()->json([
                'error'=>false,
                'message'=> 'Package created successfully', 
                'data'=>$package
            ], 200); 
        } catch (Throwable $e) {
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'data' => $e,
            ], 400);        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if(intval($id, 10) != 0) {
                $package = Package::find($id);
                if(!$package){
                    return response()->json([
                        'error'=>true,
                        'message' => 'Request failed, this package is not found.',
                    ], 400); 
                }else {
                    $package->name_package = $request->name_package;
                    $package->destination_package = $request->destination_package;
                    $package->description = $request->description;
                    $package->departure_date = $request->departure_date;
                    $package->arrival_date = $request->arrival_date;
                    $package->step = $request->step;

                    $package->save();

                    return response()->json([
                        'error'=>false,
                        'message'=> 'Package Updated successfully', 
                        'data'=>$package
                    ], 200);
                }
            }else{
                return response()->json([
                    'error'=>true,
                    'message' => 'Request failed, your parameter is not correct',
                ], 400); 
            }            
        } catch (Throwable $th) {
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'info' => $th,
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
