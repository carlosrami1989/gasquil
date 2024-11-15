<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_proveedores extends Model
{
    use HasFactory;
    protected $table = 'tb_proveedores';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre',
    'apellido',
    'ruc',
    'cedula',
    'razon_social',
    'direccion',
    'telefono',
    'correo',
    'usu_created',
    'usu_update',
    'created_at',
    'updated_at',
    'pcip',
    'status'
    ];
    protected $appends = [
        'NOMBRESALL' 
    ];
   

    public function getNOMBRESALLattribute()
    {
        //return calculaEdad($this->CirProHisCli);
        return $this->apellido.' '.$this->nombre;

       
    }
}
