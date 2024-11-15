<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_lubricantes extends Model
{
    use HasFactory;
    protected $table = 'tb_lubricantes';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
    'estacion',
    'mes',
    'anio',
    'idFactura',
    'RucEmpresa',
    'Nombre',
    'email',
    'MontoDolares',
    'numerofactura',
    'Fecha',
    'idVendedor',
    'Vendedor',
    'Placa',
    'Impresora',
    'idProducto',
    'DesProducto',
    'Cantidad',
    'Precio',
    'MontoDolaresDes',
    'created_at',
    'updated_at'
    
    ];
    // protected $casts = [
       
    //     'Fecha' =>   'date:Y-m-d',
       
    // ];
    protected function serializeDate($date)
{
    return $date->format('Y-m-d H:i:s');
}
    public function scopeDatosEstacion($query)
    {
        $des_estacion = tb_estaciones::select('descripcion')
            ->whereColumn('estacion', 'id')
            ->limit(1);
		//cirujano
		 

 
        $query->addSelect([
            'des_estacion' => $des_estacion,
           
            
        ]);
    }
}
