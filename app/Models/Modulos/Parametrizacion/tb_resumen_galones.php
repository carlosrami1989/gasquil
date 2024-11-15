<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_resumen_galones extends Model
{
    use HasFactory;
    protected $table = 'tb_resumen_galones';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
       'id',
    'estacion',
    'tipo',
    'anio',
    'mes',
    'dia',
    'fecha',
    'EXTRA_CON_ETANOL',
    'DIESEL',
    'SUPER_PREMIUM_95',
    'TOTAL',
    'created_at',
    'updated_at'
     
    ];
}
