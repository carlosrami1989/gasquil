<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_cliente extends Model
{
    use HasFactory;
    protected $table = 'tb_cliente';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombres',
        'apellidos',
        'ruc',
        'cedula',
        'placas',
        'disco',
        'modelo',
        'anio',
        'mail',
        'firma_entrega',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'FULLNAME' 
  ];
  public function getFULLNAMEattribute()
  {
      $nombres =  $this->apellidos.' '.$this->nombres.' - '.$this->placas;

      return $nombres;
  }
}
