<?php

namespace App\Http\Controllers\Modulos\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modulos\Administracion\Tareas;
use App\Models\Modulos\Administracion\TareasAdicional;
use App\Models\Modulos\Administracion\Persona;
use App\Models\Modulos\Administracion\Empresa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TareasController extends Controller
{
    public function GetEmpresa(){
        try {
            $listasEmpresas = Empresa::All();

       
       
           
            return  response()->json(['listasEmpresas' =>$listasEmpresas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    //
    public function GetTareas(){
        try {
            //1. Activo
            //2. Terminada
            //
            $listasTareas = Tareas::select(
                'id',
                'descripcion',
                'observacion',
                'estado_tarea',
                'estado',
                'fecha_inicio',
                'fecha_fin',
                'usuario_ingreso',
                )
                ->datosPersona() 
                ->withCount('Totales')      
                ->where('estado_tarea',1)      
                ->get();

        foreach ($listasTareas as  $key => $item) {
            # code...
            $Fechaini =  Carbon::parse($item->fecha_inicio);
            $Fechafin = Carbon::parse($item->fecha_fin);
    
            $fechaActual = Carbon::now();
            $diff = $fechaActual->diffInDays($Fechaini);

            $fecha_diferencia = $Fechafin->diffInDays($Fechaini);
            $porcentaje = ($diff / $fecha_diferencia)  *100 ;
            $listasTareas[$key]['porcentaje'] =  round($porcentaje,2);
            

        }
       
           
            return  response()->json(['listasTareas' =>$listasTareas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    //
    public function createTarea(Request $request){
         
        try {
            //code.
            $user = Auth::user();
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
            $crear = Tareas::UpdateOrCreate([
                'id'=>$request->tarea["id"],
            ],
            [   
                'id_empresa'=> $request->tarea["id_empresa"], 
                'descripcion'=> $request->tarea["descripcion"], 
                'observacion'=>$request->tarea["observacion"], 
                'usuario_ingreso'=> $user->id, 
                'usuario_modificacion'=>$user->id, 
                'id_persona'=> $request->tarea["id_persona"], 
                'estado_tarea'=> $request->tarea["estado_tarea"], 
                'estado'=> $request->tarea["estado"], 
                'fecha_inicio'=> $request->tarea["fecha_ini"], 
                'fecha_fin'=>   $request->tarea["fecha_fin"], 
                  
                
    
            ]
    
            );
    
            $wasCreated = $crear->wasRecentlyCreated; 
            

            foreach ( $request->adicional as $item ) {
                # code...
              $crearAdicional = TareasAdicional::UpdateOrCreate([
                    'id'=>0,
                ],
                [   
                    'id_tareas'=> $crear->id, 
                    'id_persona'=>$item["id"], 
                   
                ]);
            }

             
    
            return  response()->json(['data' =>$crearAdicional], 200);
        } catch (Exception $e) {
            return  response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
}
