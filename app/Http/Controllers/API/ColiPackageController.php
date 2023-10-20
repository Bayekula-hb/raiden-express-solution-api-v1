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
        try {
            if(intval($id, 10) != 0) {
                $coli_package = ColiPackage::find($id);

                return response()->json([
                    'error'=>false,
                    'message' => 'Coli package found with successfully',
                    'data'=>$coli_package
                ], 200);
            }else{
                return response()->json([
                    'error'=>true,
                    'message' => 'Request failed, your parameter is not correct',
                ], 200); 
            }
        }catch (Throwable $th) {
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'info' => $th,
            ], 400); 
        }
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
                $coli_package = ColiPackage::find($id);
                $user = $request->user();

                if(!$coli_package){
                    return response()->json([
                        'error'=>true,
                        'message' => 'Request failed, this Colis is not found.',
                    ], 400); 
                }else{

                    if($coli_package->user_id == $user->id || $user->type_user_id == (1 || 2)) {
                        
                        $coli_package->items = $request->items;
                        $coli_package->weight = $request->weight;
                        $coli_package->volume = $request->volume;
                        $coli_package->description = $request->description;
                        $coli_package->sender = $request->sender;
                        $coli_package->receives = $request->receives;
                        $coli_package->price = $request->price;
                        $coli_package->destination = $request->destination;
                        $coli_package->package_id = $request->package_id;

                        $coli_package->save();

                        return response()->json([
                            'error'=>false,
                            'message'=> 'Coli-Package Updated successfully', 
                            'data'=>$coli_package
                        ], 200);
                    }else{
                        return response()->json([
                            'error'=>true,
                            'message'=> 'You can\'t to updated this coli package',
                        ], 404);
                    }  
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
    public function destroy(Request $request, $id)
    {
        try {
            if(intval($id, 10) != 0) {
                $coli_package = ColiPackage::find($id);
                $user = $request->user();

                if(!$coli_package){
                    return response()->json([
                        'error'=>true,
                        'message' => 'Request failed, this edition is not found.',
                    ], 400); 
                }else{
                    if($coli_package->user_id == $user->id || $user->type_user_id == (1 || 2)) {
                        $coli_package->delete();
                        return response()->json([
                            'error'=>false,
                            'message'=> 'Edition Deleted successfully', 
                            'data'=>$coli_package
                        ], 200);
                    }else{
                        return response()->json([
                            'error'=>true,
                            'message'=> 'You can\'t to updated this coli package',
                        ], 404);
                    }  
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

    
    public function check_colis(Request $request)
    {
        try {
            $check_coli_package = ColiPackage::where('parcel_code', $request->code_parcel)
            ->join('packages', 'packages.id', '=', 'coli_packages.package_id')->first();

            if(!$check_coli_package){
                $check_coli_by_item = ColiPackage::join('packages', 'packages.id', '=', 'coli_packages.package_id')->get();
                    
                function objectToArray ($object) {
                    if(!is_object($object) && !is_array($object))
                        return $object;
                    return array_map('objectToArray', (array) $object);
                }
                foreach ($check_coli_by_item as $key => $item) {

                    $object = substr(objectToArray($item['items']), 1, -1);
                    $array_object = preg_split('/}",/', $object, -1, PREG_SPLIT_DELIM_CAPTURE);
                    $length_array = count($array_object);                     
                    
                    if($length_array > 1){
                        foreach ($array_object as $key => $value) {

                            $value_in_object = "";

                            if($key == $length_array-1){
                                $value_clean = preg_replace('/\\\"/i', '"', $value);
                                $value_clean = substr($value_clean, 2);
                                $value_clean = rtrim($value_clean, '"');
                                $value_in_object = $value_clean;
                            }else {
                                $value_clean = substr_replace($value, '}"', strlen($value), 0);
                                $value_clean = preg_replace('/\\\"/i', '"', $value_clean);
                                $value_clean = substr($value_clean, 1);
                                $value_clean = rtrim($value_clean, '"');
                                $value_clean = trim($value_clean, '"');
                                $value_in_object = $value_clean;
                            }   

                            if (strpos($value_in_object, $request->code_parcel) !== false) {
                                return response()->json([
                                    'error'=>false,
                                    'message' => 'This item is found.', 
                                    'is_item' => true, 
                                    'data'=>$value_in_object,
                                    'pacakge_info' => ([
                                        "step" => $item['step'],
                                        "destination" => $item['destination'],
                                        "sender" => $item['sender'],
                                    ])

                                ], 200); 
                            } 
                        }
                    }else {
                        $value_in_object = "";

                        $value_clean = preg_replace('/\\\"/i', '"', $object);
                        $value_clean = substr($value_clean, 1);
                        $value_clean = rtrim($value_clean, '"');
                        $value_in_object = $value_clean;

                        if (strpos($value_in_object, $request->code_parcel) !== false) {
                            return response()->json([
                                'error'=>false,
                                'message' => 'This item is found.', 
                                'is_item' => true, 
                                'data'=>$value_in_object,
                                'pacakge_info' => ([
                                    "step" => $item['step'],
                                    "destination" => $item['destination'],
                                    "sender" => $item['sender'],
                                ])

                            ], 200); 
                        }
                    }
                                        
                }
                return response()->json([
                    'error'=>false,
                    'message' => 'This package is not found.', 
                    'data'=>$check_coli_package
                ], 200); 
            }else{  
                return response()->json([
                    'error'=>false,
                    'message'=> 'Parcel found with successfully', 
                    'is_item' => false, 
                    'data'=>$check_coli_package
                ], 200);
            }
            
        } catch (Throwable $th) {
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'info' => $th,
            ], 400); 
        }
    }
}
