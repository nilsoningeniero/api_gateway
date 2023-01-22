<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\ExceptionServer;
use Illuminate\Database\QueryException;

use App\Models\User;
use Illuminate\Support\Facades\Hash;



class LoginController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'            
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "status" => 1,
            "msg" => "¡Registro de usuario exitoso!",
        ]);    
    }


    public function login(Request $request) {

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        try {
            $user = User::where("email", "=", $request->email)->first();

            if( isset($user->id) ){
                if(Hash::check($request->password, $user->password)){
                    //creamos el token
                    $token = $user->createToken("auth_token")->plainTextToken;
                    //si está todo ok
                    return response()->json([
                        "status" => 1,
                        "msg" => "¡Usuario logueado exitosamente!",
                        "access_token" => $token
                    ]);        
                }else{
                    return response()->json([
                        "status" => 0,
                        "msg" => "La password es incorrecta",
                    ], 404);    
                }

            }else{
                return response()->json([
                    "status" => 0,
                    "msg" => "Usuario no registrado",
                ], 404);  
            }
        }catch(QueryException $ex){
            $error_code = $ex->errorInfo[0];
            $error_msg = $ex->getMessage();

            return response()->json([
                "status" => 500,
                "msg" => "Error, comuníquese con el administrador del sistema ". $error_msg,
                "cod_error" => $error_code
            ], 500); 
            
        }
        
    }

    public function userProfile() {
        return response()->json([
            "status" => 1,
            "msg" => "Usuario autenticado con token...",
            "data" => auth()->user()
        ]); 
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        
        return response()->json([
            "status" => 0,
            "msg" => "Cierre de Sesión",            
        ]); 
    }
}
