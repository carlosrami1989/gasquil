<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbLubricantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         //
         Schema::create('tb_lubricantes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('estacion');
            $table->string('mes', 10)->nullable()->default('0');
            $table->string('anio', 10)->nullable()->default('0');
            $table->integer('idFactura');
            $table->string('RucEmpresa', 15)->nullable()->default('0');
            $table->string('Nombre', 50)->nullable()->default('0');
            $table->string('email', 50)->nullable()->default('0');
            $table->double('MontoDolares', 15, 8);
            $table->string('numerofactura', 50)->nullable()->default('0');
            $table->dateTime('Fecha');
            $table->integer('idVendedor');
            $table->string('Vendedor', 50)->nullable()->default('0');
            $table->string('Placa', 50)->nullable()->default('0');
            $table->string('Impresora', 50)->nullable()->default('0');
            $table->integer('idProducto');
            $table->string('DesProducto', 50)->nullable()->default('0');
            $table->integer('Cantidad');
            $table->double('Precio', 15, 8);
            $table->double('MontoDolaresDes', 15, 8);
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
