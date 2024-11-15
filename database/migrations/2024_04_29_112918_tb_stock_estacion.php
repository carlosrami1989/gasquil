<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbStockEstacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tb_stock_estaciones', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('estacion');
            $table->integer('idProducto');
            $table->string('Descripcion', 150)->nullable()->default('0');
            $table->string('idEstado', 150)->nullable()->default('0');
            $table->integer('Cantidad');
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
