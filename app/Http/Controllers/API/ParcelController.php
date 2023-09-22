<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Parcel;
use Illuminate\Http\Request;
use Throwable;
class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function check_parcel(Request $request)
    {
        try {
            $check_parcel = Parcel::find($request->code_parcel);

            if(!$check_parcel){
                return response()->json([
                    'error'=>false,
                    'message' => 'This parcel is not found.', 
                    'data'=>$check_parcel
                ], 200); 
            }else{  
                return response()->json([
                    'error'=>false,
                    'message'=> 'Parcel found with successfully', 
                    'data'=>$check_parcel
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
