<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TypeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {   
            $users = User::all();

            return response()->json([
                'error'=>false,
                'message'=> 'Data received successfully', 
                'data'=>$users
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
            $typeuser_found = TypeUser::all()->where('id', '=', $request->type_user_id);
            
            if( sizeof($typeuser_found) > 0 ){


                // On crée un nouvel utilisateur
                $user = User::create([
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'type_user_id' => $request->type_user_id,
                    'phone_number' => $request->phone_number,
                    'password' => Hash::make($request->password),
                    'gender' => $request->gender,
                ]);

                // On retourne les informations du nouvel utilisateur en JSON
                return response()->json([
                    'error'=>false,
                    'message'=> 'User created successfully', 
                    'data'=>$user
                ], 200); 
            }else{
                return response()->json([
                    'error'=>true,
                    'message' => 'Le type d\'utilisateur ayant cet id : ' . $request->type_user_id .' , n\'existe pas',
                ], 400); 
            }
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