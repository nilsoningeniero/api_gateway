<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('marca_id')->comment('Nombre de la marca');
            $table->string('nom_modelo',255)->comment('Nombre de la modelo');
            //Datos de auditoria
            $table->timestamp('fechacreacion')->nullable()->default(null);
            $table->integer('usuariocreacion');
            $table->timestamp('fechamodificacion')->nullable()->default(null);
            $table->integer('usuariomodificacion');
            $table->string('ipcreacion',255);
            $table->string('ipmodificacion',255);
            //foriengn key
            $table->foreign('marca_id')->references('id')->on('marca')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelo');
    }
}
