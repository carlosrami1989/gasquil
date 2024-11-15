<?php

namespace App\Http\Controllers\Modulos\Administracion;

use App\Exports\LibriExport;
use App\Exports\LubriConsolidadoExport;
use App\Exports\LubriVentasStockExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;

use App\Models\Modulos\Parametrizacion\TbTipoDesecho;
use App\Models\Modulos\Parametrizacion\TbClasificacionDesecho;
use App\Models\Modulos\Parametrizacion\TbClasificacionDesechosDescripcion;
use App\Models\Modulos\Parametrizacion\tbResponsable;
use App\Models\Modulos\Parametrizacion\tb_lubricantes;
//use App\Models\Modulos\Parametrizacion­\tbIngresoInfo;
use App\Models\Modulos\Parametrizacion\tbIngresoInfo;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Models\Modulos\Parametrizacion\tb_consulta_dia;
use App\Models\Modulos\Parametrizacion\tb_consulta_mes;
use App\Models\Modulos\Parametrizacion\tb_estaciones;
use App\Models\Modulos\Parametrizacion\tb_gastos;
use App\Models\Modulos\Parametrizacion\tb_lubricantes_stock_esta;
use App\Models\Modulos\Parametrizacion\tb_lubricantes_stock_vent;

use App\Models\Modulos\Parametrizacion\tb_guias_combustibles;
use App\Models\Modulos\Parametrizacion\tb_proveedores;
use App\Models\Modulos\Parametrizacion\tb_gastos_estaciones;
use App\Models\Modulos\Parametrizacion\tb_tipo_gasto;
use App\Models\Modulos\Parametrizacion\tb_blindado;
use App\Models\Modulos\Parametrizacion\tb_resumen_dolares;
use App\Models\Modulos\Parametrizacion\tb_resumen_galones;


use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Modulos\Parametrizacion\tbUsuarioPerfil;
use Exception;

class Dashboard extends Controller
{
    public function GetDocumentoAdmninVentasFecha(Request $request)
    {

        try {







            $user = Auth::user();
            $data_desde = date( $request->fecha_inicial);
            $data_hasta = date( $request->fecha_final);
            $desde = date("d/m/Y", strtotime($data_desde));   
            $hasta = date("d/m/Y", strtotime($data_hasta));   
            //$hasta = date("d/m/Y",$request->fecha_final);
            $bodega_id = $request->bodega_id;

 








          //  $url = "";
            // $url = "https://api.contifico.com/sistema/api/v1/registro/documento/?tipo_registro=PRO&fecha_inicial=".$desde."&fecha_final=".$hasta."&bodega_id=".$bodega_id;

          
 
            // $response = $this->makeRequest('GET', $url);


            $url_ventas = "https://api.contifico.com/sistema/api/v1/registro/documento/?tipo_registro=CLI&fecha_inicial=".$desde."&fecha_final=".$hasta."&bodega_id=".$bodega_id;

          
 
          //  $response_ventas = "";
            $response_ventas = $this->makeRequest('GET', $url_ventas);

            $ListaColeVentas = collect($response_ventas);
           // $ListaColeCompras = collect($response);

            $ListProductosVentas = array();
            foreach ($response_ventas as   $item) {
                foreach ( $item["detalles"] as   $item_pro) {
                    if ( $item["tipo_documento"] != "DNA") {
                    $myObj = new stdClass();
                    $myObj->centro_costo_id = $item_pro["centro_costo_id"];
                    $myObj->producto_id =$item_pro["producto_id"];
                    $myObj->producto_nombre =$item_pro["producto_nombre"];
                    $myObj->cantidad =$item_pro["cantidad"];
                    $myObj->precio =$item_pro["precio"];
                    $ListProductosVentas[] = $myObj;
                    }
                }
            }
            //top 10 de mas vendidos
            $ListaColeProductos = collect($ListProductosVentas);
            //realizo la agrupacion
            $ListaMasVendido = $ListaColeProductos->groupBy('producto_id')->sortByDesc('cantidad');
            //mapeo la lista
            $ListaSuma = $ListaMasVendido->map(function($roomHistories, $key) {
              
                return ["sum_cantidad" => $roomHistories->sum('cantidad'),"sum_precio" => $roomHistories->sum('precio'),"producto_nombre"=> $roomHistories[0]->producto_nombre];
               
            });

            //recorro la lista mapeada
            $ListProductotop = array();
            foreach ($ListaSuma as   $item) {
                
                $myObj = new stdClass();
                $myObj->sum_cantidad =$item["sum_cantidad"];
                $myObj->sum_precio = $item["sum_precio"];
                $myObj->producto_nombre =$item["producto_nombre"];
                $ListProductotop[] = $myObj;
                
                 
            }

           

            //mejor vendedor

           
            $ListMejorVendedor = array();
            foreach ($response_ventas as   $item) {
 
                if ( $item["tipo_documento"] != "DNA") {
                    # code...
                    $myObj = new stdClass();
                   // $myObj->id = $item["vendedor"];

                   if ($item["anulado"] != true) {
                    if ($item["vendedor"] != "") {
                        # code...
                    //     $myObj->id = $item["vendedor"];
                    // $myObj->itemidid = $item["id"];

                    $myObj->id = $item["vendedor"]["id"]!= null?$item["vendedor"]["id"]:"no id";
                    $myObj->cedula =$item["vendedor"]["cedula"] != null?$item["vendedor"]["cedula"]:"no tiene cedula";
                    $myObj->razon_social = $item["vendedor"]["razon_social"] ;
                    $myObj->adicional1_cliente =$item["vendedor"]["adicional1_cliente"]!= null?$item["vendedor"]["adicional1_cliente"]:"no tien CA";
                    $myObj->total =$item["total"] ;
                    $ListMejorVendedor[] = $myObj;
                    }
                    # code...

                    
                    
                   }
                 


                    // $myObj->id =$item["vendedor"]["id"];
                    // $myObj->cedula = "no tiene cedula";
                    // $myObj->razon_social = 0 ;
                    // $myObj->adicional1_cliente =0;
                    // $myObj->total =0 ;


                  

                } 
            }

            // return response()->json([                
            //     'ventas' => $ListMejorVendedor ,
            //     'ListaColeVentas' => $ListaColeVentas ,
            // ], 200);
           
            //top 10 de mas vendidos
            $ListaCollectionVendedor = collect($ListMejorVendedor);
            //realizo la agrupacion
            $ListaMejorVendedorEnviar = $ListaCollectionVendedor->groupBy('id')->sortByDesc('total');
            //mapeo la lista
            $ListaMejorVendedor = $ListaMejorVendedorEnviar->map(function($roomHistories, $key) {
              
                return ["sum_total" => $roomHistories->sum('total'),"arregl" => $roomHistories[0]];
               
            });
 

           
            $suma=0;

            



            // $ListaCollectionBodega = $ListaCollectionBodega->filter(function($item){
            //     return strpos($item['nombre'], 'Ventas') !== false;
                
            // });

              //arqueo de caja

           
              $ListaArqueoCaja = array();
              foreach ($response_ventas as   $item) {
   
                  if ( $item["tipo_documento"] != "DNA") {
                      # code...
                      $myObj = new stdClass();


                      $myObj->fecha_creacion = $item["fecha_creacion"];
                      $myObj->fecha_emision = $item["fecha_emision"];
                      $myObj->hora_emision = $item["hora_emision"];
                      $myObj->tipo_documento = $item["tipo_documento"];
                      $myObj->documento = $item["documento"];
                      $myObj->tipo_documento = $item["tipo_documento"];
                      $myObj->tipo_documento = $item["tipo_documento"];
  
                     if ($item["anulado"] != true) {
                      if ($item["vendedor"] != "") {
                          # code...
                      //     $myObj->id = $item["vendedor"];
                      // $myObj->itemidid = $item["id"];
  
                      $myObj->id = $item["vendedor"]["id"]!= null?$item["vendedor"]["id"]:"no id";
                      $myObj->cedula =$item["vendedor"]["cedula"] != null?$item["vendedor"]["cedula"]:"no tiene cedula";
                      $myObj->razon_social = $item["vendedor"]["razon_social"] ;
                    
                      }
                     
                     }

                       
                    //  $myObj->total =$item["total"] ;
                    //  $ListaArqueoCaja[] = $myObj;
                    if (count($item["cobros"]) > 1 ) {
                        foreach ($item["cobros"]  as  $value) {
                            # code...
                            if ($value["forma_cobro"] == "CAJA") {
                                $myObj->EFECTIVO =$value["forma_cobro"] ;
                                $myObj->monto_caja =$value["monto"] ;
                            }
                            if ($value["forma_cobro"] == "TC") {
                                $myObj->TC =$value["forma_cobro"] ;
                                $myObj->monto_tc =$value["monto"] ;
                            }
                            //  $myObj->total =$item["total"] ;
                         }
    
                    }else{
                        foreach ($item["cobros"]  as  $value) {
                            # code...
                            if ($value["forma_cobro"] == "CAJA") {
                                $myObj->EFECTIVO =$value["forma_cobro"] ;
                                $myObj->monto_caja =$value["monto"] ;
                                $myObj->TC ="TC";
                                $myObj->monto_tc ="0" ;
                            } 
                            if ($value["forma_cobro"] == "TC") {
                                $myObj->TC =$value["forma_cobro"] ;
                                $myObj->monto_tc =$value["monto"] ;
                                $myObj->EFECTIVO = "CAJA" ;
                                $myObj->monto_caja ="0";
                            } 
                            //  $myObj->total =$item["total"] ;
                         }
                    }
                    $myObj->total =$item["total"] ;

                     $ListaArqueoCaja[] = $myObj;
                   
  
  
                      // $myObj->id =$item["vendedor"]["id"];
                      // $myObj->cedula = "no tiene cedula";
                      // $myObj->razon_social = 0 ;
                      // $myObj->adicional1_cliente =0;
                      // $myObj->total =0 ;
  
  
                    
  
                  } 
              }

               //cuadre de caja
            $ListaCollectionArqueCaja = collect($ListaArqueoCaja);
            //realizo la agrupacion
              $ListaCollectionArqueCajaPrimer = $ListaCollectionArqueCaja->whereBetween('hora_emision', ["00:00:00", "06:00:00"]);
              // SEGUNDO TURNO
              $ListaCollectionArqueCajaSegundo = $ListaCollectionArqueCaja->whereBetween('hora_emision', ["06:00:00", "14:00:00"]);
              // TERCER TURNO
              $ListaCollectionArqueCajaTercer = $ListaCollectionArqueCaja->whereBetween('hora_emision', ["14:00:00", "22:00:00"]);
              // TERCER TURNO 2
              $ListaCollectionArqueCajaTercerDos = $ListaCollectionArqueCaja->whereBetween('hora_emision', ["22:00:00", "23:59:59"]);
            //primer turno
             $ListaMejorArqueCajaEnviarPrimer = $ListaCollectionArqueCajaPrimer->groupBy('id')->sortByDesc('total');
            // //mapeo la lista
             $ListaMejorArqueCajaPrimer = $ListaMejorArqueCajaEnviarPrimer->map(function($roomHistories, $key) {
                
                return ["sum_total" => round($roomHistories->sum('total'),2),
                "monto_tc" => round($roomHistories->sum('monto_tc'),2),
                "monto_caja" => round($roomHistories->sum('monto_caja'),2),
                "TURNO_1" => "TURNO_1",
                "id" => $roomHistories[0]->id,
                 "vendedor" => $roomHistories[0]->razon_social,
                 "fecha_emision" => $roomHistories[0]->fecha_emision];
               
            });

            //segundo turno
            $ListaMejorArqueCajaEnviarSegundo = $ListaCollectionArqueCajaSegundo->groupBy('id')->sortByDesc('total');
            // //mapeo la lista
             $ListaMejorArqueCajaSegundo = $ListaMejorArqueCajaEnviarSegundo->map(function($roomHistories, $key) {
                
                return ["sum_total" => round($roomHistories->sum('total'),2),
                "monto_tc" => round($roomHistories->sum('monto_tc'),2),
                "monto_caja" => round($roomHistories->sum('monto_caja'),2),
                "TURNO_2" => "TURNO_2",
                "id" => $roomHistories[0]->id,
                 "vendedor" => $roomHistories[0]->razon_social,
                 "fecha_emision" => $roomHistories[0]->fecha_emision];
               
            });

             //tercero turno
             $ListaMejorArqueCajaEnviarTercero = $ListaCollectionArqueCajaTercer->groupBy('id')->sortByDesc('total');
             // //mapeo la lista
              $ListaMejorArqueCajaTercero = $ListaMejorArqueCajaEnviarTercero->map(function($roomHistories, $key) {
                 
                 return ["sum_total" => round($roomHistories->sum('total'),2),
                 "monto_tc" => round($roomHistories->sum('monto_tc'),2),
                 "monto_caja" => round($roomHistories->sum('monto_caja'),2),
                 "TURNO_3" => "TURNO_3",
                 "id" => $roomHistories[0]->id,
                 "vendedor" => $roomHistories[0]->razon_social,
                 "fecha_emision" => $roomHistories[0]->fecha_emision];
                
             });

             //tercero turno dos
             $ListaMejorArqueCajaEnviarTercerDos = $ListaCollectionArqueCajaTercerDos->groupBy('id')->sortByDesc('total');
             // //mapeo la lista
              $ListaMejorArqueCajaTercerDos = $ListaMejorArqueCajaEnviarTercerDos->map(function($roomHistories, $key) {
                 
                 return ["sum_total" => round($roomHistories->sum('total'),2),
                 "monto_tc" => round($roomHistories->sum('monto_tc'),2),
                 "monto_caja" => round($roomHistories->sum('monto_caja'),2),
                 "TURNO_3_2" => "TURNO_3_2",
                 "id" => $roomHistories[0]->id,
                 "vendedor" => $roomHistories[0]->razon_social,
                 "fecha_emision" => $roomHistories[0]->fecha_emision];
                
             });
 

            
          
            return response()->json([
                'documentos_generados' => $ListaColeVentas->where("anulado",false)->count()  ,
                'documentos_anulados' =>  $ListaColeVentas->where("anulado",true)->count()  ,
                'documentos_no_autorizados' =>  $ListaColeVentas->where("tipo_documento","DNA")->count()  ,
                'documentos_notas_creditos' =>  $ListaColeVentas->where("tipo_documento","NCT")->count()  ,
                //'documentos_fac_compra' =>  $ListaColeCompras->where("tipo_registro","PRO")->count()  ,
                'documentos_total_venta' =>round($ListaColeVentas->where("anulado",false)->whereNotIn("tipo_documento",["DNA","NCT"])->sum("total"),2)   ,
                'lista_vendido_produc_suma2' => collect($ListProductotop)->sortByDesc('sum_cantidad')->take(10) ,
                //'lista_vendido_produc_suma2' => $ListProductotop  ,
                'lista_mejor_vendedor' => collect($ListaMejorVendedor)->sortByDesc('sum_total')->take(10)    ,
                //'compra' => $response,
                 'ventas' => $response_ventas ,
                'ListaArqueoCaja' => $ListaMejorArqueCajaPrimer ,
                'ListaMejorArqueCajaSegundo' => $ListaMejorArqueCajaSegundo ,
                'ListaMejorArqueCajaTercero' => $ListaMejorArqueCajaTercero ,
                'ListaMejorArqueCajaEnviarTercerDos' => $ListaMejorArqueCajaTercerDos ,
                //'bodegas' => $ListTotalVentasLocales ,
              

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function GetDocumentoTodoLocales(Request $request)
    {

        try { 

            $user = Auth::user();
            $data_desde = date( $request->fecha_inicial);
            $data_hasta = date( $request->fecha_final);
            $desde = date("d/m/Y", strtotime($data_desde));   
            $hasta = date("d/m/Y", strtotime($data_hasta));   
            //$hasta = date("d/m/Y",$request->fecha_final);
            $bodega_id = $request->bodega_id;


            //array y consulta
 
            $url_bodega = "https://api.contifico.com/sistema/api/v1/bodega/";

            $responseBodegas = $this->makeRequest('GET', $url_bodega);

           $ListaCollectionBodega = collect($responseBodegas);
           $ListTotalVentasLocales = array();

           foreach ($ListaCollectionBodega as  $value) {

            // return response()->json([                
            //     'ListTotalVentasLocales' => $value["id"] ,
            //     //'ListaColeVentas' => $ListaColeVentas ,
            // ], 200);
            
            $url_ventas = "https://api.contifico.com/sistema/api/v1/registro/documento/?tipo_registro=CLI&fecha_inicial=".$desde."&fecha_final=".$hasta."&bodega_id=".$value["id"];
            # code...
            $responseResult= "";
            $responseResult = $this->makeRequest('GET', $url_ventas);

            $myObj = new stdClass();
            $myObj->nombre =$value["nombre"];
            $ListaCollectionVentasTotalesLocal = collect($responseResult);
            $myObj->contenido =round($ListaCollectionVentasTotalesLocal->where("anulado",false)->whereNotIn("tipo_documento",["DNA","NCT"])->sum("total"),2);
            
            $ListTotalVentasLocales[]= $myObj;


           }

            // return response()->json([                
            //     'ListTotalVentasLocales' => $ListTotalVentasLocales ,
            //     //'ListaColeVentas' => $ListaColeVentas ,
            // ], 200);
          

        //    quitar ya mismo

 
            return response()->json([
                // 'documentos_generados' => $ListaColeVentas->where("anulado",false)->count()  ,
                // 'documentos_anulados' =>  $ListaColeVentas->where("anulado",true)->count()  ,
                // 'documentos_no_autorizados' =>  $ListaColeVentas->where("tipo_documento","DNA")->count()  ,
                // 'documentos_notas_creditos' =>  $ListaColeVentas->where("tipo_documento","NCT")->count()  ,
                // 'documentos_fac_compra' =>  $ListaColeCompras->where("tipo_registro","PRO")->count()  ,
                // 'documentos_total_venta' =>round($ListaColeVentas->where("anulado",false)->whereNotIn("tipo_documento","DNA")->sum("total"),2)   ,
                // 'lista_vendido_produc_suma2' => collect($ListProductotop)->sortByDesc('sum_cantidad')->take(10) ,
                // //'lista_vendido_produc_suma2' => $ListProductotop  ,
                // 'lista_mejor_vendedor' => collect($ListaMejorVendedor)->sortByDesc('sum_total')->take(10)    ,
                // 'compra' => $response,
                // 'ventas' => $response_ventas ,
                'ListTotalVentasLocales' =>collect($ListTotalVentasLocales)->whereNotIn("contenido",0) ,
              

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    
    public function GetDocumentoCompraFecha(Request $request)
    {

        try {







            $user = Auth::user();
            $data_desde = date( $request->fecha_inicial);
            $data_hasta = date( $request->fecha_final);
            $desde = date("d/m/Y", strtotime($data_desde));   
            $hasta = date("d/m/Y", strtotime($data_hasta));   
            //$hasta = date("d/m/Y",$request->fecha_final);
            $bodega_id = $request->bodega_id;

 








          //  $url = "";
            $url = "https://api.contifico.com/sistema/api/v1/registro/documento/?tipo_registro=PRO&fecha_inicial=".$desde."&fecha_final=".$hasta."&bodega_id=".$bodega_id;

          
 
            $response = $this->makeRequest('GET', $url);


            $url_ventas = "https://api.contifico.com/sistema/api/v1/registro/documento/?tipo_registro=CLI&fecha_inicial=".$desde."&fecha_final=".$hasta."&bodega_id=".$bodega_id;

          
 
          //  $response_ventas = "";
            $response_ventas = $this->makeRequest('GET', $url_ventas);

            $ListaColeVentas = collect($response_ventas);
            $ListaColeCompras = collect($response);

            $ListProductosVentas = array();
            foreach ($response_ventas as   $item) {
                foreach ( $item["detalles"] as   $item_pro) {
                    if ( $item["tipo_documento"] != "DNA") {
                    $myObj = new stdClass();
                    $myObj->centro_costo_id = $item_pro["centro_costo_id"];
                    $myObj->producto_id =$item_pro["producto_id"];
                    $myObj->producto_nombre =$item_pro["producto_nombre"];
                    $myObj->cantidad =$item_pro["cantidad"];
                    $myObj->precio =$item_pro["precio"];
                    $ListProductosVentas[] = $myObj;
                    }
                }
            }
            //top 10 de mas vendidos
            $ListaColeProductos = collect($ListProductosVentas);
            //realizo la agrupacion
            $ListaMasVendido = $ListaColeProductos->groupBy('producto_id')->sortByDesc('cantidad');
            //mapeo la lista
            $ListaSuma = $ListaMasVendido->map(function($roomHistories, $key) {
              
                return ["sum_cantidad" => $roomHistories->sum('cantidad'),"sum_precio" => $roomHistories->sum('precio'),"producto_nombre"=> $roomHistories[0]->producto_nombre];
               
            });

            //recorro la lista mapeada
            $ListProductotop = array();
            foreach ($ListaSuma as   $item) {
                
                $myObj = new stdClass();
                $myObj->sum_cantidad =$item["sum_cantidad"];
                $myObj->sum_precio = $item["sum_precio"];
                $myObj->producto_nombre =$item["producto_nombre"];
                $ListProductotop[] = $myObj;
                
                 
            }

           

            //mejor vendedor

           
            $ListMejorVendedor = array();
            foreach ($response_ventas as   $item) {
 
                if ( $item["tipo_documento"] != "DNA") {
                    # code...
                    $myObj = new stdClass();
                   // $myObj->id = $item["vendedor"];

                   if ($item["anulado"] != true) {
                    if ($item["vendedor"] != "") {
                        # code...
                    //     $myObj->id = $item["vendedor"];
                    // $myObj->itemidid = $item["id"];

                    $myObj->id = $item["vendedor"]["id"]!= null?$item["vendedor"]["id"]:"no id";
                    $myObj->cedula =$item["vendedor"]["cedula"] != null?$item["vendedor"]["cedula"]:"no tiene cedula";
                    $myObj->razon_social = $item["vendedor"]["razon_social"] ;
                    $myObj->adicional1_cliente =$item["vendedor"]["adicional1_cliente"]!= null?$item["vendedor"]["adicional1_cliente"]:"no tien CA";
                    $myObj->total =$item["total"] ;
                    $ListMejorVendedor[] = $myObj;
                    }
                    # code...

                    
                    
                   }
                 


                    // $myObj->id =$item["vendedor"]["id"];
                    // $myObj->cedula = "no tiene cedula";
                    // $myObj->razon_social = 0 ;
                    // $myObj->adicional1_cliente =0;
                    // $myObj->total =0 ;


                  

                } 
            }

            // return response()->json([                
            //     'ventas' => $ListMejorVendedor ,
            //     'ListaColeVentas' => $ListaColeVentas ,
            // ], 200);
           
            //top 10 de mas vendidos
            $ListaCollectionVendedor = collect($ListMejorVendedor);
            //realizo la agrupacion
            $ListaMejorVendedorEnviar = $ListaCollectionVendedor->groupBy('id')->sortByDesc('total');
            //mapeo la lista
            $ListaMejorVendedor = $ListaMejorVendedorEnviar->map(function($roomHistories, $key) {
              
                return ["sum_total" => $roomHistories->sum('total'),"arregl" => $roomHistories[0]];
               
            });
 

           
            $suma=0;

            



            // $ListaCollectionBodega = $ListaCollectionBodega->filter(function($item){
            //     return strpos($item['nombre'], 'Ventas') !== false;
                
            // });

              //arqueo de caja

           
              $ListaArqueoCaja = array();
              foreach ($response_ventas as   $item) {
   
                  if ( $item["tipo_documento"] != "DNA") {
                      # code...
                      $myObj = new stdClass();


                      $myObj->fecha_creacion = $item["fecha_creacion"];
                      $myObj->fecha_emision = $item["fecha_emision"];
                      $myObj->hora_emision = $item["hora_emision"];
                      $myObj->tipo_documento = $item["tipo_documento"];
                      $myObj->documento = $item["documento"];
                      $myObj->tipo_documento = $item["tipo_documento"];
                      $myObj->tipo_documento = $item["tipo_documento"];
  
                     if ($item["anulado"] != true) {
                      if ($item["vendedor"] != "") {
                          # code...
                      //     $myObj->id = $item["vendedor"];
                      // $myObj->itemidid = $item["id"];
  
                      $myObj->id = $item["vendedor"]["id"]!= null?$item["vendedor"]["id"]:"no id";
                      $myObj->cedula =$item["vendedor"]["cedula"] != null?$item["vendedor"]["cedula"]:"no tiene cedula";
                      $myObj->razon_social = $item["vendedor"]["razon_social"] ;
                    
                      }
                     
                     }

                       
                    //  $myObj->total =$item["total"] ;
                    //  $ListaArqueoCaja[] = $myObj;
                    if (count($item["cobros"]) > 1 ) {
                        foreach ($item["cobros"]  as  $value) {
                            # code...
                            if ($value["forma_cobro"] == "CAJA") {
                                $myObj->EFECTIVO =$value["forma_cobro"] ;
                                $myObj->monto_caja =$value["monto"] ;
                            }
                            if ($value["forma_cobro"] == "TC") {
                                $myObj->TC =$value["forma_cobro"] ;
                                $myObj->monto_tc =$value["monto"] ;
                            }
                            //  $myObj->total =$item["total"] ;
                         }
    
                    }else{
                        foreach ($item["cobros"]  as  $value) {
                            # code...
                            if ($value["forma_cobro"] == "CAJA") {
                                $myObj->EFECTIVO =$value["forma_cobro"] ;
                                $myObj->monto_caja =$value["monto"] ;
                                $myObj->TC ="TC";
                                $myObj->monto_tc ="0" ;
                            } 
                            if ($value["forma_cobro"] == "TC") {
                                $myObj->TC =$value["forma_cobro"] ;
                                $myObj->monto_tc =$value["monto"] ;
                                $myObj->EFECTIVO = "CAJA" ;
                                $myObj->monto_caja ="0";
                            } 
                            //  $myObj->total =$item["total"] ;
                         }
                    }
                    $myObj->total =$item["total"] ;

                     $ListaArqueoCaja[] = $myObj;
                   
  
  
                      // $myObj->id =$item["vendedor"]["id"];
                      // $myObj->cedula = "no tiene cedula";
                      // $myObj->razon_social = 0 ;
                      // $myObj->adicional1_cliente =0;
                      // $myObj->total =0 ;
  
  
                    
  
                  } 
              }

               //cuadre de caja
            $ListaCollectionArqueCaja = collect($ListaArqueoCaja);
            //realizo la agrupacion
              $ListaCollectionArqueCajaPrimer = $ListaCollectionArqueCaja->whereBetween('hora_emision', ["00:00:00", "06:00:00"]);
              // SEGUNDO TURNO
              $ListaCollectionArqueCajaSegundo = $ListaCollectionArqueCaja->whereBetween('hora_emision', ["06:00:00", "14:00:00"]);
              // TERCER TURNO
              $ListaCollectionArqueCajaTercer = $ListaCollectionArqueCaja->whereBetween('hora_emision', ["14:00:00", "22:00:00"]);
              // TERCER TURNO 2
              $ListaCollectionArqueCajaTercerDos = $ListaCollectionArqueCaja->whereBetween('hora_emision', ["22:00:00", "23:59:59"]);
            //primer turno
             $ListaMejorArqueCajaEnviarPrimer = $ListaCollectionArqueCajaPrimer->groupBy('id')->sortByDesc('total');
            // //mapeo la lista
             $ListaMejorArqueCajaPrimer = $ListaMejorArqueCajaEnviarPrimer->map(function($roomHistories, $key) {
                
                return ["sum_total" => round($roomHistories->sum('total'),2),
                "monto_tc" => round($roomHistories->sum('monto_tc'),2),
                "monto_caja" => round($roomHistories->sum('monto_caja'),2),
                "TURNO_1" => "TURNO_1",
                "id" => $roomHistories[0]->id,
                 "vendedor" => $roomHistories[0]->razon_social,
                 "fecha_emision" => $roomHistories[0]->fecha_emision];
               
            });

            //segundo turno
            $ListaMejorArqueCajaEnviarSegundo = $ListaCollectionArqueCajaSegundo->groupBy('id')->sortByDesc('total');
            // //mapeo la lista
             $ListaMejorArqueCajaSegundo = $ListaMejorArqueCajaEnviarSegundo->map(function($roomHistories, $key) {
                
                return ["sum_total" => round($roomHistories->sum('total'),2),
                "monto_tc" => round($roomHistories->sum('monto_tc'),2),
                "monto_caja" => round($roomHistories->sum('monto_caja'),2),
                "TURNO_2" => "TURNO_2",
                "id" => $roomHistories[0]->id,
                 "vendedor" => $roomHistories[0]->razon_social,
                 "fecha_emision" => $roomHistories[0]->fecha_emision];
               
            });

             //tercero turno
             $ListaMejorArqueCajaEnviarTercero = $ListaCollectionArqueCajaTercer->groupBy('id')->sortByDesc('total');
             // //mapeo la lista
              $ListaMejorArqueCajaTercero = $ListaMejorArqueCajaEnviarTercero->map(function($roomHistories, $key) {
                 
                 return ["sum_total" => round($roomHistories->sum('total'),2),
                 "monto_tc" => round($roomHistories->sum('monto_tc'),2),
                 "monto_caja" => round($roomHistories->sum('monto_caja'),2),
                 "TURNO_3" => "TURNO_3",
                 "id" => $roomHistories[0]->id,
                 "vendedor" => $roomHistories[0]->razon_social,
                 "fecha_emision" => $roomHistories[0]->fecha_emision];
                
             });

             //tercero turno dos
             $ListaMejorArqueCajaEnviarTercerDos = $ListaCollectionArqueCajaTercerDos->groupBy('id')->sortByDesc('total');
             // //mapeo la lista
              $ListaMejorArqueCajaTercerDos = $ListaMejorArqueCajaEnviarTercerDos->map(function($roomHistories, $key) {
                 
                 return ["sum_total" => round($roomHistories->sum('total'),2),
                 "monto_tc" => round($roomHistories->sum('monto_tc'),2),
                 "monto_caja" => round($roomHistories->sum('monto_caja'),2),
                 "TURNO_3_2" => "TURNO_3_2",
                 "id" => $roomHistories[0]->id,
                 "vendedor" => $roomHistories[0]->razon_social,
                 "fecha_emision" => $roomHistories[0]->fecha_emision];
                
             });
 

            
          
            return response()->json([
                'documentos_generados' => $ListaColeVentas->where("anulado",false)->count()  ,
                'documentos_anulados' =>  $ListaColeVentas->where("anulado",true)->count()  ,
                'documentos_no_autorizados' =>  $ListaColeVentas->where("tipo_documento","DNA")->count()  ,
                'documentos_notas_creditos' =>  $ListaColeVentas->where("tipo_documento","NCT")->count()  ,
                'documentos_fac_compra' =>  $ListaColeCompras->where("tipo_registro","PRO")->count()  ,
                'documentos_total_venta' =>round($ListaColeVentas->where("anulado",false)->whereNotIn("tipo_documento",["DNA","NCT"])->sum("total"),2)   ,
                'lista_vendido_produc_suma2' => collect($ListProductotop)->sortByDesc('sum_cantidad')->take(10) ,
                //'lista_vendido_produc_suma2' => $ListProductotop  ,
                'lista_mejor_vendedor' => collect($ListaMejorVendedor)->sortByDesc('sum_total')->take(10)    ,
                'compra' => $response,
                 'ventas' => $response_ventas ,
                'ListaArqueoCaja' => $ListaMejorArqueCajaPrimer ,
                'ListaMejorArqueCajaSegundo' => $ListaMejorArqueCajaSegundo ,
                'ListaMejorArqueCajaTercero' => $ListaMejorArqueCajaTercero ,
                'ListaMejorArqueCajaEnviarTercerDos' => $ListaMejorArqueCajaTercerDos ,
                //'bodegas' => $ListTotalVentasLocales ,
              

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function GetBodegasContifico()
    {

        try {
            $user = Auth::user();
            $url = "https://api.contifico.com/sistema/api/v1/bodega/";
 
            $response = $this->makeRequest('GET', $url);

            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
          
            return response()->json([
                'consulta' => $response,
                // 'fecha_reporte_galones' => $fecha_reporte_galones,
                // 'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    
    private function makeRequest($method, $url, $data = null)
    {
        $ch = curl_init();
        set_time_limit(2000);
        ini_set('memory_limit', '-1');
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization:' . 'YlL5LnVsxErqwus5bWJB3Uv8QUR8gVHHpkMvrVjqW3w',
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }

        curl_close($ch);
        return json_decode($response, true);
    }
    public function ConsultarBlindado()
    {

        try {
            $user = Auth::user();

            $validar = tbUsuarioPerfil::where('id_usuario',$user->id)->first();

            if ($validar != null) {
                # code...
                if ($validar->estacion == 0) {
                    # code...
                    $consulta = tb_blindado::DatosFormaPago()->get();
                }else{
                    
                    $consulta = tb_blindado::DatosFormaPago()->whereIn('estacion',[$validar->estacion])->get();  
                }
    
            }else{
                $consulta = [];
            }

         
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
          
            return response()->json([
                'consulta' => $consulta,
                // 'fecha_reporte_galones' => $fecha_reporte_galones,
                // 'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    
    public function createBlindado(Request $request)
    {

        try {
            //code.
            $fechaActual = Carbon::now();
            $user = Auth::user();
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
            $crear = tb_blindado::UpdateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'estacion' => $request->estacion,
                    'tipo_gasto' => $request->tipo_gasto,
                    'fecha_emision' => $request->fecha_emision,
                    'valor' => $request->valor,
                    'deposito_real' => $request->deposito_real,
                    'valor_enviarse' => $request->valor_enviarse,
                    'diferencia' => $request->diferencia,
                    'detalle' => $request->detalle,
                     
                    'created_at' => $fechaActual,
                    'updated_at' => $fechaActual,
                ]

            );
         
             
            $wasCreated = $crear->wasRecentlyCreated;




            return response()->json(['mensaje' => $wasCreated,
            'data' => $wasCreated], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarTiposGasto()
    {

        try {
            $user = Auth::user();

            $validar = tbUsuarioPerfil::where('id_usuario',$user->id)->first();

            if ($validar != null) {
                # code...
                if ($validar->estacion == 0) {
                    # code...
                    $consulta = tb_tipo_gasto::all();
                }else{
                    
                    $consulta = tb_tipo_gasto::whereIn('id',[1,4,5])->get();  
                }
    
            }else{
                $consulta = [];
            }
            


            //code.
            
         
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
          
            return response()->json([
                'consulta' => $consulta,
                // 'fecha_reporte_galones' => $fecha_reporte_galones,
                // 'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarGastosEstacion()
    {

        try {
            $user = Auth::user();

            $validar = tbUsuarioPerfil::where('id_usuario',$user->id)->first();

            if ($validar != null) {
                # code...
                if ($validar->estacion == 0) {
                    # code...
                    $consulta = tb_gastos_estaciones::DatosFormaPago()->get();
                }else{
                    
                    $consulta = tb_gastos_estaciones::DatosFormaPago()->whereIn('tipo_gasto',[1,4,5])->whereIn('estacion',[$validar->estacion])->get();  
                }
    
            }else{
                $consulta = [];
            }

         
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
          
            return response()->json([
                'consulta' => $consulta,
                // 'fecha_reporte_galones' => $fecha_reporte_galones,
                // 'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function createGastosEstacion(Request $request)
    {

        try {
            //code.
            $fechaActual = Carbon::now();
            $user = Auth::user();
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
            $crear = tb_gastos_estaciones::UpdateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'estacion' => $request->estacion,
                    'tipo_gasto' => $request->tipo_gasto,
                    'fecha_emision' => $request->fecha_emision,
                    'detalle' => $request->detalle,
                    'proveedor' => $request->proveedor,
                    'ruc' => $request->ruc,
                    'factura' => $request->factura,
                    'total' => $request->total,
                   
                    'created_at' => $fechaActual,
                    'updated_at' => $fechaActual,
                ]

            );
         
             
            $wasCreated = $crear->wasRecentlyCreated;




            return response()->json(['mensaje' => $wasCreated,
            'data' => $wasCreated], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarProveedor()
    {

        try {
            //code.
            $fechaActual = Carbon::now();
            $consulta = tb_proveedores::all();
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
          
            return response()->json([
                'consulta' => $consulta,
                // 'fecha_reporte_galones' => $fecha_reporte_galones,
                // 'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function createProveedor(Request $request)
    {

        try {
            //code.
            $fechaActual = Carbon::now();
            $user = Auth::user();
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
            $crear = tb_proveedores::UpdateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                    'ruc' => $request->ruc,
                    'cedula' => $request->cedula,
                    'razon_social' => $request->razon_social,
                    'direccion' => $request->direccion,
                    'telefono' => $request->telefono,
                    'correo' => $request->correo,
                    'usu_created' => $user->id,
                    'usu_update' =>  $user->id,                  
                    'created_at' => $request->created_at,
                    'updated_at' => $request->updated_at,
                ]

            );
         
             
            $wasCreated = $crear->wasRecentlyCreated;




            return response()->json(['mensaje' => $wasCreated,
            'data' => $wasCreated], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarCombustible()
    {

        try {
            //code.
            $fechaActual = Carbon::now();
            $user = Auth::user();
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
            $consulta = tb_guias_combustibles::DatosFormaPago()->get();
            return response()->json([
                'consultaCombustible' => $consulta,
                // 'fecha_reporte_galones' => $fecha_reporte_galones,
                // 'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function createCombustible(Request $request)
    {

        try {
            //code.
            $fechaActual = Carbon::now();
            $user = Auth::user();
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
            $crear = tb_guias_combustibles::UpdateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'estacion' => $request->estacion,
                    'anio' => $request->anio,
                    'mes' => $request->mes,
                    'fecha_emision' => $request->fecha_emision,
                    'fecha_entrega' => $request->fecha_entrega,
                    'orden' => $request->orden,
                    'producto' => $request->producto,
                    'desproducto' => $request->desproducto,
                    'pedido' => $request->pedido,
                    'galones_facturado' => $request->galones_facturado,
                    'total' => $request->total,
                    'created_at' => $fechaActual,
                    'updated_at' => $fechaActual,
                ]

            );
         
             
            $wasCreated = $crear->wasRecentlyCreated;




            return response()->json(['mensaje' => $wasCreated,
            'data' => $wasCreated], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ReporteFuelCorp(Request $request)
    {
        try {

            $desde = date($request->desde);
            $hasta = date($request->hasta);
            $estacion = $request->estacion;
            $mes = date("m", strtotime($desde));
            $anio = date("Y", strtotime($desde));
            
            // $desde = date($fechadesde);
            // $hasta = date($fechahasta);
            // $mes = date("m", strtotime($fechadesde));
            // $anio = date("Y", strtotime($fechadesde));
            
            if ($estacion == 0) {
                # code...
                // $fecha_reporte= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idFormaPago = 1 then total else 0 end) as EFECTIVO
                // ,sum(case when idFormaPago = 19 then total else 0 end) as MEDIO_DIGITAL
                // ,sum(case when idFormaPago = 20 then total else 0 end) as CHEQUE
                // ,sum(case when idFormaPago = 22 then total else 0 end) as TRANSFERENCIA
                // ,sum(case when idFormaPago = 23 then total else 0 end) as CREDITO
                // ,sum(case when idFormaPago = 24 then total else 0 end) as CALIBRACIONES
                // ,sum(total) as TOTAL")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('idFormaPago','<>', 24)
                // ->where('TipoVenta', '<>', 'GEN')
                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();
                $fecha_reporte= tb_resumen_dolares::whereBetween('fecha', [$desde, $hasta])               
                ->orderby('fecha', 'asc')
                ->get();


                // $fecha_reporte_galones= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', '<>', 24)
                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();
                $fecha_reporte_galones= tb_resumen_galones::whereBetween('fecha', [$desde, $hasta]) 
                 ->where('tipo','SC')            
                ->orderby('fecha', 'asc')
                ->get();


                // $fecha_reporte_galones_calibracion= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', 24)
                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();

                $fecha_reporte_galones_calibracion= tb_resumen_galones::whereBetween('fecha', [$desde, $hasta])    
                ->where('tipo','CC')         
                ->orderby('fecha', 'asc')
                ->get();


                // $fecha_GASTOS= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', 24)
                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();
                
                $fecha_gastos= tb_gastos_estaciones::selectRaw("CONVERT(fecha_emision, DATE) as fecha_emision,
                sum(case when tipo_gasto = 1 then total else 0 end) as GASTO_ADICIONALES
                ,sum(case when tipo_gasto = 2 then total else 0 end) as GASTOS_ADMINISTRATIVO
                ,sum(case when tipo_gasto = 4 then total else 0 end) as GENERADOR
                ,sum(case when tipo_gasto = 5 then total else 0 end) as FALTANTE_ARQUEO_CAJA
                ,sum(case when tipo_gasto = 6 then total else 0 end) as GASTOS_OPERATIVO
                ,sum(total) as TOTAL_GASTOS")
                ->whereMonth('fecha_emision',$mes)
                ->groupBy('fecha_emision')
                ->orderby('fecha_emision', 'asc')
                ->get();

                $fecha_gastos_detalle= tb_gastos_estaciones::DatosFormaPago()->whereMonth('fecha_emision',$mes)
                ->orderby('fecha_emision', 'asc')
                ->get();

                // $fecha_reporte = tb_data_estaciones::DatosFormaPago()
                //     ->whereBetween('FechaApertura', [$desde, $hasta])
                //     ->get();

                    

                    
                  //  $fecha_reporte = $fecha_reporte_2->role;

                  
                    // aqui va la agrupacion
                    $fecha_ordenes = tb_guias_combustibles::DatosFormaPago()
                 //   ->where('estacion', $estacion)
                    ->whereMonth('fecha_emision',$mes)
                    ->orderby('fecha_emision', 'asc')
                    ->get();

                    $fecha_blindado = tb_blindado::DatosFormaPago()
                   // ->where('estacion', $estacion)
                    ->whereMonth('fecha_emision',$mes)
                    ->orderby('fecha_emision', 'asc')
                    ->get();
    

                  
                  

            } else {
                # code...
               

 
                // $fecha_reporte= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idFormaPago = 1 then total else 0 end) as EFECTIVO
                // ,sum(case when idFormaPago = 19 then total else 0 end) as MEDIO_DIGITAL
                // ,sum(case when idFormaPago = 20 then total else 0 end) as CHEQUE
                // ,sum(case when idFormaPago = 22 then total else 0 end) as TRANSFERENCIA
                // ,sum(case when idFormaPago = 23 then total else 0 end) as CREDITO
                // ,sum(case when idFormaPago = 24 then total else 0 end) as CALIBRACIONES
                // ,sum(total) as TOTAL")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('idFormaPago','<>', 24)
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('estacion', $estacion)

                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();

                
                $fecha_reporte= tb_resumen_dolares::whereBetween('fecha', [$desde, $hasta])
                ->where('estacion', $estacion)               
                ->orderby('fecha', 'asc')
                ->get();


                // $fecha_reporte_galones= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', '<>', 24)
                // ->where('estacion', $estacion)

                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();

                $fecha_reporte_galones= tb_resumen_galones::whereBetween('fecha', [$desde, $hasta]) 
                ->where('estacion', $estacion)   
                ->where('tipo','SC')            
               ->orderby('fecha', 'asc')
               ->get();


                // $fecha_reporte_galones_calibracion= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', 24)
                // ->groupBy('fecha')
                // ->where('estacion', $estacion)
                // ->orderby('fecha', 'asc')
                // ->get();

                $fecha_reporte_galones_calibracion= tb_resumen_galones::whereBetween('fecha', [$desde, $hasta])   
                ->where('estacion', $estacion)   
                ->where('tipo','CC')         
                ->orderby('fecha', 'asc')
                ->get();

                $fecha_gastos= tb_gastos_estaciones::selectRaw("CONVERT(fecha_emision, DATE) as fecha_emision,
                sum(case when tipo_gasto = 1 then total else 0 end) as GASTO_ADICIONALES
                ,sum(case when tipo_gasto = 2 then total else 0 end) as GASTOS_ADMINISTRATIVO
                ,sum(case when tipo_gasto = 4 then total else 0 end) as GENERADOR
                ,sum(case when tipo_gasto = 5 then total else 0 end) as FALTANTE_ARQUEO_CAJA
                ,sum(case when tipo_gasto = 6 then total else 0 end) as GASTOS_OPERATIVO
                ,sum(total) as TOTAL_GASTOS")
                ->whereMonth('fecha_emision',$mes)
                ->where('estacion', $estacion)
                ->groupBy('fecha_emision')
                ->orderby('fecha_emision', 'asc')
                ->get();

                $fecha_gastos_detalle= tb_gastos_estaciones::DatosFormaPago()
                ->where('estacion', $estacion)
                ->whereMonth('fecha_emision',$mes)
                ->orderby('fecha_emision', 'asc')
                ->get();

                

                $fecha_ordenes = tb_guias_combustibles::DatosFormaPago()
                ->where('estacion', $estacion)
                ->whereMonth('fecha_emision',$mes)
                ->orderby('fecha_emision', 'asc')
                ->get();

                $fecha_blindado = tb_blindado::DatosFormaPago()
                ->where('estacion', $estacion)
                ->whereMonth('fecha_emision',$mes)
                ->orderby('fecha_emision', 'asc')
                ->get();

 
 

            }

           $lista = [
                'fecha_reporte' => $fecha_reporte,
                'fecha_reporte_galones' => $fecha_reporte_galones,
                'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                'fecha_gastos' => $fecha_gastos,
                'fecha_gastos_detalle' => $fecha_gastos_detalle,
                'fecha_ordenes' => $fecha_ordenes,
                'fecha_blindado' => $fecha_blindado,
                // 'Vendedor' => $vendedor,

           ];


            $nameExcel = 'Reporte Por Estacion Efectivo-' . $hasta . '.xls';
            //return  response()->json(['data' =>$resultado], 200);

          //  return view('reports.excel_excel', ['lista' => $listado]);

            return Excel::download(
                new UsersExport($lista, 'Reporte General de Desechos'),
                $nameExcel,
                header("Content-Type: application/vnd.ms-excel;")
            );

             
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarReporteFuelcorp($estacion, $fechadesde, $fechahasta)
    {
        try {

            $desde = date($fechadesde);
            $hasta = date($fechahasta);
            $mes = date("m", strtotime($fechadesde));
            $anio = date("Y", strtotime($fechadesde));
            
            if ($estacion == 0) {
                # code...
                // $fecha_reporte= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idFormaPago = 1 then total else 0 end) as EFECTIVO
                // ,sum(case when idFormaPago = 19 then total else 0 end) as MEDIO_DIGITAL
                // ,sum(case when idFormaPago = 20 then total else 0 end) as CHEQUE
                // ,sum(case when idFormaPago = 22 then total else 0 end) as TRANSFERENCIA
                // ,sum(case when idFormaPago = 23 then total else 0 end) as CREDITO
                // ,sum(case when idFormaPago = 24 then total else 0 end) as CALIBRACIONES
                // ,sum(total) as TOTAL")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('idFormaPago','<>', 24)
                // ->where('TipoVenta', '<>', 'GEN')
                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();


                $fecha_reporte= tb_resumen_dolares::whereBetween('fecha', [$desde, $hasta])               
                ->orderby('fecha', 'asc')
                ->get();

                // $fecha_reporte_galones= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', '<>', 24)
                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();

                 $fecha_reporte_galones= tb_resumen_galones::whereBetween('fecha', [$desde, $hasta]) 
                 ->where('tipo','SC')            
                ->orderby('fecha', 'asc')
                ->get();


                // $fecha_reporte_galones_calibracion= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', 24)
                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();

                $fecha_reporte_galones_calibracion= tb_resumen_galones::whereBetween('fecha', [$desde, $hasta])    
                ->where('tipo','CC')         
                ->orderby('fecha', 'asc')
                ->get();


                $fecha_gastos= tb_gastos_estaciones::selectRaw("CONVERT(fecha_emision, DATE) as fecha_emision,
                sum(case when tipo_gasto = 1 then total else 0 end) as GASTO_ADICIONALES
                ,sum(case when tipo_gasto = 2 then total else 0 end) as GASTOS_ADMINISTRATIVO
                ,sum(case when tipo_gasto = 4 then total else 0 end) as GENERADOR
                ,sum(case when tipo_gasto = 5 then total else 0 end) as FALTANTE_ARQUEO_CAJA
                ,sum(case when tipo_gasto = 6 then total else 0 end) as GASTOS_OPERATIVO
                ,sum(total) as TOTAL_GASTOS")
                ->whereMonth('fecha_emision',$mes)
                ->groupBy('fecha_emision')
                ->orderby('fecha_emision', 'asc')
                ->get();

                $fecha_gastos_detalle= tb_gastos_estaciones::DatosFormaPago()->whereMonth('fecha_emision',$mes)
                ->orderby('fecha_emision', 'asc')
                ->get();
                // $fecha_reporte = tb_data_estaciones::DatosFormaPago()
                //     ->whereBetween('FechaApertura', [$desde, $hasta])
                //     ->get();

                    

                    
                  //  $fecha_reporte = $fecha_reporte_2->role;

                  
                    // aqui va la agrupacion

                  
                  

            } else {
                # code...
                // $fecha_reporte= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idFormaPago = 1 then total else 0 end) as EFECTIVO
                // ,sum(case when idFormaPago = 19 then total else 0 end) as MEDIO_DIGITAL
                // ,sum(case when idFormaPago = 20 then total else 0 end) as CHEQUE
                // ,sum(case when idFormaPago = 22 then total else 0 end) as TRANSFERENCIA
                // ,sum(case when idFormaPago = 23 then total else 0 end) as CREDITO
                // ,sum(case when idFormaPago = 24 then total else 0 end) as CALIBRACIONES
                // ,sum(total) as TOTAL")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('idFormaPago','<>', 24)
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('estacion', $estacion)

                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();

                $fecha_reporte= tb_resumen_dolares::whereBetween('fecha', [$desde, $hasta])
                ->where('estacion', $estacion)               
                ->orderby('fecha', 'asc')
                ->get();


                // $fecha_reporte_galones= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', '<>', 24)
                // ->where('estacion', $estacion)

                // ->groupBy('fecha')
                // ->orderby('fecha', 'asc')
                // ->get();
                $fecha_reporte_galones= tb_resumen_galones::whereBetween('fecha', [$desde, $hasta]) 
                ->where('estacion', $estacion)   
                ->where('tipo','SC')            
               ->orderby('fecha', 'asc')
               ->get();

                // $fecha_reporte_galones_calibracion= tb_data_estaciones::selectRaw("CONVERT(FechaApertura, DATE) as fecha,
                // sum(case when idProducto = 1 then galones else 0 end) as EXTRA_CON_ETANOL
                // ,sum(case when idProducto = 2 then galones else 0 end) as DIESEL
                // ,sum(case when idProducto = 3 then galones else 0 end) as SUPER_PREMIUM_95
                // ,sum(galones) as TOTAL_GALONES")
                // ->whereBetween('FechaApertura', [$desde, $hasta])
                // ->where('TipoVenta', '<>', 'GEN')
                // ->where('idFormaPago', 24)
                // ->groupBy('fecha')
                // ->where('estacion', $estacion)
                // ->orderby('fecha', 'asc')
                // ->get();

                $fecha_reporte_galones_calibracion= tb_resumen_galones::whereBetween('fecha', [$desde, $hasta])   
                ->where('estacion', $estacion)   
                ->where('tipo','CC')         
                ->orderby('fecha', 'asc')
                ->get();

                
                $fecha_gastos= tb_gastos_estaciones::selectRaw("CONVERT(fecha_emision, DATE) as fecha_emision,
                sum(case when tipo_gasto = 1 then total else 0 end) as GASTO_ADICIONALES
                ,sum(case when tipo_gasto = 2 then total else 0 end) as GASTOS_ADMINISTRATIVO
                ,sum(case when tipo_gasto = 4 then total else 0 end) as GENERADOR
                ,sum(case when tipo_gasto = 5 then total else 0 end) as FALTANTE_ARQUEO_CAJA
                ,sum(case when tipo_gasto = 6 then total else 0 end) as GASTOS_OPERATIVO
                ,sum(total) as TOTAL_GASTOS")
                ->whereMonth('fecha_emision',$mes)
                ->where('estacion', $estacion)
                ->groupBy('fecha_emision')
                ->orderby('fecha_emision', 'asc')
                ->get();

                $fecha_gastos_detalle= tb_gastos_estaciones::DatosFormaPago()
                ->where('estacion', $estacion)
                ->whereMonth('fecha_emision',$mes)
                ->orderby('fecha_emision', 'asc')
                ->get();
 

 
 

            }



            return response()->json([
                'TotalesEstaciones' => $fecha_reporte,
                'fecha_reporte_galones' => $fecha_reporte_galones,
                'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                'fecha_gastos' => $fecha_gastos,
                'fecha_gastos_detalle' => $fecha_gastos_detalle,
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarReporte($estacion, $fechadesde, $fechahasta)
    {
        try {

            $desde = date($fechadesde);
            $hasta = date($fechahasta);
            $mes = date("m", strtotime($fechadesde));
            $anio = date("Y", strtotime($fechadesde));
            
            if ($estacion == 0) {
                # code...
                $fecha_reporte = tb_lubricantes::DatosEstacion()
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->get();

                    $producto = tb_lubricantes::selectRaw("idProducto,DesProducto,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
                   
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->groupBy('idProducto', 'DesProducto')
                    ->orderby('Total_cantidad', 'desc')
                    ->get();

                    $productoVentaStock = tb_lubricantes_stock_esta::DatosEstacion()
                    ->where("idEstado", 1)
                    ->get();

                    // aqui va la agrupacion

                    // $productoVenta = tb_lubricantes_stock_vent::DatosEstacion()->where("mes", intval($mes))
                    // //->select(\DB::raw('SUBSTRING(DesProducto, 6, 0) as DesProducto_s'))
                    // ->where("anio", $anio)
                    // ->orderby('stock', 'desc')->get();
                    $productoVenta = tb_lubricantes_stock_vent::where("mes", intval($mes))
                    ->selectRaw("mes,anio,SUBSTRING(DesProducto, 1, 6) as codigop,SUM(stock) as stock,SUM(facturado) as facturado,SUM(total) as total")
                    ->where("mes", intval($mes))
                    ->where("anio", $anio)
                    ->groupBy('anio','mes', 'codigop')
                    ->orderby('stock', 'desc')
                    ->get();

                  

            } else {
                # code...
                $fecha_reporte = tb_lubricantes::DatosEstacion()
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->where('estacion', $estacion)
                    ->get();

                    $producto = tb_lubricantes::selectRaw("idProducto,DesProducto,estacion,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
                    ->DatosEstacion()
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->where('estacion', $estacion)
                    ->groupBy('estacion', 'idProducto', 'DesProducto')
                    ->orderby('estacion', 'desc')
                    ->orderby('Total_cantidad', 'desc')
                    ->orderby('Total_dolares', 'desc')
                    ->get();


                    $productoVentaStock = tb_lubricantes_stock_esta::DatosEstacion()
                    ->where("estacion", $estacion)
                    ->where("idEstado", 1)
                    ->get();

                    // $productoVenta = tb_lubricantes_stock_vent::DatosEstacion()->where("mes", intval($mes))
                    // ->where("anio", $anio)->where("estacion", $estacion)->orderby('stock', 'desc')->get();

                    $productoVenta = tb_lubricantes_stock_vent::where("estacion", $estacion)
                    ->selectRaw("mes,anio,SUBSTRING(DesProducto, 1, 6) as codigop,SUM(stock) as stock,SUM(facturado) as facturado,SUM(total) as total")
                    ->DatosEstacion()
                    
                    ->where("mes", intval($mes))
                    ->where("anio", $anio)
                    ->groupBy('estacion','anio','mes', 'codigop')
                    ->orderby('stock', 'desc')
                    ->get();
        

            }



            return response()->json([
                'TotalesEstaciones' => $fecha_reporte,
                'TotalesEstacionesProducto' => $producto,
                'productoVentaStock' => $productoVentaStock,
                'productoVenta' => $productoVenta,
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarVendedorPorEstacion($mes, $anio)
    {
        try {

            $resultado = tb_lubricantes::selectRaw("mes,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
                ->DatosEstacion()
                ->where("mes", $mes)
                ->where("anio", $anio)
                ->groupBy('estacion', 'mes')
                ->orderby('Total_cantidad', 'desc')
                ->get();


            $vendedor = tb_lubricantes::selectRaw("Vendedor,SUM(MontoDolaresDes) as Total_dolares")
                ->DatosEstacion()
                ->where("mes", $mes)
                ->where("anio", $anio)
                ->groupBy('estacion', 'Vendedor')
                ->orderby('estacion', 'desc')
                ->orderby('Total_dolares', 'desc')
                ->get();

            $producto = tb_lubricantes::selectRaw("idProducto,DesProducto,estacion,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
                ->DatosEstacion()
                ->where("mes", $mes)
                ->where("anio", $anio)
                ->groupBy('estacion', 'idProducto', 'DesProducto')
                ->orderby('estacion', 'desc')
                ->orderby('Total_cantidad', 'desc')
                ->orderby('Total_dolares', 'desc')
                ->get();

            $vendedorPorEstacion = tb_lubricantes::selectRaw("idVendedor,Vendedor,estacion,SUM(MontoDolaresDes) as Total_dolares")
                ->DatosEstacion()
                ->where("mes", $mes)
                ->where("anio", $anio)
                ->groupBy('estacion', 'idVendedor', 'Vendedor')
                ->orderby('estacion', 'desc')
                ->get();
               

                $vendedorPorEstacionCantidad = tb_lubricantes::selectRaw("idVendedor,Vendedor,estacion, SUM(Cantidad) as Total_cantidad")
                ->DatosEstacion()
                ->where("mes", $mes)
                ->where("anio", $anio)
                ->groupBy('estacion', 'idVendedor', 'Vendedor')
                ->orderby('estacion', 'desc')

                ->get();




            $ListadoVendedor = $vendedorPorEstacion->groupBy('estacion')->map(function ($group, $groupName) {
                return [
                    'name' => $groupName,
                    'max' => $group->firstWhere('Total_dolares', $group->max('Total_dolares')),
                     

                ];
            });

            $ListadoVendedorCantidad = $vendedorPorEstacionCantidad->groupBy('estacion')->map(function ($group, $groupName) {
                return [
                    'name' => $groupName,
                    
                    'maxC' => $group->firstWhere('Total_cantidad', $group->max('Total_cantidad')),

                ];
            });

            $ListadoProducto = $producto->groupBy('estacion')->map(function ($group, $groupName) {
                return [
                    'name' => $groupName,
                    'max' => $group->firstWhere('Total_cantidad', $group->max('Total_cantidad')),
                    // 'maxC' => $group->firstWhere('Total_cantidad', $group->max('Total_cantidad')),

                ];
            });

            $ListadoProductoMin = $producto->groupBy('estacion')->map(function ($group, $groupName) {
                return [
                    'name' => $groupName,
                    'min' => $group->firstWhere('Total_cantidad', $group->min('Total_cantidad')),
                    // 'minC' => $group->firstWhere('Total_cantidad', $group->min('Total_cantidad')),

                ];
            });

            ///stock actualizado por ventas
           
            

            $vendedorPorEstacionTodos = tb_lubricantes::selectRaw("idVendedor,Vendedor,estacion,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
            ->DatosEstacion()
            ->where("mes", $mes)
            ->where("anio", $anio)
            ->groupBy('estacion', 'idVendedor', 'Vendedor')
            ->orderby('estacion', 'desc')
            ->orderby('Total_cantidad', 'desc')
            ->get();
        // $resultado =tb_consulta_mes::where("estacion",$estacion)->
        // where("mes",$mes)
        // ->get()->groupBy('mes');
        $ListadoVendedorTodos = $vendedorPorEstacionTodos->groupBy('estacion')->map(function ($group, $groupName) {
            if ( count($group->take(2)) >=2) {
                # code...
                return [
                    'name' => $groupName,
                    // 'max' => $group,
                   // 'max' => count($group->take(2)) = 1 ? $group->take(3) :  $group->take(2),
                    'max' =>   $group->take(2),
                //  'maxC' => $group->firstWhere('Total_cantidad', $group->max('Total_cantidad')),
                     
    
                ];
            }
           
        });

            return response()->json([
                'TotalesVendido' => $resultado,
                // 'Vendedor' => $vendedor,
                'productoMax' => $ListadoProducto,
                'productoMin' => $ListadoProductoMin,
                 'vendedorPorEstacion' => $vendedorPorEstacion,
                'vendedorPorEstacionCantidad' => $vendedorPorEstacionCantidad,
                 'ListadoVendedorCantidad' => $ListadoVendedorCantidad,
                //'ListadoVendedor' => $ListadoVendedor,
                'vendedorPorEstacionTodos' => $vendedorPorEstacionTodos,
                'ListadoVendedorTodosMax' => $ListadoVendedorTodos,
                 
           
            ], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarUsuario()
    {
        try {
            $user = Auth::user();


            return response()->json(['user' => $user], 200);

        } catch (Exception $e) {
            return response()->json(['msj' => $e->getMessage()], 500);
        }
    }
    public function User()
    {
        try {


            $resultado = User::All();


            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    //
    public function IncipSession($id)
    {
        try {


            $resultado = User::where("id", $id)->get();


            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarInformacion()
    {
        try {


            $resultado = DB::select("call buscarDatos");


            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarDatos()
    {

        try {
            $fecha = date('Y-m-d');
            $resultado = tbResponsable::all();

            $kilos_dia = tbIngresoInfo::whereDate('created_at', $fecha)->get();
            $kilos_total = tbIngresoInfo::all();





            return response()->json([
                'toal_registro' => $resultado->count(),
                'kilos_dia' => $kilos_dia->sum('peso'),
                'kilos_total' => $kilos_total->sum('peso')
            ], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarCalender($id)
    {
        try {


            $resultado = User::where("id", $id)->get();


            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarMes($estacion, $mes, $anio)
    {
        try {

            if ($mes == 99) {
                # code...
                $resultado = tb_consulta_mes::where("estacion", $estacion)
                    ->where("anio", 2024)
                    ->get()->groupBy('mes');
            } else {

                $resultado = tb_consulta_mes::where("estacion", $estacion)->
                    where("mes", $mes)->
                    where("anio", $anio)
                    ->get();
            }

            // $resultado =tb_consulta_mes::where("estacion",$estacion)->
            // where("mes",$mes)
            // ->get()->groupBy('mes');



            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarDia($estacion)
    {
        try {



            $resultado = tb_consulta_dia::where("estacion", $estacion)->get()->groupBy('dia');


            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarEstaciones()
    {
        try {



            $resultado = tb_estaciones::all();


            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarGastosEDS($estacion, $mes, $anio)
    {
        try {

            if ($estacion == 0) {
                $resultado = tb_gastos::where("mes", $mes)
                    ->where("anio", $anio)
                    ->get();
            } else {
                $resultado = tb_gastos::where("id_estacion", $estacion)
                    ->where("mes", $mes)
                    ->where("anio", $anio)
                    ->get();
            }




            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarDiaPorEstacion($fecha)
    {
        try {

            $fecha_actual = date($fecha);
            //sumo 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "+ 1 days"));
            //resto 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "- 1 days"));

            # code...
            $resultado = tb_consulta_dia::selectRaw("dia,SUM(total) as total_dolares")
                ->selectRaw("SUM(galones) as galones")
                ->where('dia', '=', $fecha_actual)
                ->DatosEstacion()
                ->groupBy('estacion', 'dia')
                ->orderby('total_dolares', 'desc')
                ->get();

            // $resultado =tb_consulta_mes::where("estacion",$estacion)->
            // where("mes",$mes)
            // ->get()->groupBy('mes');



            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function createreporteExcel(Request $request)
    {

        //return  response()->json(['data' =>$request->all()], 200);
        try {

            $fecha_actual = date($request->fecha);
            //sumo 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "+ 1 days"));
            //resto 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "- 1 days"));

            # code...
            $resultado = tb_consulta_dia::selectRaw("dia,SUM(total) as total_dolares")
                ->selectRaw("SUM(galones) as galones")
                ->where('dia', '=', $fecha_actual)
                ->DatosEstacion()
                ->groupBy('estacion', 'dia')
                ->orderby('total_dolares', 'desc')
                ->get();


            $fecha = date('y-m-d');


            $nameExcel = 'Reporte Por Estacion Efectivo-' . $fecha . '.xls';
            //return  response()->json(['data' =>$resultado], 200);

            return Excel::download(
                new UsersExport($resultado, 'Reporte General de Desechos'),
                $nameExcel,
                header("Content-Type: application/vnd.ms-excel;")
            );





        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function createreporteExcelLubricantes(Request $request)
    {

        //return  response()->json(['data' =>$request->all()], 200);
        try {

            $fecha_actual = date($request->fecha);
            //sumo 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "+ 1 days"));
            //resto 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "- 1 days"));

            # code...
            $desde = date($request->desde);
            $hasta = date($request->hasta);

            if ($request->estacion == 0) {
                # code...
                $fecha_reporte = tb_lubricantes::DatosEstacion()
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->get();

                    $producto = tb_lubricantes::selectRaw("idProducto,DesProducto,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
                   
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->groupBy('idProducto', 'DesProducto')
                    ->orderby('Total_cantidad', 'desc')
                    ->get();


            } else {
                # code...
                $fecha_reporte = tb_lubricantes::DatosEstacion()
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->where('estacion', $request->estacion)
                    ->get();

                    $producto = tb_lubricantes::selectRaw("idProducto,DesProducto,estacion,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
                    ->DatosEstacion()
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->where('estacion', $request->estacion)
                    ->groupBy('estacion', 'idProducto', 'DesProducto')
                    ->orderby('estacion', 'desc')
                    ->orderby('Total_cantidad', 'desc')
                    ->orderby('Total_dolares', 'desc')
                    ->get();

            }

            $fecha = date('y-m-d');


            $nameExcel = 'Reporte Lubricacion Efectivo-' . $fecha . '.xls';
            //return  response()->json(['data' =>$resultado], 200);

            return Excel::download(
                new LibriExport($fecha_reporte, 'Reporte General de Desechos'),
                $nameExcel,
                header("Content-Type: application/vnd.ms-excel;")
            );





        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function createreporteExcelLubricantesConsolidado(Request $request)
    {

        //return  response()->json(['data' =>$request->all()], 200);
        try {

            $fecha_actual = date($request->fecha);
            //sumo 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "+ 1 days"));
            //resto 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "- 1 days"));

            # code...
            $desde = date($request->desde);
            $hasta = date($request->hasta);

            if ($request->estacion == 0) {
                # code...
               
                    $producto = tb_lubricantes::selectRaw("idProducto,DesProducto,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
                   
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->groupBy('idProducto', 'DesProducto')
                    ->orderby('Total_cantidad', 'desc')
                    ->get();


            } else {
                # code...
             

                    $producto = tb_lubricantes::selectRaw("idProducto,DesProducto,estacion,SUM(Cantidad) as Total_cantidad,SUM(MontoDolaresDes) as Total_dolares")
                    ->DatosEstacion()
                    ->whereBetween('Fecha', [$desde, $hasta])
                    ->where('estacion', $request->estacion)
                    ->groupBy('estacion', 'idProducto', 'DesProducto')
                    ->orderby('estacion', 'desc')
                    ->orderby('Total_cantidad', 'desc')
                    ->orderby('Total_dolares', 'desc')
                    ->get();

            }

            $fecha = date('y-m-d');


            $nameExcel = 'Reporte Lubricacion Efectivo-' . $fecha . '.xls';
            //return  response()->json(['data' =>$resultado], 200);

            return Excel::download(
                new LubriConsolidadoExport($producto, 'Reporte General de Desechos'),
                $nameExcel,
                header("Content-Type: application/vnd.ms-excel;")
            );





        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function createreporteExcelLubricantesStockVentas(Request $request)
    {

        //return  response()->json(['data' =>$request->all()], 200);
        try {

            $fecha_actual = date($request->fecha);
            //sumo 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "+ 1 days"));
            //resto 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "- 1 days"));

            # code...
            $desde = date($request->desde);
            $hasta = date($request->hasta);
            $mes = date("m", strtotime($desde));
            $anio = date("Y", strtotime($desde));

            if ($request->estacion == 0) {
                # code...
               
                // $productoVenta = tb_lubricantes_stock_vent::DatosEstacion()->where("mes", intval($mes))
                // ->where("anio", $anio)->orderby('stock', 'desc')->get();
                $productoVenta = tb_lubricantes_stock_vent::selectRaw("mes,anio,SUBSTRING(DesProducto, 1, 6) as codigop,SUM(stock) as stock,SUM(facturado) as facturado,SUM(total) as total")
                ->where("mes", intval($mes))
                ->where("anio", $anio)
                ->groupBy('anio','mes', 'codigop')
                ->orderby('stock', 'desc')
                ->get();

            } else {
                # code...
             

                // $productoVenta = tb_lubricantes_stock_vent::DatosEstacion()->where("mes", intval($mes))
                // ->where("anio", $anio)->where("estacion", $request->estacion)->orderby('stock', 'desc')->get();

                $productoVenta = tb_lubricantes_stock_vent::selectRaw("mes,anio,SUBSTRING(DesProducto, 1, 6) as codigop,SUM(stock) as stock,SUM(facturado) as facturado,SUM(total) as total")
                    ->DatosEstacion()
                    ->where("estacion", $request->estacion)
                    ->where("mes", intval($mes))
                    ->where("anio", $anio)
                    ->groupBy('estacion','anio','mes', 'codigop')
                    ->orderby('stock', 'desc')
                    ->get();
            }

            $fecha = date('y-m-d');


            $nameExcel = 'Reporte Lubricacion Efectivo-' . $fecha . '.xls';
            //return  response()->json(['data' =>$resultado], 200);

            return Excel::download(
                new LubriVentasStockExport($productoVenta, 'Reporte General'),
                $nameExcel,
                header("Content-Type: application/vnd.ms-excel;")
            );





        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function createreporteExcelLubricantesStockEstacion(Request $request)
    {

        //return  response()->json(['data' =>$request->all()], 200);
        try {

            $fecha_actual = date($request->fecha);
            //sumo 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "+ 1 days"));
            //resto 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "- 1 days"));

            # code...
            $desde = date($request->desde);
            $hasta = date($request->hasta);
            $mes = date("m", strtotime($desde));
            $anio = date("Y", strtotime($desde));

            if ($request->estacion == 0) {
                # code...
               
                $productoVentaStock = tb_lubricantes_stock_esta::DatosEstacion()->get();


            } else {
                # code...
             
                $productoVentaStock = tb_lubricantes_stock_esta::DatosEstacion()->where("estacion", $request->estacion)->get();

            }

            $fecha = date('y-m-d');


            $nameExcel = 'Reporte Lubricacion Efectivo-' . $fecha . '.xls';
            //return  response()->json(['data' =>$resultado], 200);

            return Excel::download(
                new LubriVentasStockExport($productoVentaStock, 'Reporte General'),
                $nameExcel,
                header("Content-Type: application/vnd.ms-excel;")
            );





        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
}