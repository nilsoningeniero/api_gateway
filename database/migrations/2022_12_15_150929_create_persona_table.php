<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_documento',255)->comment('Tipo de documento');
            $table->string('documento',255)->comment('Número del documento');
            $table->index(['tipo_documento', 'documento'])->unique();
            $table->string('nombres',255)->comment('Nombres');
            $table->string('apellidos',255)->comment('Apellidos');
            $table->string('direccion',255)->comment('Dirección');
            $table->string('telefono',255)->comment('Número de Teléfono');
            $table->string('email',255)->comment('E-mail');
            //Datos de auditoria
            $table->timestamp('fechacreacion')->nullable()->default(null);
            $table->integer('usuariocreacion');
            $table->timestamp('fechamodificacion')->nullable()->default(null);
            $table->integer('usuariomodificacion');
            $table->string('ipcreacion',255);
            $table->string('ipmodificacion',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
