<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_tipo_gasto extends Model
{
    use HasFactory;
    protected $table = 'tb_tipo_gasto';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
    'descripcion',
    'estado',
     
    ];
}
