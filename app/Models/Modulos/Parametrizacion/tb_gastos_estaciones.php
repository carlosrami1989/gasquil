<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_gastos_estaciones extends Model
{
    use HasFactory;
    protected $table = 'tb_gastos_estaciones';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
    'estacion',
    'tipo_gasto',
    'fecha_emision',
    'detalle',
    'proveedor',
    'ruc',
    'factura',
    'total',
    'created_at',
    'updated_at'
    ];
    protected $casts = [
       
        'fecha_emision' =>   'date:Y-m-d',
      
       
    ];
    public function scopeDatosFormaPago($query)
    {
        $des_estacion = tb_estaciones::select('descripcion')
            ->whereColumn('estacion', 'id')
            ->limit(1);

            $des_proveedor_nombre = tb_proveedores::select('nombre')
            ->whereColumn('proveedor', 'id')
            ->limit(1);

            $des_proveedor_apellido = tb_proveedores::select('apellido')
            ->whereColumn('proveedor', 'id')
            ->limit(1);
            $razon_social = tb_proveedores::select('razon_social')
            ->whereColumn('proveedor', 'id')
            ->limit(1);
            $tipo_gasto = tb_tipo_gasto::select('descripcion')
            ->whereColumn('tipo_gasto', 'id')
            ->limit(1);
		//cirujano
		 

 
        $query->addSelect([
            'des_estacion' => $des_estacion,
            'des_proveedor_nombre' => $des_proveedor_nombre,
            'razon_social' => $razon_social,
            'tipo_gasto_des' => $tipo_gasto,
           
            
        ]);
    }
}
