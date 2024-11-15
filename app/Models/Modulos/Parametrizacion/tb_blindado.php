<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_blindado extends Model
{
    use HasFactory;
    protected $table = 'tb_blindado';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
      'id',
    'estacion',
    'fecha_emision',
    'valor',
    'deposito_real',
    'valor_enviarse',
    'diferencia',
    'detalle',
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
		//cirujano
		 

 
        $query->addSelect([
            'des_estacion' => $des_estacion,
           
            
        ]);
    }
}
