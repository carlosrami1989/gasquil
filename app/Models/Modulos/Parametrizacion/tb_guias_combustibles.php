<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Modulos\Parametrizacion\tb_estaciones;

class tb_guias_combustibles extends Model
{
    use HasFactory;
    protected $table = 'tb_guias_combustibles';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
       'id',
    'estacion',
    'anio',
    'mes',
    'fecha_emision',
    'fecha_entrega',
    'orden',
    'producto',
    'desproducto',
    'pedido',
    'galones_facturado',
    'total',
    'created_at',
    'updated_at'
    ];
    protected $casts = [
       
        'fecha_emision' =>   'date:Y-m-d',
        'fecha_entrega' =>   'date:Y-m-d',
       
    ];
    public function scopeDatosFormaPago($query)
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
