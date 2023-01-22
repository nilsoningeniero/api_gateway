<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        try{

            $user = new User;
            $user->name = $request->input('name');
            $user->email  = $request->input('email');
            $user->password  =  bcrypt($request->input('password'));
            $user->save();
            return $user;

        }catch(QueryException $ex){
            $error_code = $ex->errorInfo[0];
            $error_msg = $ex->getMessage();
            switch(intval($error_code))
            {
                case 23000: // Llave unique violada
                    return response()->json([
                        "status" => 409,
                        "msg" => "Error, El recurso que desea agregar ya existe ". $request->input('email'),
                        "cod_error" => $error_code
                    ], 500);
                break;
                default:
                return response()->json([
                    "status" => 500,
                    "msg" => "Error, comuníquese con el administrador del sistema ". $error_msg,
                    "cod_error" => $error_code
                ], 500);
                break;
            } 
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        return User::where('id', $user_id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->first();

        $request->validate([
            'name' => ['required'],
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => ['required']
        ]);

        try {

            $user->name = $request->input('name');
            $user->email  = $request->input('email');
            $user->password  =  bcrypt($request->input('password'));
        
            $user->save();
            return $user;

        }catch(QueryException $ex){
            $error_code = $ex->errorInfo[0];
            $error_msg = $ex->getMessage();
            switch(intval($error_code))
            {
                default:
                return response()->json([
                    "status" => 500,
                    "msg" => "Error, comuníquese con el administrador del sistema ". $error_msg,
                    "cod_error" => $error_code
                ], 500);
                break;
            } 
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $user = User::where('id', $user_id)->first();
        
        $user->delete();

        return response()->noContent();
    }
}
