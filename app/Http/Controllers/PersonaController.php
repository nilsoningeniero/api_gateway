<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Persona::all();
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
            'tipo_documento' => ['required'],
            'documento' => ['required'],
            'nombres' => ['required'],
            'apellidos' => ['required'],
            'direccion' => ['required'],
            'telefono' => ['required'],
            'email' => ['required']
        ]);
        try {
            $obj_usuario = Auth::user();

            $persona = new Persona;
            $persona->tipo_documento = $request->input('tipo_documento');
            $persona->documento = $request->input('documento');
            $persona->nombres = $request->input('nombres');
            $persona->apellidos = $request->input('apellidos');
            $persona->direccion = $request->input('direccion');
            $persona->telefono = $request->input('telefono');
            $persona->email = $request->input('email');
            $persona->usuariocreacion = $obj_usuario->id;
            $persona->usuariomodificacion = $obj_usuario->id;
            $persona->ipcreacion = $request->getClientIp();
            $persona->ipmodificacion = $request->getClientIp();
            $persona->save();
            return $persona;

        }catch(QueryException $ex){
            $error_code = $ex->errorInfo[0];
            $error_msg = $ex->getMessage();
            switch(intval($error_code))
            {
                case 23000: // Llave unique violada
                    return response()->json([
                        "status" => 409,
                        "msg" => "Error, El recurso que desea agregar ya existe ". $request->input('tipo_documento').'-'.$request->input('documento'),
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
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show($persona_id)
    {
        $persona = Persona::where('id', $persona_id)->first();

        return $persona;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $persona_id)
    {
        
        $persona = Persona::where('id', $persona_id)->first();

        $request->validate([
            'tipo_documento' => ['required'],
            'documento' => ['required'],
            'nombres' => ['required'],
            'apellidos' => ['required'],
            'direccion' => ['required'],
            'telefono' => ['required'],
            'email' => ['required'],

        ]);

        Rule::unique('persona', 'persona_tipo_documento_documento_index')->ignore($persona->persona_tipo_documento_documento_index);
        
        try {

            $obj_usuario = Auth::user();

            $persona->tipo_documento = $request->input('tipo_documento');
            $persona->documento = $request->input('documento');
            $persona->nombres = $request->input('nombres');
            $persona->apellidos = $request->input('apellidos');
            $persona->direccion = $request->input('direccion');
            $persona->telefono = $request->input('telefono');
            $persona->email = $request->input('email');
            $persona->usuariocreacion = $obj_usuario->id;
            $persona->usuariomodificacion = $obj_usuario->id;
            $persona->ipcreacion = $request->getClientIp();
            $persona->ipmodificacion = $request->getClientIp();
            $persona->save();
            return $persona;

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
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy($persona_id)
    {
        $persona = Persona::where('id', $persona_id)->first();

        $persona->delete();

        return response()->noContent();
    }
}
