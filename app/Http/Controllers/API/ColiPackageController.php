<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ColiPackage;
use Illuminate\Http\Request;
use Throwable;

class ColiPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {   
            $coli_packages = ColiPackage::orderBy('id', 'desc')->get();

            return response()->json([
                'error'=>false,
                'message'=> 'Data received successfully', 
                'data'=>$coli_packages
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
        // return $request->items;
        try {
            $timestamp = time();
            $random_value = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,4);
            $random_value_timestamp = substr(str_shuffle($timestamp),1,3);
            $random =  $random_value . $random_value_timestamp;
            
            $otp = substr(str_shuffle($timestamp),1,6);

            $colis = ColiPackage::create([
                'otp' => $otp,
                'items' => $request->items,
                'weight' => $request->weight,
                'volume' => $request->volume,
                'description' => $request->description ? $request->description : '',
                'parcel_code' => $random,
                'user_id' => $request->user()->id,
                'sender' => $request->sender,
                'receives' => $request->receives,
                'price' => $request->price,
                'destination' => $request->destination,
                'package_id' => $request->package_id,
            ]);

            return response()->json([
                'error'=>false,
                'message'=> 'Colis created successfully', 
                'data'=>$colis
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
