<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RoutingTransMoney;
use Illuminate\Http\Request;
use Throwable;

class RoutingTransMoneyController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {   
            $routing_trans_money = RoutingTransMoney::orderBy('id', 'desc')->get();

            return response()->json([
                'error'=>false,     
                'message'=> 'Data received successfully', 
                'data'=>$routing_trans_money
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
                $routing_trans_money = RoutingTransMoney::find($id);

                return response()->json([
                    'error'=>false,
                    'message' => 'Routing Transaction Money found with successfully',
                    'data'=>$routing_trans_money
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $routing_trans_money = RoutingTransMoney::create([
                'name_routing_trans' => $request->name_type,
                'description_routing_trans' => $request->description_type,
                'percentage_routing_trans' => $request->percentage,
            ]);

            return response()->json([
                'error'=>false,
                'message'=> 'Routing Trans Money created successfully', 
                'data'=>$routing_trans_money
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
                $routing_trans_money = RoutingTransMoney::find($id);
                $user = $request->user();

                if(!$routing_trans_money){
                    return response()->json([
                        'error'=>true,
                        'message' => 'Request failed, this Routing Transaction Money is not found.',
                    ], 400); 
                }else{
                    if($routing_trans_money->user_id == $user->id || $user->type_user_id == (1 || 2)) {
                        
                        $routing_trans_money->name_routing_trans = $request->name_type;
                        $routing_trans_money->description_routing_trans = $request->description_type;
                        $routing_trans_money->percentage_routing_trans = $request->percentage;

                        $routing_trans_money->save();

                        return response()->json([
                            'error'=>false,
                            'message'=> 'Routing Transaction Money Updated successfully', 
                            'data'=>$routing_trans_money
                        ], 200);
                    }else{
                        return response()->json([
                            'error'=>true,
                            'message'=> 'You can\'t to updated this Routing Transaction Money',
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
