<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'modulos/admision', 'middleware' => ['auth:web'], 'verified'], function () {

    /* SubModulo Medico */
    Route::namespace('Modulos\Administracion')->prefix('paciente')->group(function () {
        //Modulo de tareas
        Route::get('GetEmpresa', 'TareasController@GetEmpresa');

        Route::get('cargar_persona/{apellidos}', 'PersonaController@ConsultarPersona');
        Route::post('createTarea', 'TareasController@createTarea');
        Route::post('createSeguimientoTarea', 'SeguimientoController@createSeguimientoTarea');
        Route::get('GetTareas', 'TareasController@GetTareas');
        Route::get('GetTareasNormales', 'TareasController@GetTareasNormales');
        Route::post('createTareaNormales', 'TareasController@createTareaNormales');

        //GetSeguimiento
        Route::get('GetSeguimiento/{id_tarea}', 'SeguimientoController@GetSeguimiento');
        //´rueba api
        Route::get('api', 'SeguimientoController@GetApi');
        Route::get('GetApiAcces', 'SeguimientoController@GetApiAcces');


        




        Route::get('cargar_paciente/{nombre}', 'PacienteController@ConsultarPaciente');

        //Modulo de genero
        Route::get('cargar_genero', 'PacienteController@consultargenero');

        Route::get('cargar_provincia', 'PacienteController@consultarProvincia');
        Route::get('cargar_ciudad/{idprovincia}', 'PacienteController@consultarciudad');

        // tipo desechos
        Route::get('cargarTipoDesechos', 'tipo_desechos@consultar');
        Route::post('crearTipoDesechos', 'tipo_desechos@create');
        //** */
        Route::get('cargarClasificacion', 'tipo_desechos@consultarClasificacion');
        Route::post('crearClasificacionDesechos', 'tipo_desechos@createClasificacionDesechos');
        //***/ */
        Route::get('cargarClasificacionDescripcion', 'tipo_desechos@consultarClasificacionDescripcion');
        Route::get('cargarClasificacionporTipo/{tipo}', 'tipo_desechos@consultarClasificacionPorTipo');
        Route::get('cargarClasificacionporTipoDescripcion/{tipo}/{clasificacion}', 'tipo_desechos@consultarClasificacionPorDescripcion');

        Route::post('createClasificacionDesechosDescripcion', 'tipo_desechos@createClasificacionDesechosDescripcion');

       // createClasificacionDesechosDescripcion
        
        //responsable
        Route::get('cargarResponsable', 'tipo_desechos@consultarResponsable');
        Route::get('cargarResponsable_de/{id}', 'tipo_desechos@consultarResponsableDepar');

        //departamento
        Route::get('cargarDepartamento', 'tipo_desechos@consultarDepartamento');
        Route::get('cargarDepartamentoid/{id}', 'tipo_desechos@consultarDepartamentoid');




        
        Route::post('createCInformacion', 'tipo_desechos@createInformacion');


        //usuario
        Route::get('cargarUsuario/{id}', 'tipo_desechos@Consultarusuario');
        Route::get('cargarInformacion', 'tipo_desechos@ConsultarInformacion');

        Route::get('IncipSession/{id}', 'Dashboard@IncipSession');
        Route::get('usuario', 'Dashboard@User');
        Route::get('usuarioActual', 'Dashboard@ConsultarUsuario');
        Route::get('GetMes/{estacion}/{mes}/{anio}', 'Dashboard@ConsultarMes');
        Route::get('GetDia/{estacion}', 'Dashboard@ConsultarDia');
        Route::get('GetEstacionPorDia/{fecha}', 'Dashboard@ConsultarDiaPorEstacion');
        Route::post('generacionExcelEstacion', 'Dashboard@createreporteExcel');
        Route::post('generacionExcelLubricantes', 'Dashboard@createreporteExcelLubricantes');
        Route::post('generacionExcelLubricantesConso', 'Dashboard@createreporteExcelLubricantesConsolidado');
        Route::post('generacionExcelLubricantesStockEstacion', 'Dashboard@createreporteExcelLubricantesStockEstacion');
        Route::post('generacionExcelLubricantesStockVentas', 'Dashboard@createreporteExcelLubricantesStockVentas');




        //dashboard
        Route::get('graficosPorDia', 'Dashboard@ConsultarInformacion');
        Route::get('ConsultaDatos', 'Dashboard@ConsultarDatos');
        Route::get('ConsultaEstaciones', 'Dashboard@ConsultarEstaciones');
        Route::get('ConsultaGastosEDS/{estacion}/{mes}/{anio}', 'Dashboard@ConsultarGastosEDS');
        Route::get('ConsultarVendedorPorEstacion/{mes}/{anio}', 'Dashboard@ConsultarVendedorPorEstacion');
        Route::get('ConsultarReporte/{estacion}/{fechainicio}/{fechafin}', 'Dashboard@ConsultarReporte');
        Route::post('ingresoCombustible', 'Dashboard@createCombustible');
        Route::get('ConsultaGuias', 'Dashboard@ConsultarCombustible');
        Route::get('ConsultarProveedor', 'Dashboard@ConsultarProveedor');
        Route::post('createProveedor', 'Dashboard@createProveedor');
        Route::post('createGastosEstacion', 'Dashboard@createGastosEstacion');
        Route::get('ConsultarGastosEstacion', 'Dashboard@ConsultarGastosEstacion');
        Route::get('ConsultarTiposGasto', 'Dashboard@ConsultarTiposGasto');
        Route::post('createBlindado', 'Dashboard@createBlindado');
        Route::get('ConsultarBlindado', 'Dashboard@ConsultarBlindado');
        Route::get('ConsultaGeneral/{mes}/{anio}/{estacion}/', 'Dashboard@ConsultarVendedorPorEstacionFuelCorp');
        Route::get('ConsultaGeneralFuelcorp/{estacion}/{fechainicio}/{fechafin}', 'Dashboard@ConsultarReporteFuelcorp');

        //reporte

        Route::get('generacionExcel', 'tipo_desechos@generacionExcel');

        Route::get('generacionPdf', 'tipo_desechos@generacionPDF');

        Route::post('generacionDocumento', 'tipo_desechos@createreporte');
        Route::post('generacionDocumentoExcel', 'tipo_desechos@createreporteExcel');


        //contifico
        Route::get('GetConsultarBodegas', 'Dashboard@GetBodegasContifico');
        Route::post('GetDocumentoCompra', 'Dashboard@GetDocumentoCompraFecha');
        Route::post('GetDocumentoTodoLocales', 'Dashboard@GetDocumentoTodoLocales');
        Route::post('GetDocumentoCompraAdmin', 'Dashboard@GetDocumentoAdmninVentasFecha');
        Route::post('GetDocumentoArqueo', 'Dashboard@GetDocumentoArqueoFecha');
        Route::post('GrabarArqueo', 'Dashboard@createCuadreCaja');






       
    });
   });