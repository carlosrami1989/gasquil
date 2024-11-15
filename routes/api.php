<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
 

Route::post('insert_mes', [DataController::class, 'store_mes']);
Route::post('insert_dia', [DataController::class, 'store_dia']);
Route::post('insert_gastos', [DataController::class, 'store_gastos']);
Route::get('Consulta_mes', [DataController::class, 'index']);
Route::post('insert_lubricantes', [DataController::class, 'store_lubricantes']);
Route::post('insert_lubricantes_stock_estacion', [DataController::class, 'store_lubricantes_estacion']);
Route::post('insert_lubricantes_stock', [DataController::class, 'store_lubricantes_stock']);
//*contifico **//

Route::get('generar_datos_totales', [DataController::class, 'store_data_totales_locales']);




