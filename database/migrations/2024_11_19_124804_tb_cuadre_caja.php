<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCuadreCaja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tb_cuadre_caja', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->dateTime('fecha_emision');
            $table->string('id_cajero', 100);
            $table->string('turno', 100);
            $table->string('cajero', 100) ;
            $table->string('id_bodega', 100) ;
            $table->string('id_bodega_sistema', 100) ;

            $table->double('saldo_efectivo', 15, 8);
            $table->double('monto_caja', 15, 8);
            $table->double('monto_tc', 15, 8);
            $table->double('sum_total', 15, 8);
            $table->double('total_fisico', 15, 8);
            $table->double('diferencia', 15, 8);

            $table->string('observacion', 800) ;
            $table->timestamps();

 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
