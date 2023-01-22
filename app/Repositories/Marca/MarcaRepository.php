<?php
namespace App\Repositories\Marca;

use App\Models\Marca;
use App\Repositories\Marca\MarcaInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\ExceptionServer;
use Illuminate\Database\QueryException;

class MarcaRepository implements MarcaInterface
{
    protected $model;

    public function __construct(Marca $marca)
    {
        $this->model = $marca;
    }

    public function guardar($obj_data)
    {
        $error_code = "";
        $error_msg = "";

        try {

            if ($obj_data->id > 0)
            {
                if (null == $obj = $this->model->find($obj_data->id)) {
                    throw new ExceptionServer(basename(__FILE__, ".php"),["El recurso a actualizar no existe"],404,"Recurso no encontrado");
                }

                $obj->usuariomodificacion = $obj_data->usuariomodificacion;
                $obj->ipmodificacion = $obj_data->ipmodificacion;
            }
            else
            {
                $obj = new $this->model();
                $obj->usuariocreacion = $obj_data->usuariocreacion;
                $obj->usuariomodificacion = $obj_data->usuariomodificacion;
                $obj->ipcreacion = $obj_data->ipcreacion;
                $obj->ipmodificacion = $obj_data->ipmodificacion;
            }
             
            $obj->nom_marca = $obj_data->nom_marca;

            $obj->save();
            $obj->refresh();

            return $obj;
        }
        catch (QueryException $ex) 
        {
            $error_code = $ex->errorInfo[0];
            $error_msg = $ex->getMessage();

            switch(intval($error_code))
            {
                case 23505: // Llave unique violada
                    throw new ExceptionServer(basename(__FILE__, ".php"),["El recurso que desea agregar ya existe"],409,"Duplicidad de recursos");
                break;
                default:
                    throw new ExceptionServer(basename(__FILE__, ".php"),["En el momento no se puede realizar esta operación, comuníquese con el administrador del sistema"],500,"Fallo de servicio","LOG", $error_msg);
                break;
            }
        }
    }

    public function selectBase()
    {
            return  $this->model::all();
    }

    public function obtenerRecurso($id)
    {
        $obj = null;

        try
        {
            $obj =  $this->selectBase()->find($id);

            if ($obj == null)
            {
                throw new ExceptionServer(basename(__FILE__, ".php"),["Recurso no encontrado"],404,"Recurso no encontrado");
            }
        }
        catch (QueryException $ex) 
        {
            $error_code = $ex->errorInfo[0];
            $error_msg = $ex->getMessage();

            throw new ExceptionServer(basename(__FILE__, ".php"),["En el momento no se puede realizar esta operación, comuníquese con el administrador del sistema"],500,"Fallo de servicio","LOG", $error_msg);
        }

        return $obj;

    }

    public function listarTodo()
    {
        try
        {
            $array_data = $this->selectBase(); 
       
            return $array_data;
        
        }
        catch (QueryException $ex) 
        {
            $error_code = $ex->errorInfo[0];
            $error_msg = $ex->getMessage();

            throw new ExceptionServer(basename(__FILE__, ".php"),["En el momento no se puede realizar esta operación, comuníquese con el administrador del sistema"],500,"Fallo de servicio","LOG", $error_msg);
        }
    }
  
    public function eliminar($array_ids)
    {
        //return $array_ids;
        try
        {
            return $this->model->destroy($array_ids);
        }
        catch (QueryException $ex) 
        {
            $error_code = $ex->errorInfo[0];
            $error_msg = $ex->getMessage();

            switch(intval($error_code))
            {
                case 23503: // Violacion de llave foranea
                    return $error_code;
                break;
                default:
                    return $error_msg;
                break;
            }
        }

    }

    

}
?>