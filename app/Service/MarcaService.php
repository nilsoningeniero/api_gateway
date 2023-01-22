<?php
namespace App\Service;

use App\Repositories\Marca\MarcaInterface;
use App\Exceptions\ExceptionServer;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class MarcaService
{
    protected $repository;

    public function __construct(
        MarcaInterface $marcainterface
    )
    {
        $this->repository = $marcainterface;
    }


    public function guardar($obj_data)
    {
        return $this->repository->guardar($obj_data);
    }

    public function obtenerRecurso($id)
    {
        return $this->repository->obtenerRecurso($id);
    }

    public function listarTodo()
    {
        return $this->repository->listarTodo();
    }
  
    public function eliminar($array_ids)
    {
        return $this->repository->eliminar($array_ids);
    }

    
}
?>