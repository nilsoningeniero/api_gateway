<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use App\Service\MarcaService;
use App\Http\Requests\MarcaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 

class MarcaController extends Controller
{
    protected $marcaService; 
    
    public function __construct( MarcaService $marcaService )
    {
        $this->marcaService = $marcaService; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Ejecutando el proceso usando Multicapas (Servicios, interfaces y repositorios)

        $array_data = $this->marcaService->listarTodo();

        return \response()->json($array_data,202);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarcaRequest $request)
    {
        //Ejecutando el proceso usando Multicapas (Servicios, interfaces y repositorios)

        $obj_usuario = Auth::user();

        $output =  $this->marcaService->guardar( (object)
            [  
                'id' => $request['id'],   
                'nom_marca' => $request['nom_marca'],
                'usuariocreacion' => $obj_usuario->id,
                'usuariomodificacion' => $obj_usuario->id,
                'ipmodificacion' => $request->getClientIp(),
                'ipcreacion' => $request->getClientIp()
            ]
        );

        return \response()->json([
            'msg' => $request['id'] > 0 ? ['Datos actualizados exitosamente'] :['Datos guardados exitosamente'],
            'obj' =>  $output
        ],202);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Ejecutando el proceso usando Multicapas (Servicios, interfaces y repositorios)

        $array_mensajes = [
            'id.required' => 'El campo id es obligatorio',
            'id.integer' => 'El campo id debe ser entero',
            'id.min' => 'El campo id debe ser minimo 1'
        ];

        $valid = Validator::make(
            array('id' => $id),
            [
                'id' => 'required|integer|min:1'
            ],
            $array_mensajes);

        if ($valid->fails())
        {
            return \response()->json([
                'state' => 422,
                'msg' => $valid->errors()->all(),
                'title' => 'Campos invalidos'
            ],422);
        }

        $obj = $this->marcaService->obtenerRecurso($id);

        return \response()->json(
            $obj
        ,202);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, Marca $marca)
     {
        //Ejecutando el proceso usando Multicapas (Servicios, interfaces y repositorios)

        $obj_usuario = Auth::user();
        //return $obj_usuario;
        $output =  $this->marcaService->guardar( (object)
        [  
            'id' => $request['id'],   
            'nom_marca' => $request['nom_marca'],
            'usuariocreacion' => 1,//$obj_usuario->id,
            'usuariomodificacion' => 1,//$obj_usuario->id,
            'ipmodificacion' => $request->getClientIp(),
            'ipcreacion' => $request->getClientIp()
        ]
        );

        return \response()->json([
        'msg' => $request['id'] > 0 ? ['Datos actualizados exitosamente'] :['Datos guardados exitosamente'],
        'obj' =>  $output
        ],202);

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, $id )
    {
        //Ejecutando el proceso usando Multicapas (Servicios, interfaces y repositorios)
        
        $array_mensajes = [
            "id.required" => "El identificador es obligatorios"
        ];

        $valid = Validator::make(
            array('id' => $id),
            [
                'id' => 'required|integer|min:1'
            ],
            $array_mensajes);

        if ($valid->fails())
        {
            return \response()->json([
                "state" => 422,
                "msg" => $valid->errors()->all()
            ],422);
        }

        $out_put = $this->marcaService->eliminar($id);

        return \response()->json(
            $out_put
        ,202);
    }
}
