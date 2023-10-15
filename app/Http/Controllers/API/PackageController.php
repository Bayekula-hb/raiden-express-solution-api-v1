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
        // $step_cleaning = str_replace("'", "\"" , $request->step);
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
        //
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
