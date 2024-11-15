import { prefix } from "../variables";
//import paciente from "../components/modulos/Administracion/paciente";
import dashboard from ".././components/modulos/dashboard";
import dashboardCope from ".././components/modulos/Administracion/DashboardCopemarket";
import DashAdministrador from ".././components/modulos/administrador";
import DashAddminOperoil from ".././components/modulos/adminLubricante";
import DashAdminCopemarket from ".././components/modulos/administradorContifico";
import DashAdministradoresinCopemarket from ".././components/modulos/administradoresContifico";

import Pantallas from ".././components/modulos/Administracion/Pantallas";
import dashboardCerecita from ".././components/modulos/dashboardCerecita";
import dashboardGasquil from ".././components/modulos/dashboardGasquil";
import dashboardAdmin from ".././components/modulos/dashboardAdmin";

import paciente from ".././components/modulos/Administracion/paciente";
import control_clinico from ".././components/modulos/Medico/index.vue";

import tipodesechos from ".././components/modulos/Parametrizacion/TiposDesechos/index.vue";
import Tareas from ".././components/modulos/Administracion/Tareas/Dashboardtareas.vue";
import TareasNormales from ".././components/modulos/Administracion/Tareas/DashboardtareasNormales.vue";
import DesechosDescripcion from ".././components/modulos/Parametrizacion/DesechosDescripcion/index.vue";
import ingresodesechos from ".././components/modulos/Administracion/Mantenimiento/index.vue";
import departamento from ".././components/modulos/Parametrizacion/TiposDesechos/index.vue";
import ingresoCombustible from ".././components/modulos/Administracion/combustible/ingresoCombustible";
import gastosestacion from ".././components/modulos/Administracion/gastos/gastosestacion";
import blindado from ".././components/modulos/Administracion/blindado/blindado";
import proveedores from ".././components/modulos/Parametrizacion/TiposDesechos/proveedores";



import Reportes from ".././components/modulos/Reporte/index.vue";
// calidad 
import index_calidad from "../components/modulos/calidad/index.vue";
import index_flota from "../components/modulos/calidad/calidad_flota/index.vue";
//transporte
import index_transporte from "../components/modulos/transporte/index.vue";
import upload from "../components/modulos/transporte/uploadfile.vue";
import complemento from "../components/modulos/transporte/complemento.vue";
///modulos/administracion/ingreso
//seguridad
import registrar from ".././components/modulos/Seguridad/Registro_usuario.vue";

let prefijo = prefix;
console.log(prefijo);

const home = [
    {
        path: prefix + "/blindado",
        name: "Ingreso de Blindad",
        component: blindado,
    },
       //producto
       {
        path: prefix + "/proveedores",
        name: "Ingreso de Producto",
        component: proveedores,
    },
    //DashAdminCopemarket
    {
        path: prefix + "/contifico",
        name: "Coppermarket",
        component: DashAdminCopemarket,
    },
    //DashAdministradoresinCopemarket
    {
        path: prefix + "/admincontifico",
        name: "Administradores Contifico",
        component: DashAdministradoresinCopemarket,
    },
    {
        path: prefix + "/gastosestacion",
        name: "Ingreso de Gastos",
        component: gastosestacion,
    },
    {
        path: prefix + "/administracion",
        name: "Ingreso Administrativo",
        component: gastosestacion,
    },
    {
        path: prefix + "/ingresocombustible",
        name: "Ingreso de Combustible",
        component: ingresoCombustible,
    },
    {
        path: prefix + "/admin",
        name: "Ingreso de Pacientes",
        component: dashboardAdmin,
    },
    {
        path: prefix + "/modulos/parametrizacion/tipodesechos",
        name: "Tipos de Desechos",
        component: tipodesechos,
    },
    {
        path: prefijo + "/modulos/parametrizacion/tareas",
        name: "Tareas",
        component: Tareas,
    },
    {
        path: prefijo + "/modulos/parametrizacion/desechosdescripcion",
        name: "Desechos por Descripcion",
        component: DesechosDescripcion,
    },
    {
        path: prefix + "/modulos/medico/005",
        name: "Control Clinico",
        component: control_clinico,
    },
    //ingresodesechos
    {
        path: prefix + "/modulos/administracion/ingreso",
        name: "Ingreso de Desechos",
        component: ingresodesechos,
    },
    //registrar
    {
        path: prefix + "/modulos/seguridad/registrar",
        name: "Creación de Usuario",
        component: registrar,
    },
    //Reportes
    {
        path: prefix + "/modulos/reporte/mostrar",
        name: "Reportes General",
        component: Reportes,
    },
    //copemarket
    {
        path: prefix + "/modulos/visor/copemarket",
        name: "Copemarket",
        component: dashboardCope,
    },

    //pantallas
    {
        path: prefix + "/modulos/visor/pantalla",
        // name: "Copemarket",
        component: Pantallas,
    },
    //pantallas
    {
        path: prefix + "/modulos/bi/dashboardCerecita",
        // name: "Copemarket",
        component: dashboardCerecita,
    },
    //dashboardGasquil
    {
        path: prefix + "/modulos/bi/dashboardGasquil/:id",
        name: "Item",
        component: dashboardGasquil,
    },
    {
        path: prefix + "/modulos/bi/administracion",
        // name: "Copemarket",
        component: DashAdministrador,
    },
    {
        path: prefix + "/modulos/bi/operoil",
        // name: "Copemarket",
        component: DashAddminOperoil,
    },
    //TareasNormales
    {
        path: prefix +"/modulos/parametrizacion/tareasNormales",
        // name: "Copemarket",
        component: TareasNormales,
    },
    //index_calidad
    {
        path: prefix +"/modulos/calidad",
        // name: "Copemarket",
        component: index_calidad,
    },
    //index_calidad
    {
        path: prefix +"/modulos/transporte",
        // name: "Copemarket",
        component: index_transporte,
    },
    {
        path: prefix +"/modulos/flota/transporte",
        // name: "Copemarket",
        component: index_flota,
    },
    {
        path: prefix + "/modulos/transporte/upload",
        // name: "Copemarket",
        component: upload,
    },
    {
        path: prefix + "/modulos/transporte/complemento",
        // name: "Copemarket",
        component: complemento,
    },
];

export default home;
