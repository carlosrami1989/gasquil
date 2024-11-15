<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbStockVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tb_stock_ventas', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('estacion');
            $table->string('mes', 10)->nullable()->default('0');
            $table->string('anio', 10)->nullable()->default('0');
            $table->integer('idProducto');
            $table->integer('proTOdos');
            $table->string('Descripcion', 150)->nullable()->default('0');
            $table->string('DesProducto', 150)->nullable()->default('0');
            $table->string('estado', 150)->nullable()->default('0');
            $table->integer('stock');
            $table->integer('facturado');
            $table->integer('total');
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
