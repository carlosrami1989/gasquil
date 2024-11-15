<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_lubricantes_stock_esta extends Model
{
    use HasFactory;
    protected $table = 'tb_stock_estaciones';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
        'estacion',
        'idProducto',
        'Descripcion',
        'idEstado',
        'Cantidad',
        'created_at',
        'updated_at'
    
    ];

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
