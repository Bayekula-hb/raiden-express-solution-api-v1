<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TypeTransaction;
use Illuminate\Http\Request;
use Throwable;

class TypeTransactionController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {   
            $type_transactions = TypeTransaction::orderBy('id', 'desc')->get();

            return response()->json([
                'error'=>false,
                'message'=> 'Data received successfully', 
                'data'=>$type_transactions
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
            $type_transaction = TypeTransaction::create([
                'name_type' => $request->name_type,
                'description_type' => $request->description_type,
                'percentage' => $request->percentage,
            ]);

            return response()->json([
                'error'=>false,
                'message'=> 'Type Transaction created successfully', 
                'data'=>$type_transaction
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
                $type_transaction = TypeTransaction::find($id);
                $user = $request->user();

                if(!$type_transaction){
                    return response()->json([
                        'error'=>true,
                        'message' => 'Request failed, this Type transaction is not found.',
                    ], 400); 
                }else{
                    if($type_transaction->user_id == $user->id || $user->type_user_id == (1 || 2)) {
                        
                        $type_transaction->name_type = $request->name_type;
                        $type_transaction->description_type = $request->description_type;
                        $type_transaction->percentage = $request->percentage;

                        $type_transaction->save();

                        return response()->json([
                            'error'=>false,
                            'message'=> 'Type Transaction Updated successfully', 
                            'data'=>$type_transaction
                        ], 200);
                    }else{
                        return response()->json([
                            'error'=>true,
                            'message'=> 'You can\'t to updated this Type Transaction',
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
}
