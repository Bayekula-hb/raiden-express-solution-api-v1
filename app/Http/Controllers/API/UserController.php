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
     * Store a newly update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        try {
        
            $user = User::find([
                'id' => $request->user()->id,
            ])->first();
            
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'error'=>false,
                'message'=> 'Password updated successfully', 
                'data'=>$user
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
    public function signup(Request $request)
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
                    'type_user_id' => 4,
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
        try {
            if(intval($id, 10) != 0) {
                $coli_package = User::find($id);

                return response()->json([
                    'error'=>false,
                    'message' => 'User is found with successfully',
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

    public function auth(Request $request)
    {
        try {
            $user_find = User::where('email', $request->username)->orWhere('first_name', $request->username)->first();
            
            if( $user_find){
                if (Hash::check($request->password, $user_find->password)) {
 
                    $token = $user_find->createToken($user_find->email);

                    return response()->json([
                        'error'=>false,
                        'message'=> 'User is logging successful', 
                        'data'=>[
                           'token' => $token->plainTextToken,
                           'name' => $token->accessToken->name,
                           'first_name' => $user_find->first_name,
                           'last_name' => $user_find->last_name,
                           'phone_number' => $user_find->phone_number,
                           'email' => $user_find->email,
                           'gender' => $user_find->gender,
                           'id' => $user_find->id,
                           'type_account' => $user_find->type_user_id,
                           'raiden_point' => $user_find->raiden_point,
                        ], 
                    ], 200);
                } else {
                    return response()->json([
                        'error'=>true,
                        'message'=> 'The password is incorrect', 
                    ], 400);
                }
            }else{
                return response()->json([
                    'error'=>true,
                    'message'=> 'This user is not found : '.$request->username, 
                ], 400);

            }
        } catch (Throwable $e) {

            return response()->json([
                'error'=>true,
                'message'=> 'Something went wrong, please try again',
            ], 400);
        }
    }
}
