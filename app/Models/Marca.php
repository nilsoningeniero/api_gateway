<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marca';

    protected $connection  = 'mysql';
    const CREATED_AT = 'fechacreacion';
    const UPDATED_AT = 'fechamodificacion';
    
    protected $fillable = [
        'nom_marca',
        'fechacreacion',
        'usuariocreacion',
        'fechamodificacion',
        'usuariomodificacion',
        'ipcreacion',
        'ipmodificacion'
    ];

    public function array_modelo()
    {
        return $this->hasMany('App\Models\Modelo', 'marca_id', 'id');
    }

    public function array_vehiculo()
    {
        return $this->hasMany('App\Models\Vehiculo', 'marca_id', 'id');
    }

}
