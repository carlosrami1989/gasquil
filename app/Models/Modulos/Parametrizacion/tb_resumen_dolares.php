<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_resumen_dolares extends Model
{
    use HasFactory;
    protected $table = 'tb_resumen_dolares';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
       'id',
    'estacion',
    'anio',
    'mes',
    'dia',
    'fecha',
    'EFECTIVO',
    'MEDIO_DIGITAL',
    'CHEQUE',
    'TRANSFERENCIA',
    'CREDITO',
    'PREPAGO',
    'CALIBRACIONES',
    'AUTOCONSUMO',
    'GENERICO',
    'ALERTA',
    'TOTAL',
    'created_at',
    'updated_at'
     
    ];
}
