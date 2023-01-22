<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;


class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelo = Modelo::join("marca","marca.id","modelo.marca_id")
                        ->select("modelo.id",
                            "modelo.marca_id",
                            "marca.nom_marca",
                            "modelo.nom_modelo",
                            "modelo.fechacreacion",
                            "modelo.usuariocreacion",
                            "modelo.fechamodificacion",
                            "modelo.usuariomodificacion",
                            "modelo.ipcreacion",
                            "modelo.ipmodificacion")
                        ->get();

        return response()->json($modelo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obj_usuario = Auth::user();

        $request->validate([
            'nom_modelo' => ['required'],
            'marca_id' => ['required']
        ]);

        try {
            $modelo = new Modelo;
            $modelo->marca_id = $request->input('marca_id');
            $modelo->nom_modelo = $request->input('nom_modelo');
            $modelo->usuariocreacion = $obj_usuario->id;
            $modelo->usuariomodificacion = $obj_usuario->id;
            $modelo->ipcreacion = $request->getClientIp();
            $modelo->ipmodificacion = $request->getClientIp();
            $modelo->save();
            return $modelo;

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
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($modelo_id)
    {
        return Modelo::where('id', $modelo_id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $modelo_id)
    {
        $obj_usuario = Auth::user();

        $request->validate([
            'nom_modelo' => ['required'],
            'marca_id' => ['required']
        ]);

        try {
            $modelo = Modelo::where('id', $modelo_id)->first();
            
            $modelo->marca_id = $request->input('marca_id');
            $modelo->nom_modelo = $request->input('nom_modelo');
            $modelo->usuariocreacion = $obj_usuario->id;
            $modelo->usuariomodificacion = $obj_usuario->id;
            $modelo->ipcreacion = $request->getClientIp();
            $modelo->ipmodificacion = $request->getClientIp();
            $modelo->save();
            return $modelo;

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
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($modelo_id)
    {
        $modelo = Modelo::where('id', $modelo_id)->first();
        
        $modelo->delete();

        return response()->noContent();
    }
}
