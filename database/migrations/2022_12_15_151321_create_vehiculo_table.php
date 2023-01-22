<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('placa',255)->comment('Placa');
            $table->unsignedBigInteger('marca_id')->comment('Marca');
            $table->unsignedBigInteger('modelo_id')->comment('Modelo');
            $table->integer('ano')->comment('Año');
            $table->string('color',255)->comment('Color');
            $table->unsignedBigInteger('persona_id')->nullable()->comment('Arrendatario');
            $table->text('observaciones')->comment('Observaciones');
            $table->date('fecha_registro')->nullable()->comment('Fecha de registro');
            $table->text('dir_ubicacion')->comment('Dirección ubicacion');
            $table->text('ciudad')->comment('Ciudad');
            $table->float('coordenadas_lon')->comment('Coordenadas geográficas de ubicación LON');
            $table->float('coordenadas_lat')->comment('Coordenadas geográficas de ubicación LAT');
            //Datos de auditoria
            $table->timestamp('fechacreacion')->nullable()->default(null);
            $table->integer('usuariocreacion');
            $table->timestamp('fechamodificacion')->nullable()->default(null);
            $table->integer('usuariomodificacion');
            $table->string('ipcreacion',255);
            $table->string('ipmodificacion',255);
            //foriengn key
            $table->foreign('marca_id')->references('id')->on('marca')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('modelo_id')->references('id')->on('modelo')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('persona_id')->references('id')->on('persona')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo');
    }
}
