<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;

class LubriConsolidadoExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $titulo;
    public $lista;

    public function __construct( $lista,$titulo)
    {    
        $this->lista = $lista;
       
        $this->titulo = $titulo;
       

    }
    public function view(): View
    {
        return view('reports.lubricante_consolidado', [
            'lista' =>  $this->lista ,
              'titulo' =>$this->titulo ,
        ]);
    }
    public function startCell(): string
    {
        return 'B2';
    }
}
