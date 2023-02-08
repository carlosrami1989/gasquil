<?php

namespace App\Http\Controllers\Modulos\Administracion;
use App\Models\Modulos\Administracion\Seguimiento;
use App\Models\Modulos\Administracion\Tareas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;

    

class SeguimientoController extends Controller
{
    public function GetSeguimiento($id_tareas){
        try {
            $listasSeguimiento = Seguimiento::select(
                'id_tareas',
                'titulo',
                'observacion',
                'ruta_imagen',
                'fecha_seguimiento',
                'usuario_ingreso',
                )
                ->datosSeguimiento()
                ->where('id_tareas',$id_tareas)
                ->OrderBy('fecha_seguimiento', 'desc')
                ->get();

       
           
            return  response()->json(['listasSeguimiento' =>$listasSeguimiento], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    //

    //
    public function createSeguimientoTarea(Request $request){
         
        try {
            //code.
            $user = Auth::user();
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
            $crear = Seguimiento::UpdateOrCreate([
                'id'=>$request->id,
            ],
            [   
                'id_tareas'=> $request->id_tareas, 
                'titulo'=> $request->titulo, 
                'observacion'=>$request->observacion, 
                'ruta_imagen'=>$request->ruta_imagen, 
                'usuario_ingreso'=> $user->id, 
                'usuario_modificacion'=>$user->id, 
            ]
    
            );
            $fechaActual = Carbon::now();
            if ( $request->chk_finalizar) {
                # code...
                $crear = Tareas::UpdateOrCreate([
                    'id'=>$request->id_tareas,
                ],
                [   
                    
                    'estado_tarea'=>2, 
                    'usuario_modificacion'=>$user->id, 
                    'updated_at'=>$fechaActual, 
                ]
        
                );
            }
    
            $wasCreated = $crear->wasRecentlyCreated; 
            
 
             
    
            return  response()->json(['data' =>$wasCreated], 200);
        } catch (Exception $e) {
            return  response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
}
