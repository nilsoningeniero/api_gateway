<?php
namespace App\Repositories;

interface RepositoryInterface
{
    public function listarTodo();

    public function guardar($obj_data);

    public function eliminar($array_ids);

    public function obtenerRecurso($id);
}

?>
