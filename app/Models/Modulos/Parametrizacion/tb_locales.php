<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_locales extends Model
{
    use HasFactory;
    protected $table = 'tb_locales';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
       'id',
    'descripcion',
    'direccion',
    'latitud',
    'longitud',
    'telefono',
    'total',
    'estado',
    'created_at',
    'updated_at'
    ];
}
