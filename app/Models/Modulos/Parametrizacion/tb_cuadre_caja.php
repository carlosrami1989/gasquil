<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_cuadre_caja extends Model
{
    use HasFactory;
    protected $table = 'tb_cuadre_caja';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
       'id',
    'fecha_emision',
    'id_cajero',
    'turno',
    'cajero',
    'id_bodega',
    'id_bodega_sistema',
    'saldo_efectivo',
    'monto_caja',
    'monto_tc',
    'sum_total',
    'total_fisico',
    'diferencia',
    'observacion',
    'user_create',
    'user_update',
    'created_at',
    'updated_at'
    ];

     
}
