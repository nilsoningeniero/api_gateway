<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use DB;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $vehiculo = Vehiculo::leftJoin("marca","marca.id","vehiculo.marca_id")
                ->leftJoin("modelo","modelo.id","vehiculo.modelo_id")
                ->leftJoin("persona","persona.id","vehiculo.persona_id")
                ->select("vehiculo.id",
                    "vehiculo.placa",
                    "marca.nom_marca",
                    "modelo.nom_modelo",
                    "vehiculo.ano",
                    "vehiculo.color",
                    DB::raw("concat(persona.nombres,' ',persona.apellidos) as persona"),
                    "vehiculo.observaciones",
                    "vehiculo.fecha_registro",
                    "vehiculo.dir_ubicacion",
                    "vehiculo.ciudad",
                    "vehiculo.coordenadas_lon",
                    "vehiculo.coordenadas_lat",
                    "vehiculo.fechacreacion",
                    "vehiculo.usuariocreacion",
                    "vehiculo.fechamodificacion",
                    "vehiculo.usuariomodificacion",
                    "vehiculo.ipcreacion",
                    "vehiculo.ipmodificacion")
                ->get();

                return response()->json($vehiculo);
    }

    public function alquiler()
    {

        $vehiculo = Vehiculo::leftJoin("marca","marca.id","vehiculo.marca_id")
                ->leftJoin("modelo","modelo.id","vehiculo.modelo_id")
                ->leftJoin("persona","persona.id","vehiculo.persona_id")
                ->select("vehiculo.id",
                    "vehiculo.placa",
                    "marca.nom_marca",
                    "modelo.nom_modelo",
                    "vehiculo.ano",
                    "vehiculo.color",
                    "vehiculo.persona_id",
                    "vehiculo.observaciones",
                    "vehiculo.fecha_registro",
                    "vehiculo.dir_ubicacion",
                    "vehiculo.ciudad",
                    "vehiculo.coordenadas_lon",
                    "vehiculo.coordenadas_lat",
                    "vehiculo.fechacreacion",
                    "vehiculo.usuariocreacion",
                    "vehiculo.fechamodificacion",
                    "vehiculo.usuariomodificacion",
                    "vehiculo.ipcreacion",
                    "vehiculo.ipmodificacion")
                ->where('vehiculo.persona_id', NULL)
                ->get();

                return response()->json($vehiculo);
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
            'placa' => ['required'],
            'marca_id' => ['required'],
            'modelo_id' => ['required'],
            'ano' => ['required', 'integer'],
            'color' => ['required', 'string'],
            // 'persona_id' => ['required'],
            'observaciones' => ['required'],
            'fecha_registro' => ['required', 'date'],
            'dir_ubicacion' => ['required'],
            'ciudad' => ['required'],
            'coordenadas_lon' => ['required', 'numeric'],
            'coordenadas_lat' => ['required', 'numeric']
        ]);

        try {
            $obj_usuario = Auth::user();

            $vehiculo = new Vehiculo;
            $vehiculo->placa = $request->input('placa');
            $vehiculo->marca_id = $request->input('marca_id');
            $vehiculo->modelo_id = $request->input('modelo_id');
            $vehiculo->ano = $request->input('ano');
            $vehiculo->color = $request->input('color');
            $vehiculo->persona_id = $request->input('persona_id');
            $vehiculo->observaciones = $request->input('observaciones');
            $vehiculo->fecha_registro = $request->input('fecha_registro');
            $vehiculo->dir_ubicacion = $request->input('dir_ubicacion');
            $vehiculo->ciudad = $request->input('ciudad');
            $vehiculo->coordenadas_lon = $request->input('coordenadas_lon');
            $vehiculo->coordenadas_lat = $request->input('coordenadas_lat');
            $vehiculo->usuariocreacion = $obj_usuario->id;
            $vehiculo->usuariomodificacion = $obj_usuario->id;
            $vehiculo->ipcreacion = $request->getClientIp();
            $vehiculo->ipmodificacion = $request->getClientIp();
            $vehiculo->save();
            return $vehiculo;

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
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function show( $vehiculo_id)
    {
        return Vehiculo::where('id', $vehiculo_id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vehiculo_id)
    {
        
        $request->validate([
            'placa' => ['required'],
            'marca_id' => ['required'],
            'modelo_id' => ['required'],
            'ano' => ['required', 'integer'],
            'color' => ['required', 'string'],
            // 'persona_id' => ['required'],
            'observaciones' => ['required'],
            'fecha_registro' => ['required', 'date'],
            'dir_ubicacion' => ['required'],
            'ciudad' => ['required'],
            'coordenadas_lon' => ['required', 'numeric'],
            'coordenadas_lat' => ['required', 'numeric']
        ]);

        try{
            $obj_usuario = Auth::user();

            $vehiculo = Vehiculo::where('id', $vehiculo_id)->first();

            $vehiculo->placa = $request->input('placa');
            $vehiculo->marca_id = $request->input('marca_id');
            $vehiculo->modelo_id = $request->input('modelo_id');
            $vehiculo->ano = $request->input('ano');
            $vehiculo->color = $request->input('color');
            $vehiculo->persona_id = $request->input('persona_id');
            $vehiculo->observaciones = $request->input('observaciones');
            $vehiculo->fecha_registro = $request->input('fecha_registro');
            $vehiculo->dir_ubicacion = $request->input('dir_ubicacion');
            $vehiculo->ciudad = $request->input('ciudad');
            $vehiculo->coordenadas_lon = $request->input('coordenadas_lon');
            $vehiculo->coordenadas_lat = $request->input('coordenadas_lat');
            $vehiculo->usuariocreacion = $obj_usuario->id;
            $vehiculo->usuariomodificacion = $obj_usuario->id;
            $vehiculo->ipcreacion = $request->getClientIp();
            $vehiculo->ipmodificacion = $request->getClientIp();
            $vehiculo->save();
            return $vehiculo;

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
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy($vehiculo_id)
    {
        $vehiculo = Vehiculo::where('id', $vehiculo_id)->first();

        $vehiculo->delete();

        return response()->noContent();
    }
}
