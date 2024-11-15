<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Modulos\Parametrizacion\tb_consulta_dia;
use App\Models\Modulos\Parametrizacion\tb_consulta_mes;
use App\Models\Modulos\Parametrizacion\tb_gastos;
use App\Models\Modulos\Parametrizacion\tb_complementos_bi;
use App\Models\Modulos\Parametrizacion\tb_lubricantes;
use App\Models\Modulos\Parametrizacion\tb_lubricantes_stock_esta;
use App\Models\Modulos\Parametrizacion\tb_lubricantes_stock_vent;
use App\Models\Modulos\Parametrizacion\tb_resumen_dolares;
use App\Models\Modulos\Parametrizacion\tb_resumen_galones;
use App\Models\Modulos\Parametrizacion\tb_locales;
use App\Http\Controllers\Modulos\Administracion\Dashboard;
use Exception;

use Carbon\Carbon;


use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(['data' => "holaa"], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_data_totales_locales()
    {
        try {
            //datos para la variable
            $fechaActual = Carbon::now();
            $estacion = 0;
            $mes = 0;
            $anio = 0;
            $dia = 0;
            //$estacion = $request[0]["estacion"];
            $mes = $fechaActual->month;
            $anio = $fechaActual->year;
            $dia = $fechaActual->day;


             $ListaLocales = tb_locales::where("estado",1)->get();

             for ($i=1; $i < 14 ; $i++) { 
                # code...
             }


             foreach ($ListaLocales as $key => $value) {
                # code...
             }

            $url = "https://api.contifico.com/sistema/api/v1/bodega/";
 
            $response = $this->makeRequest('GET', $url);

            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
          
            return response()->json([
                'consulta' => $ListaLocales,
                // 'fecha_reporte_galones' => $fecha_reporte_galones,
                // 'fecha_reporte_galones_calibracion' => $fecha_reporte_galones_calibracion,
                // 'Vendedor' => $vendedor,

            ], 200);


            //code...
        } catch (Exception $e) {
            return response()->json(['consulta' => $e->getMessage()], 500);
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

    public function store_data_resumen_galones(Request $request)
    {


        $fechaActual = Carbon::now();
        $estacion = 0;
        $mes = 0;
        $anio = 0;



        $estacion = $request[0]["estacion"];
        $mes = $fechaActual->month;
        $anio = $fechaActual->year;



        tb_resumen_galones::where('estacion', $estacion)
            //  ->where('mes', $mes)
            ->where('anio', $anio)
            ->delete();


        // return response()->json([
        //     'data' => $request->all(),
        //     'datallego' => ""
        // ], 200);


        try {


            $prueba = "llego";


            foreach ($request->all() as $item) {



                tb_resumen_galones::create([
                    'id' => 0,
                    'estacion' => $item["estacion"],
                    'tipo' => $item["tipo"],
                    'anio' => $item["anio"],
                    'mes' => $item["mes"],
                    'dia' => $item["dia"],
                    'fecha' => $item["fecha"],
                    'EXTRA_CON_ETANOL' => $item["EXTRA_CON_ETANOL"],
                    'DIESEL' => $item["DIESEL"],
                    'SUPER_PREMIUM_95' => $item["SUPER_PREMIUM_95"],
                    'TOTAL' => $item["TOTAL"],
                    'created_at' => $fechaActual,
                    'updated_at' => $fechaActual,

                ]);




            }

            return response()->json([
                'data' => $prueba,
                'datallego' => ""
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
        }
    }

    public function store_data_resumen_dolares(Request $request)
    {


        $fechaActual = Carbon::now();
        $estacion = 0;
        $mes = 0;
        $anio = 0;



        $estacion = $request[0]["estacion"];
        $mes = $fechaActual->month;
        $anio = $fechaActual->year;



        tb_resumen_dolares::where('estacion', $estacion)
            // ->where('mes', $mes)
            ->where('anio', $anio)
            ->delete();


        // return response()->json([
        //     'data' => $request->all(),
        //     'datallego' => ""
        // ], 200);


        try {


            $prueba = "llego";


            foreach ($request->all() as $item) {



                tb_resumen_dolares::create([
                    'id' => 0,
                    'estacion' => $item["estacion"],
                    'anio' => $item["anio"],
                    'mes' => $item["mes"],
                    'dia' => $item["dia"],
                    'fecha' => $item["fecha"],
                    'EFECTIVO' => $item["EFECTIVO"],
                    'MEDIO_DIGITAL' => $item["MEDIO_DIGITAL"],
                    'CHEQUE' => $item["CHEQUE"],
                    'TRANSFERENCIA' => $item["TRANSFERENCIA"],
                    'CREDITO' => $item["CREDITO"],
                    'CALIBRACIONES' => $item["CALIBRACIONES"],
                    'TOTAL' => $item["TOTAL"],
                    'created_at' => $fechaActual,
                    'updated_at' => $fechaActual,

                ]);




            }

            return response()->json([
                'data' => $prueba,
                'datallego' => ""
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
        }
    }


    public function store_lubricantes_estacion(Request $request)
    {

        $fechaActual = Carbon::now();
        $estacion = 0;
        $estacion = $request[0][0]["estacion"];

        tb_lubricantes_stock_esta::where('estacion', $estacion)->delete();

        try {


            $prueba = "llego";

            foreach ($request->all() as $item) {
                foreach ($item as $item2) {

                    tb_lubricantes_stock_esta::create(

                        [

                            'id' => 0,
                            'estacion' => $item2["estacion"] == null ? 0 : $item2["estacion"],
                            'idProducto' => $item2["idProducto"],
                            'Descripcion' => $item2["Descripcion"],
                            'idEstado' => $item2["idEstado"],
                            'Cantidad' => $item2["Cantidad"],



                        ]

                    );
                }
            }
            return response()->json([
                'data' => $prueba,
                'datallego' => ""
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store_lubricantes_stock(Request $request)
    {

        $fechaActual = Carbon::now();
        try {
            $estacion = 0;
            $estacion = $request[0][0]["estacion"];

            tb_lubricantes_stock_vent::where('estacion', $estacion)->delete();

            $prueba = "llego";

            foreach ($request->all() as $item) {
                foreach ($item as $item2) {

                    tb_lubricantes_stock_vent::create(

                        [

                            'id' => 0,
                            'estacion' => $item2["estacion"] == null ? 0 : $item2["estacion"],
                            'mes' => $item2["mes"] == null ? 0 : $item2["mes"],
                            'anio' => $item2["anio"] == null ? 0 : $item2["anio"],
                            'idProducto' => $item2["idProducto"],
                            'proTOdos' => $item2["proTOdos"],
                            'Descripcion' => $item2["Descripcion"],
                            'DesProducto' => $item2["DesProducto"],
                            'estado' => $item2["estado"],
                            'stock' => $item2["stock"],
                            'facturado' => $item2["facturado"],
                            'total' => $item2["total"],
                            'created_at' => $fechaActual,
                            'updated_at' => $fechaActual

                        ]

                    );
                }
            }
            return response()->json([
                'data' => $prueba,
                'datallego' => ""
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store_lubricantes(Request $request)
    {

        $fechaActual = Carbon::now();
        try {


            $prueba = "llego";
            //   foreach ($request->all() as $item) {
            //     foreach ($item as $item2) {
            //         $prueba = $item2;
            //     }

            //  }
            // return response()->json([
            //     'data' => $prueba,
            //     'datallego' => ""
            // ], 200);
            $estacion = 0;
            $estacion = $request[0][0]["estacion"];

            tb_lubricantes::where('estacion', $estacion)->delete();

            foreach ($request->all() as $item) {
                foreach ($item as $item2) {

                    tb_lubricantes::create(

                        [

                            'id' => 0,
                            'estacion' => $item2["estacion"] == null ? 0 : $item2["estacion"],
                            'mes' => $item2["mes"] == null ? 0 : $item2["mes"],
                            'anio' => $item2["anio"] == null ? 0 : $item2["anio"],
                            'idFactura' => $item2["idFactura"],
                            'RucEmpresa' => $item2["RucEmpresa"],
                            'Nombre' => $item2["Nombre"],
                            'email' => $item2["email"] == null ? 0 : $item2["email"],
                            'MontoDolares' => $item2["MontoDolares"] == null ? 0 : $item2["MontoDolares"],
                            'numerofactura' => $item2["numerofactura"] == null ? 0 : $item2["numerofactura"],
                            'Fecha' => $item2["Fecha"] == null ? 0 : $item2["Fecha"],
                            'idVendedor' => $item2["idVendedor"] == null ? 0 : $item2["idVendedor"],
                            'Vendedor' => $item2["Vendedor"] == null ? 0 : $item2["Vendedor"],
                            'Placa' => $item2["Placa"] == null ? 0 : $item2["Placa"],
                            'Impresora' => $item2["Impresora"] == null ? 0 : $item2["Impresora"],
                            'idProducto' => $item2["idProducto"] == null ? 0 : $item2["idProducto"],
                            'DesProducto' => $item2["DesProducto"] == null ? 0 : $item2["DesProducto"],
                            'Cantidad' => $item2["Cantidad"] == null ? 0 : $item2["Cantidad"],
                            'Precio' => $item2["Precio"] == null ? 0 : $item2["Precio"],
                            'MontoDolaresDes' => $item2["MontoDolaresDes"] == null ? 0 : $item2["MontoDolaresDes"],


                        ]

                    );
                }
            }
            return response()->json([
                'data' => $prueba,
                'datallego' => ""
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store_complemento(Request $request)
    {


        try {
            $estacion = 0;
            foreach ($request->all() as $item) {
                foreach ($item as $item2) {
                    $estacion == $item2["estacion"];

                }
            }



            tb_complementos_bi::query()->where('estacion', $estacion)->tedele();
            //    $delete->truncate();

            foreach ($request->all() as $item) {
                foreach ($item as $item2) {
                    tb_complementos_bi::create(

                        [
                            'id' => 0,
                            'mes' => $item2["mes"],
                            'descripcion' => $item2["descripcion"],
                            'galones' => $item2["galones"],
                            'total' => $item2["total"],
                            'estacion' => $item2["estacion"],
                        ]

                    );
                }
            }
            return response()->json([
                'data' => "llego",
                'datallego' => "ok"
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store_mes(Request $request)
    {


        try {
            $estacion = 0;
            // foreach ($request->all() as $item) {
            //     foreach ($item as $item2) {
            //         $estacion == $item2["estacion"];

            //     }
            // }
            $estacion = $request[0][0]["estacion"];







            tb_consulta_mes::where('estacion', $estacion)->delete();
            //    $delete->truncate();

            foreach ($request->all() as $item) {
                foreach ($item as $item2) {
                    tb_consulta_mes::create(

                        [
                            'id' => 0,
                            'mes' => $item2["mes"],
                            'anio' => $item2["anio"],
                            'descripcion' => $item2["descripcion"],
                            'galones' => $item2["galones"],
                            'total' => $item2["total"],
                            'estacion' => $item2["estacion"],
                        ]

                    );
                }
            }
            return response()->json([
                'data' => "llego",
                'datallego' => "ok"
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store_dia(Request $request)
    {


        try {

            $estacion = 0;
            // foreach ($request->all() as $item) {
            //     foreach ($item as $item2) {
            //         $estacion == $item2["estacion"];

            //     }
            // }


            $estacion = $request[0][0]["estacion"];




            tb_consulta_dia::where('estacion', $estacion)->delete();


            //    $delete->truncate();
            // return response()->json([
            //     'data' => "llego",
            //     'datallego' => $lista
            // ], 200);

            foreach ($request->all() as $item) {
                foreach ($item as $item2) {
                    tb_consulta_dia::create(

                        [
                            'id' => 0,
                            'dia' => $item2["dia"],
                            'mes' => $item2["mes"],
                            'anio' => $item2["anio"],
                            'descripcion' => $item2["descripcion"],
                            'galones' => $item2["galones"],
                            'total' => $item2["total"],
                            'estacion' => $item2["estacion"],

                        ]

                    );
                }
            }
            return response()->json([
                'data' => "llego",
                'datallego' => "ok"
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store_gastos(Request $request)
    {

        try {



            $Lista = [];

            $Lista = $request->all();
            // return response()->json([
            //     'data' => "llego",
            //     'datallego' => date("m")
            // ], 200);
            $mes = (int) date("m");

            //    $delete->truncate();
            tb_gastos::query()->where('mes', $mes)->delete();

            foreach ($Lista as $item2) {

                tb_gastos::create(

                    [
                        'id' => 0,
                        'mes' => $item2["mes"],
                        'anio' => $item2["anio"],
                        // 'cia_nombre' => $item2["cia_nombre"],
                        'id_estacion_obrero' => $item2["id"],
                        'id_estacion' => $item2["id_web"],
                        'estacion' => $item2["nombre"],
                        'pc_codcta' => $item2["pc_codcta"],
                        'pc_nomcta' => $item2["pc_nomcta"],
                        'cc_concepto' => $item2["cc_concepto"],
                        'cc_fecha' => $item2["cc_fecha"],
                        // 'cc_persona' => $item2["cc_persona"],
                        'cc_fechagra' => $item2["cc_fecgra"],
                        'dc_glosa' => $item2["dc_glosa"],
                        'dc_valdeb' => $item2["dc_valdeb"],
                        'dc_valhab' => $item2["dc_valhab"],

                    ]

                );

            }
            return response()->json([
                'data' => "llego",
                'datallego' => "ok"
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}