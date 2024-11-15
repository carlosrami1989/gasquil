<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_lubricantes_stock_vent extends Model
{
    use HasFactory;
    protected $table = 'tb_stock_ventas';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
        'estacion',
        'mes',
        'anio',
        'idProducto',
        'proTOdos',
        'Descripcion',
        'DesProducto',
        'estado',
        'stock',
        'facturado',
        'total',
        'created_at',
        'updated_at'
    
    ];

    protected $appends = [
        'CODIGO',
    ];
    
     protected $casts = [
       
        // 'DesProducto' =>   substr( 'DesProducto',0,6),
       
    ];

    public function getCODIGOattribute()
    {
        //return calculaEdad($this->CirProHisCli);
        return $this->Descripcion;

       
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
