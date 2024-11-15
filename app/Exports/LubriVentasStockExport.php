<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class LubriVentasStockExport implements FromView
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
        return view('reports.lubricantes_stock_ventas', [
            'lista' =>  $this->lista ,
              'titulo' =>$this->titulo ,
        ]);
    }    
    public function startCell(): string
    {
        return 'B2';
    }
}
