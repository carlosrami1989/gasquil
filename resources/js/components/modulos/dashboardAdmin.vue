<template>
    <div>
      <v-row no-gutters>
        <v-col cols="12" sm="2" class="align-center">
          <br />
          <v-img src="/img/logo.png"> </v-img>
        </v-col>
        <v-col cols="12" sm="2" class="pa-1">
          <v-card outlined tile elevation="8" class="rounded-lg">
            <v-system-bar color="indigo darken-2" dark class="white--text"
              >Estacion</v-system-bar
            >
            <v-card-text>
              <v-select
                :items="ListEstaciones"
                v-model="ItemEstacion"
                item-text="nombre"
                item-value="id"
                persistent-hint
                single-line
                label="Estaciones"
              ></v-select>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" sm="2" class="pa-1">
          <v-card outlined tile elevation="8" class="rounded-lg">
            <v-system-bar color="indigo darken-2" dark class="white--text"
              >AÑO</v-system-bar
            >
            <v-card-text>
              <v-chip-group active-class="success" column>
                <v-chip
                  v-for="tag in Listanio"
                  :key="tag"
                  @click="Consultaanio(tag)"
                >
                  {{ tag }}
                </v-chip>
              </v-chip-group>
            </v-card-text>
          </v-card>
        </v-col>
  
        <v-col cols="12" sm="6" class="pa-1">
          <v-card outlined tile elevation="8" class="rounded-lg">
            <v-system-bar color="indigo darken-2" dark class="white--text"
              >mes</v-system-bar
            >
            <v-card-text>
              <v-chip-group active-class="success" column>
                <v-chip
                  v-for="tag in Listames"
                  :key="tag.id"
                  @click="ConsultaMes(tag.id)"
                >
                  {{ tag.mes }}
                </v-chip>
              </v-chip-group>
            </v-card-text>
          </v-card>
        </v-col>
        <!-- <v-col cols="12" sm="10" class="pa-1">
                  <v-card outlined tile elevation="8" class="rounded-lg">
                      <v-system-bar color="indigo darken-2" dark class="white--text">Estaciones de Servicios</v-system-bar>
  
                      <v-chip-group active-class="success" column>
                          <v-chip v-for="tag in ListEstaciones" :key="tag.id" @click="ConsultaEstacionItem(tag.id)"> <v-icon
                                  right :color="tag.color">
                                  {{ tag.icon }}
                              </v-icon> &nbsp;
                              {{ tag.nombre }}
                          </v-chip>
                      </v-chip-group>
                  </v-card>
  
              </v-col> -->
      </v-row>
      <v-row no-gutters>
             <v-col   class="pa-1">
                <v-card
                    :loader-height="5"
                    :loading=loading
                    outlined
                    tile
                    elevation="8"
                    class="rounded-lg"
                >
                <v-system-bar
                        color="indigo darken-2"
                        dark
                        class="white--text"
                        >Total del día por montos</v-system-bar
                    >
                    <canvas
                        id="ventasPorFechaAperturaMonto"
                        height="143px"
                        width="auto"
                    ></canvas>
                    <div style="width: auto; text-align: center"></div>
                </v-card>
            </v-col> 
            <v-col     class="pa-1">
                <v-card
                    :loader-height="5"
                    :loading=loading
                    outlined
                    tile
                    elevation="8"
                    class="rounded-lg"
                >
                   
                </v-card>
                <v-card  
                    outlined
                    tile
                    elevation="8"
                    :loader-height="5"
                    :loading=loading
                    class="rounded-lg"
                >
                    <v-system-bar
                        color="indigo darken-2"
                        dark
                        class="white--text"
                    >
                        Total Por días en Galones</v-system-bar
                    >
                    <canvas
                        id="ventasPorFechaApertura"
                        height="145px"
                        width="auto"
                    ></canvas>
                </v-card>
            </v-col>
        </v-row>
  
   <!-- MEDIOS DE PAGOS RESUMEN -->
  
   <v-row no-gutters>
        <v-col cols="12" sm="12" class="pa-1">
          <v-card
            outlined
            tile
            elevation="8"
            :loader-height="5"
            :loading="loading"
            class="rounded-lg"
          >
            <v-system-bar color="indigo darken-2" dark class="white--text">
             Detalle Forma de Pago</v-system-bar
            >
            <canvas id="formaPagosChart" height="120px" width="auto"></canvas>
          </v-card>
        </v-col>
      </v-row>
  
  
       <!-- FORMULARIO DE REPORTE -->
      
       <v-row no-gutters>
        <v-col cols="12" sm="12" class="pa-1">
          <v-card
            :loader-height="5"
            :loading="loading"
            outlined
            tile
            elevation="8"
            class="rounded-lg"
          >
            <v-system-bar color="indigo darken-2" dark class="white--text"
              >Consolidado Stock/Ventas por estaciones</v-system-bar
            >
            <v-card-title>
              <v-card-text>
                <v-select
                    :items="ListEstaciones"
                    v-model="ItemEstacion"
                    item-text="nombre"
                    item-value="id"
                    persistent-hint
                    single-line
                    label="Estacioness"
                  ></v-select>
                <label>Seleccione Fecha inicio :</label>
                <input
                  type="date"
                  v-model="fecha_buscar"
                  
                />
                <label>Seleccione Fecha fin :</label>
                <input
                  type="date"
                  v-model="fecha_buscar_hasta"
                
                />
                <v-btn color="success" @click="consultasEstacionesPorFecha()">Generar Reporte</v-btn>
                <v-card-text>
  
                  <v-divider></v-divider>
                  <br>
                  <h1>Datos Por Tipos de ventas</h1>
                  <v-text-field
                  v-model="searchVentasStockEstaciones"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  show-select
                ></v-text-field>
                <v-data-table
                  :headers="CabeceraVentasStockEstaciones"
                  :items="ListaVentasStockEstaciones"
                  :search="searchVentasStockEstaciones"
                  :items-per-page="30"
                >
                <template v-slot:[`item.stock`]="{ item }">
                  <v-chip
                      
                       color="success"
                        dark
                      >
                        {{ item.stock }}
                      </v-chip>         
                                
                                  
                                 
                              </template>
                </v-data-table>
                </v-card-text>
                <v-divider></v-divider>
                <br>
                <h1>Datos por Galones</h1>
                <v-card-text>
                  <v-text-field
                  v-model="searchVentasGalones"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  show-select
                ></v-text-field>
                <v-data-table
                  :headers="CabeceraVentasGalones"
                  :items="ListaVentasGalones"
                  :search="searchVentasGalones"
                  :items-per-page="30"
                >
                <template v-slot:[`item.stock`]="{ item }">
                  <v-chip
                      
                       color="success"
                        dark
                      >
                        {{ item.stock }}
                      </v-chip>         
                                
                                  
                                 
                              </template>
                </v-data-table>
                </v-card-text>
  
                <v-divider></v-divider>
                <br>
                <h1>Datos por Calibración</h1>
                <v-card-text>
                  <v-text-field
                  v-model="searchVentasGalonesCalibracion"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  show-select
                ></v-text-field>
                <v-data-table
                  :headers="CabeceraVentasGalonesCalibracion"
                  :items="ListaVentasGalonesCalibracion"
                  :search="searchVentasGalonesCalibracion"
                  :items-per-page="30"
                >
                <template v-slot:[`item.stock`]="{ item }">
                  <v-chip
                      
                       color="success"
                        dark
                      >
                        {{ item.stock }}
                      </v-chip>         
                                
                                  
                                 
                              </template>
                </v-data-table>
                </v-card-text>
  
                <v-card-text>
  
  <v-divider></v-divider>
  <br>
  <h1>GASTOS POR ESTACION</h1>
  <v-text-field
  v-model="searchVentasStockEstaciones"
  append-icon="mdi-magnify"
  label="Search"
  single-line
  show-select
  ></v-text-field>
  <v-data-table
  :headers="CabeceraGastosEstaciones"
  :items="ListaGastosEstaciones"
  :search="searchGastosEstaciones"
  :items-per-page="30"
  >
  <template v-slot:[`item.stock`]="{ item }">
  <v-chip
      
       color="success"
        dark
      >
        {{ item.stock }}
      </v-chip>         
                
                  
                 
              </template>
  </v-data-table>
  </v-card-text>
                <v-row dense xl="4" md="2">
                  <v-col>
                    <v-tooltip right>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          color="green"
                          dark
                          v-bind="attrs"
                          v-on="on"
                          @click="GenerarDocumentoExcelStockVentas()"
                        >
                          <v-icon>mdi-file-excel-box</v-icon>
                        </v-btn>
                      </template>
                      <span>Generar Excel</span>
                    </v-tooltip>
                  </v-col>
                </v-row>
                <br />
                <v-divider></v-divider>
  
                <canvas
                  id="EstacionesPorDia"
                  height="120px"
                  width="auto"
                ></canvas>
              </v-card-text>
            </v-card-title>
  
            <div style="width: auto; text-align: center"></div>
          </v-card>
        </v-col>
      </v-row>
  
      <!-- FIN -->
  
      
  
      <!-- aqui va otro grupo -->
  
     
      <!-- <v-row>
              
              
              <v-col cols="12" sm="2" md="2" class="py-1"
              v-for="item in ListaManguera" :key="item.cod_manguera">
                  <v-card class="pa-2" outlined tile>
                      <router-link :to="ruta"> 
                      <v-img
                           
                          :src="item.src"
                         
                      ></v-img>
                  </router-link>        
                       
                          <v-card-text>
                              <v-icon large color="green">mdi-fuel </v-icon> {{ item.des_manguera }}
                          </v-card-text>
                           
                  </v-card>
              </v-col>
               
   
          </v-row> -->
      <v-divider></v-divider>
      <br />
      <v-row> </v-row>
      <br />
      <v-divider></v-divider>
      <v-row> </v-row>
      <br />
      <br />
    </div>
  </template>
  <script>
  import { prefix, url } from "../../variables";
  import { funcionesGlobales } from "../../funciones";
  export default {
    props: {
      user: {
        type: Object,
      },
    },
    data() {
      return {
        anioItem: "",
        mesItem: "",
        diaItem: "",
        diaActual: "",
        justify: ["start", "center", "end", "space-around", "space-between"],
        Listanio: ["2022", "2023", "2024"],
        Listames: [
          { id: 1, mes: "Enero" },
          { id: 2, mes: "Febrero" },
          { id: 3, mes: "Marzo" },
          { id: 4, mes: "Abril" },
          { id: 5, mes: "Mayo" },
          { id: 6, mes: "Junio" },
          { id: 7, mes: "Julio" },
          { id: 8, mes: "Agosto" },
          { id: 9, mes: "Septiembre" },
          { id: 10, mes: "Octubre" },
          { id: 11, mes: "Noviembre" },
          { id: 12, mes: "Diciembre" },
        ],
        loadingTag: {
          loading1: true,
          loading2: true,
          loading3: true,
          loading4: true,
          loading5: true,
        },
        loadingCar: {
          loading1: true,
          loading2: true,
          loading3: true,
          loading4: true,
        },
        ListEstaciones: [],
        ItemEstacion: 0,
        ruta: "",
        ListaManguera: [
          {
            cod_manguera: 1,
            des_manguera: "diesel",
            src: "/img/diesel.png",
          },
          {
            cod_manguera: 2,
            des_manguera: "super",
            src: "/img/super.png",
          },
          { cod_manguera: 3, des_manguera: "eco", src: "/img/eco.png" },
          {
            cod_manguera: 4,
            des_manguera: "eco Plus",
            src: "/img/ecoplus.png",
          },
          {
            cod_manguera: 2,
            des_manguera: "super",
            src: "/img/super.png",
          },
          { cod_manguera: 5, des_manguera: "eco", src: "/img/eco.png" },
          { cod_manguera: 6, des_manguera: "eco", src: "/img/eco.png" },
          {
            cod_manguera: 4,
            des_manguera: "eco Plus",
            src: "/img/ecoplus.png",
          },
        ],
  
        //dolares
        ProductoMes: [],
        GalonesTotalMes: [],
        MontoTotalMes: [],
        //fin
   
        //fin
  
        //fin
  
        //ventasdiariasFechaAperturaMes
        
        //fin
        indice: [],
        valores: [],
  
        DescripcionTotalMes: [],
  
        chartGalonesMes: null,
        loading: true,
        sliderTimer: null,
        IdEstacionWeb: 0,
        NombreEstacion: "",
  
        //wingles
        ListInformacion: {
          extratotal: 0,
          dieseltotal: 0,
          supertotal: 0,
          extragalones: 0,
          dieselgalones: 0,
          supergalones: 0,
        },
  
        //forma Pago
          //dolares
          fecha_buscar: new Date().toISOString().slice(0, 10),
        fecha_buscar_hasta: new Date().toISOString().slice(0, 10),
     
        ListFormaPago: [],
        GalonesTotalMesFormaPago: [],
        MontoTotalMesFormaPago: [],
        chartGalonesMesFormaPago: null,
  
        searchVentasStockEstaciones:"",
        CabeceraVentasStockEstaciones:[
        {
            text: "Fecha",
            align: "start",
  
            value: "fecha",
            class: "yellow lighten-1",
          },
          { text: "EFECTIVO", value: "EFECTIVO", class: "orange lighten-1 borderWidth:8" },
          { text: "MEDIO DIGITAL", value: "MEDIO_DIGITAL", class: "orange lighten-1" },
          { text: "CHEQUE", value: "CHEQUE", class: "orange lighten-1" },
          { text: "TRANSFERENCIA", value: "TRANSFERENCIA", class: "orange lighten-1" },
          { text: "CREDITO", value: "CREDITO", class: "orange lighten-1" },
          { text: "CALIBRACIONES", value: "CALIBRACIONES", class: "orange lighten-1" },
          { text: "TOTAL", value: "TOTAL", class: "yellow lighten-1" },
  
        ],
        
        ListaVentasStockEstaciones:[],
        searchVentasGalones:"",
        CabeceraVentasGalones:[
        {
            text: "Fecha",
            align: "start",
  
            value: "fecha",
            class: "yellow lighten-1",
          },
          { text: "EXTRA_CON_ETANOL", value: "EXTRA_CON_ETANOL", class: "orange lighten-1 borderWidth:8" },
          { text: "SUPER_PREMIUM_95", value: "SUPER_PREMIUM_95", class: "orange lighten-1" },
          { text: "DIESEL", value: "DIESEL", class: "orange lighten-1" },
        
               { text: "TOTAL", value: "TOTAL", class: "yellow lighten-1" },
  
        ],
        ListaVentasGalones:[],
  
        searchVentasGalonesCalibracion:"",
        CabeceraVentasGalonesCalibracion:[
        {
            text: "Fecha",
            align: "start",
  
            value: "fecha",
            class: "yellow lighten-1",
          },
          { text: "EXTRA_CON_ETANOL", value: "EXTRA_CON_ETANOL", class: "orange lighten-1 borderWidth:8" },
        
          { text: "SUPER_PREMIUM_95", value: "SUPER_PREMIUM_95", class: "orange lighten-1" },
          { text: "DIESEL", value: "DIESEL", class: "orange lighten-1" },
               { text: "TOTAL", value: "TOTAL", class: "yellow lighten-1" },
  
        ],
        ListaVentasGalonesCalibracion:[],
        searchGastosEstaciones:"",
  
        CabeceraGastosEstaciones:[
        {
            text: "Fecha",
            align: "start",
  
            value: "fecha_emision",
            class: "yellow lighten-1",
          },
          { text: "GASTO_ADICIONALES", value: "GASTO_ADICIONALES", class: "orange lighten-1 borderWidth:8" },
          { text: "GASTOS_ADMINISTRATIVOO", value: "GASTOS_ADMINISTRATIVO", class: "orange lighten-1" },
          { text: "GENERADOR", value: "GENERADOR", class: "orange lighten-1" },
          { text: "FALTANTE_ARQUEO_CAJA", value: "FALTANTE_ARQUEO_CAJA", class: "orange lighten-1" },
          { text: "GASTOS_OPERATIVO", value: "GASTOS_OPERATIVO", class: "orange lighten-1" },
          { text: "TOTAL_GASTOS", value: "TOTAL_GASTOS", class: "yellow lighten-1" },
  
        ],
        
        ListaGastosEstaciones:[],
  
      };
  
      
    },
    mounted() {
      this.consultasEstaciones();
      //this.GenerarToken();
    },
    methods: {
        GenerarVentasDiariasFecha() {
            // let url =
            //     this.$store.state.ApiGasquil +
            //     "Dashboard/GetVentasDiariosFechaApertura";
          //  console.log("se activo");
            let url =
                this.$store.getters.getRuta +
                "/modulos/admision/paciente/GetDia/" + this.IdEstacionWeb;

             let ListaVentasFecha = [];
             let ListaVentasFecha2 = [];
             let _ListaComparar = ["DIESEL", "ECO", "SUPER"];
           

            axios
                .get(url)
                .then((response) => {
                  //  ListaVentasFecha.push(response.data.Resp);
                   
                   ListaVentasFecha= response.data.Resp;
                  console.log("ListaVentasFecha",ListaVentasFecha); 
 
                        for (let index in ListaVentasFecha) {
                      
                        const element = ListaVentasFecha[index];
                        for (
                            let item = 0;
                            item < element.length;
                            item++
                        ) {
                           
                          
                            if (item == 0) {
                              //  console.log("ListaVentasFecha", element[item].dia);
                                this.IndiceVentas.push(
                                    element[item].dia.replace(
                                        " 00:00:00",
                                        ""
                                    )
                                );
                            }
                        }
                        // //
                        if (element.length == 4) {
                        
                            for (
                                let item = 0;
                                item < element.length;
                                item++
                            ) {
                                let _descripcion = "";
                                _descripcion =element[
                                    item
                                ].descripcion
                                    .toString()
                                    .replace(/\s+/g, "");

                                if (
                                    _descripcion == "DIESEL".replace(/\s+/g, "") ||  _descripcion == "DIESEL PREMIUM".replace(/\s+/g, "")
                                ) {
                                    this.GalonesDieselDiariaApertura.push(
                                        element[item].galones
                                    );
                                    this.MontoDieselDiariaApertura.push(
                                       element[item].total
                                    );
                                }
                                if (_descripcion == "ECO".replace(/\s+/g, "") || _descripcion == "EXTRA CON ETANOL".replace(/\s+/g, "") || _descripcion ==
                                "EXTRA") {
                                    this.GalonesEcoDiariaApertura.push(
                                       element[item].galones
                                    );
                                    this.MontoEcoDiariaApertura.push(
                                       element[item].total
                                    );
                                }
                                if (
                                    _descripcion.replace(/\s+/g, "") == "SUPER".replace(/\s+/g, "") || _descripcion.replace(/\s+/g, "") == "SUPER PREMIUM".replace(/\s+/g, "")
                                ) {
                                    this.GalonesSuperDiariaApertura.push(
                                       element[item].galones
                                    );
                                    this.MontoSuperDiariaApertura.push(
                                       element[item].total
                                    );
                                }
                                if (
                                    _descripcion ==
                                    "ECOPLUS89".replace(/\s+/g, "")
                                ) {
                                    this.GalonesEcoPlusDiariaApertura.push(
                                       element[item].galones
                                    );
                                    this.MontoEcoPlusDiariaApertura.push(
                                       element[item].total
                                    );
                                }
                            }
                        }

                        if (
                            element.length == 3 ||
                            element.length == 2
                        ) {
                        
                            let _listaExiste3 = [];
                            for (
                                let item2 = 0;
                                item2 < element.length;
                                item2++
                            ) {
                                let _descripcion = "";
                                _descripcion =element[
                                    item2
                                ].descripcion.replace(/\s+/g, "");

                                _listaExiste3.push(_descripcion);

                                if (
                                    _descripcion == "DIESEL".replace(/\s+/g, "") || _descripcion == "DIESEL PREMIUM".replace(/\s+/g, "")
                                ) {
                                    this.GalonesDieselDiariaApertura.push(
                                       element[item2].galones
                                    );
                                    this.MontoDieselDiariaApertura.push(
                                       element[item2].total
                                    );
                                }
                                if (_descripcion == "ECO".replace(/\s+/g, "") || _descripcion == "EXTRA CON ETANOL".replace(/\s+/g, "") || _descripcion ==
                                "EXTRA") {
                                    this.GalonesEcoDiariaApertura.push(
                                       element[item2].galones
                                    );
                                    this.MontoEcoDiariaApertura.push(
                                       element[item2].total
                                    );
                                }
                                if (
                                    _descripcion == "SUPER".replace(/\s+/g, "") ||_descripcion.replace(/\s+/g, "") ==  "SUPER PREMIUM".replace(/\s+/g, "")
                                ) {
                                    this.GalonesSuperDiariaApertura.push(
                                       element[item2].galones
                                    );
                                    this.MontoSuperDiariaApertura.push(
                                       element[item2].total
                                    );
                                }
                                if (
                                    _descripcion ==
                                    "ECOPLUS89".replace(/\s+/g, "")
                                ) {
                                    this.GalonesEcoPlusDiariaApertura.push(
                                       element[item2].galones
                                    );
                                    this.MontoEcoPlusDiariaApertura.push(
                                       element[item2].total
                                    );
                                }
                            }

                            let _listaResult = [];

                            for (var i of _ListaComparar) {
                                //console.log(i+"----> for 1")
                                let _resultList = _listaExiste3.filter(
                                    (element2) => element2 == i
                                );

                                if (_resultList.length == 0) {
                                    _listaResult.push(i);
                                }
                            }
                          //  console.log("_listaExiste3", _listaExiste3);
                          //  console.log("_listaResult", _listaResult);
                            for (var j of _listaResult) {
                                if (j == "DIESEL".replace(/\s+/g, "") || j == "DIESEL PREMIUM".replace(/\s+/g, "")) {
                                    this.GalonesDieselDiariaApertura.push(0);
                                    this.MontoDieselDiariaApertura.push(0);
                                }
                                if (j == "ECO".replace(/\s+/g, "") || j == "EXTRA CON ETANOL".replace(/\s+/g, "") || j ==
                                "EXTRA") {
                                    this.GalonesEcoDiariaApertura.push(0);
                                    this.MontoEcoDiariaApertura.push(0);
                                }
                                if (j == "SUPER".replace(/\s+/g, "")  || j.replace(/\s+/g, "") == "SUPER PREMIUM".replace(/\s+/g, "")) {
                                    this.GalonesSuperDiariaApertura.push(0);
                                    this.MontoSuperDiariaApertura.push(0);
                                }
                                if (j == "ECOPLUS89".replace(/\s+/g, "")) {
                                    this.GalonesEcoPlusDiariaApertura.push(0);
                                    this.MontoEcoPlusDiariaApertura.push(0);
                                }
                            }

                         
                        }
                    }
 
                    this.totalesDiarias();
                    this.totalesDiariasMonto();
                })
                .catch((error) => {
                  
                });
        },
        totalesDiarias() {
            var CirEco = {
                label: "Eco Pais - Galones",
                data: this.GalonesEcoDiariaApertura,
                backgroundColor: "rgba(1, 58 , 251)",
                // borderColor: "rgba(99, 132, 0, 1)",
                borderColor: "rgba(1, 58 , 251)",
                lineTension: 0,
                fill: false,
                //  borderColor: "orange",
                // backgroundColor: "transparent",
                //borderDash: [5, 5],
                // pointBorderColor: "orange",
                // pointBackgroundColor: "rgba(255,150,0,0.5)",
                // pointRadius: 5,
                // pointHoverRadius: 10,
                // pointHitRadius: 30,
                // pointBorderWidth: 1,
                // pointStyle: "rectRounded",
            };
            var CirSuper = {
                label: "Super-Galones",
                data: this.GalonesSuperDiariaApertura,
                //backgroundColor: "rgb(253, 245, 230)",
                borderColor: "rgb(174, 187, 187 )",
                //borderWidth: 1,
                fill: false,
                lineTension: 0,
                // backgroundColor: "transparent",
                //  borderDash: [5, 5],
                // pointBorderColor: "orange",
                // pointBackgroundColor: "rgba(255,150,0,0.5)",
                // pointRadius: 5,
                // pointHoverRadius: 10,
                // pointHitRadius: 30,
                // pointBorderWidth: 1,
                // pointStyle: "rectRounded",
            };
            var CirDiesel = {
                label: "Diese-Galones",
                data: this.GalonesDieselDiariaApertura,
                // backgroundColor: "rgb(255, 255,0)",
                // borderColor: "rgba(99, 132, 0, 1)",
                borderColor: "rgb(244, 208, 63 )",
                // borderWidth: 1,
                fill: false,
                lineTension: 0,

                // backgroundColor: "transparent",
                // borderDash: [5, 5],
                // pointBorderColor: "orange",
                // pointBackgroundColor: "rgba(255,150,0,0.5)",
                // pointRadius: 5,
                // pointHoverRadius: 10,
                // pointHitRadius: 30,
                // pointBorderWidth: 1,
                // pointStyle: "rectRounded",
            };
            // var CirEcoPlus = {
            //     label: "Eco-Plus",
            //     data: this.GalonesEcoPlusDiariaApertura,
            //     //  backgroundColor: "rgba(255, 0, 0, 1)",
            //     borderColor: "rgba(255, 0, 0, 1)",
            //     fill: false,
            //     lineTension: 0,
            //     // fill: false,
            //     // borderColor: "orange",
            //     // backgroundColor: "transparent",
            //     //   borderDash: [5, 5],
            //     // pointBorderColor: "orange",
            //     // pointBackgroundColor: "rgba(255,150,0,0.5)",
            //     // pointRadius: 5,
            //     // pointHoverRadius: 10,
            //     // pointHitRadius: 30,
            //     // pointBorderWidth: 1,
            //     // pointStyle: "rectRounded",
            // };
            var totalesData = {
                labels: this.IndiceVentas,
                datasets: [CirEco, CirDiesel, CirSuper],
            };
            var chartOptions = {
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        boxWidth: 80,
                        fontColor: "black",
                    },
                },
                // scales: {
                //     xAxes: [
                //         {
                //             barPercentage: 1,
                //             categoryPercentage: 0.6,
                //         },
                //     ],
                //     yAxes: [
                //         {
                //             id: "y-axis-density",
                //         },
                //         {
                //             id: "y-axis-gravity",
                //         },
                //     ],
                // },
            };
            this.vardatosFechaApert = document
                .getElementById("ventasPorFechaApertura")
                .getContext("2d");
            this.chartDiariaApertura = new Chart(this.vardatosFechaApert, {
                type: "line",

                data: totalesData,
                options: chartOptions,
                //options: chartOptions
            });
        },

        totalesDiariasMonto() {
            var CirEco = {
                label: "Eco Pais-Monto",
                data: this.MontoEcoDiariaApertura,
                backgroundColor: "rgba(1, 58 , 251)",
                // borderColor: "rgba(99, 132, 0, 1)",
                borderColor: "rgb(0, 0, 0)",
                borderWidth: 1,
                fill: false,
                //  borderColor: "orange",
                // backgroundColor: "transparent",
                borderDash: [5, 5],
                // pointBorderColor: "orange",
                // pointBackgroundColor: "rgba(255,150,0,0.5)",
                // pointRadius: 5,
                // pointHoverRadius: 10,
                // pointHitRadius: 30,
                // pointBorderWidth: 1,
                // pointStyle: "rectRounded",
            };
            var CirSuper = {
                label: "Super-Monto",
                data: this.MontoSuperDiariaApertura,
                backgroundColor: "rgb(253, 245, 230)",
                borderColor: "rgb(0, 0, 0)",
                borderWidth: 1,
                fill: false,

                // backgroundColor: "transparent",
                borderDash: [5, 5],
                // pointBorderColor: "orange",
                // pointBackgroundColor: "rgba(255,150,0,0.5)",
                // pointRadius: 5,
                // pointHoverRadius: 10,
                // pointHitRadius: 30,
                // pointBorderWidth: 1,
                // pointStyle: "rectRounded",
            };
            var CirDiesel = {
                label: "Diese-Monto",
                data: this.MontoDieselDiariaApertura,
                backgroundColor: "rgb(255, 255,0)",
                // borderColor: "rgba(99, 132, 0, 1)",
                borderColor: "rgb(0, 0, 0)",
                borderWidth: 1,
                fill: false,
 
                // backgroundColor: "transparent",
                borderDash: [5, 5],
                // pointBorderColor: "orange",
                // pointBackgroundColor: "rgba(255,150,0,0.5)",
                // pointRadius: 5,
                // pointHoverRadius: 10,
                // pointHitRadius: 30,
                // pointBorderWidth: 1,
                // pointStyle: "rectRounded",
            };
            // var CirEcoPlus = {
            //     label: "Eco-Plus/Monto",
            //     data: this.MontoEcoPlusDiariaApertura,
            //     backgroundColor: "rgba(255, 0, 0, 1)",
            //     borderColor: "rgba(99, 132, 0, 1)",
            //     lineTension: 0,
            //     fill: false,
            //     borderColor: "orange",
            //     // backgroundColor: "transparent",
            //     borderDash: [5, 5],
            //     // pointBorderColor: "orange",
            //     // pointBackgroundColor: "rgba(255,150,0,0.5)",
            //     // pointRadius: 5,
            //     // pointHoverRadius: 10,
            //     // pointHitRadius: 30,
            //     // pointBorderWidth: 1,
            //     // pointStyle: "rectRounded",
            // };

            var totalesData = {
                labels: this.IndiceVentas,
                datasets: [CirEco, CirDiesel, CirSuper],
            };
            var chartOptions = {
                // scales: {
                //     xAxes: [
                //         {
                //             barPercentage: 1,
                //             categoryPercentage: 0.6,
                //         },
                //     ],
                //     yAxes: [
                //         {
                //             id: "y-axis-density",
                //         },
                //         {
                //             id: "y-axis-gravity",
                //         },
                //     ],
                // },
            };
            this.vardatosFechaApertMonto = document
                .getElementById("ventasPorFechaAperturaMonto")
                .getContext("2d");
            this.chartDiariaFechaApertura = new Chart(
                this.vardatosFechaApertMonto,
                {
                    type: "bar",

                    data: totalesData,
                    options: chartOptions,
                    //options: chartOptions
                }
            );
        },
      GenerarDocumentoExcelStockVentas() {
        let that = this;
  
        let form = {
          desde: this.fecha_buscar,
          hasta: this.fecha_buscar_hasta,
          estacion: this.ItemEstacion,
        };
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/paciente/ReporteFuelcorp";
        axios
          .post(url, form, { responseType: "blob" })
          .then((response) => {
            //console.log(response.data);
  
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute(
              "download",
              "Reporte_de_registros Lubricantes" + this.fecha_buscar + ".xls"
            ); //or any other extension
            document.body.appendChild(link);
            link.click();
          })
          .catch((error) => {
            console.log(error);
          });
      },
      consultasEstacionesPorFecha() {
        let that = this;
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/paciente/ConsultaGeneralFuelcorp/" +
          this.ItemEstacion+"/"+this.fecha_buscar+"/"+ this.fecha_buscar_hasta;
           this.ListaVentasStockEstaciones = [];
           this.ListaVentasGalones = [];
           this.ListaVentasGalonesCalibracion = [];
          // this.ListaConsolidadoProducto =  [];
          // this.ListaVentasStockEstaciones = [];
          // this.ListaStockEstaciones = [];
          // let ListaEstacionesConsilidadEsPro = [];
          // let ListaVentasStockEstacionesList = [];
        axios
          .get(url)
          .then((response) => {
  
            for (var iterator of response.data.TotalesEstaciones) {
              let objeto = {};
              objeto.fecha = iterator.fecha;
              objeto.EFECTIVO =  parseFloat(iterator.EFECTIVO).toFixed(2);
              objeto.MEDIO_DIGITAL =  parseFloat(iterator.MEDIO_DIGITAL).toFixed(2);
              objeto.CHEQUE =  parseFloat(iterator.CHEQUE).toFixed(2);
              objeto.TRANSFERENCIA =  parseFloat(iterator.TRANSFERENCIA).toFixed(2);
              objeto.CREDITO =  parseFloat(iterator.CREDITO).toFixed(2);
              objeto.CALIBRACIONES =  parseFloat(iterator.CALIBRACIONES).toFixed(2);
              objeto.TOTAL =  parseFloat(iterator.TOTAL).toFixed(2);
              this.ListaVentasStockEstaciones.push(objeto);
            }
  
  
  
            
            for (var iterator of response.data.fecha_reporte_galones) {
              let objeto = {};
              objeto.fecha = iterator.fecha;
              objeto.EXTRA_CON_ETANOL =  parseFloat(iterator.EXTRA_CON_ETANOL).toFixed(2);
              objeto.DIESEL =  parseFloat(iterator.DIESEL).toFixed(2);
              objeto.SUPER_PREMIUM_95 =  parseFloat(iterator.SUPER_PREMIUM_95).toFixed(2);
           
              objeto.TOTAL =  parseFloat(iterator.TOTAL).toFixed(2);
              this.ListaVentasGalones.push(objeto);
            }
  
  
              
            for (var iterator of response.data.fecha_reporte_galones_calibracion) {
              let objeto = {};
              objeto.fecha = iterator.fecha;
              objeto.EXTRA_CON_ETANOL =  parseFloat(iterator.EXTRA_CON_ETANOL).toFixed(2);
              objeto.DIESEL =  parseFloat(iterator.DIESEL).toFixed(2);
              objeto.SUPER_PREMIUM_95 =  parseFloat(iterator.SUPER_PREMIUM_95).toFixed(2);
           
              objeto.TOTAL =  parseFloat(iterator.TOTAL).toFixed(2);
              this.ListaVentasGalonesCalibracion.push(objeto);
            }
  
  
            this.ListaGastosEstaciones = response.data.fecha_gastos;
            //this.ListaVentasStockEstaciones = response.data.TotalesEstaciones;
            // ListaEstacionesConsilidadEsPro = response.data.TotalesEstacionesProducto;
            // ListaVentasStockEstacionesList = response.data.productoVenta;
            // this.ListaStockEstaciones = response.data.productoVentaStock;
  
            // console.log("ListaVentasStockEstacionesList", ListaVentasStockEstacionesList);
           
          })
          .catch((error) => {
            console.log("error", error);
          });
      },
      consultasEstaciones() {
        let that = this;
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/paciente/ConsultaEstaciones";
        let ListEstacionesRecorrer = [];
        this.ListEstaciones = [];
        axios
          .get(url)
          .then((response) => {
            ListEstacionesRecorrer = response.data.Resp;
            console.log("ListaEstaciones1", ListEstacionesRecorrer);
            //  that.valor = response.data.data;
  
            ListEstacionesRecorrer.forEach((element) => {
              let objeto = {};
              objeto.id = element.id;
              objeto.nombre = element.descripcion;
              objeto.icon = "mdi-fuel";
              objeto.color = "primary";
              this.ListEstaciones.push(objeto);
            });
            let objeto = {};
            objeto.id = 0;
            objeto.nombre = "TODAS LAS ESTACIONES";
            objeto.icon = "mdi-fuel";
            objeto.color = "primary";
            this.ListEstaciones.push(objeto);
          })
          .catch((error) => {
            console.log("error del sistema" + error);
          });
      },
      Consultaanio(id) {
        this.anioItem = id;
        this.consultasVentasLubriPorEstacion();
      },
      ConsultaMes(id) {
        this.mesItem = id;
        this.consultasVentasLubriPorEstacion();
      },
      consultasVentasLubriPorEstacion() {
        let that = this;
  
        //   if (this.EstacionItem === "") {
        //     this.mensajeAler("selecione la estación", false);
        //     return;
        //   }
        if (this.anioItem === "") {
          
          return;
        }
        if (this.mesItem === "") {
          
          return;
        }
        if (this.chartGalonesMesFormaPago != null) {
          this.chartGalonesMesFormaPago.clear();
          this.chartGalonesMesFormaPago.destroy();
        }
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/paciente/ConsultaGeneral/" +
          this.mesItem +
          "/" +
          this.anioItem+
          "/" +
          this.ItemEstacion;
  
          this.ListInformacion={
          extratotal: 0,
          dieseltotal: 0,
          supertotal: 0,
          extragalones: 0,
          dieselgalones: 0,
          supergalones: 0,
        };
  
        this.ListFormaPago= [];
        this.GalonesTotalMesFormaPago= [];
        this.MontoTotalMesFormaPago= [];
  
       let ListaInformacionLLenar = [];
       let ListaFormaPagoChart = [];
  
        this.loading = true;
        axios
          .get(url)
          .then((response) => {
           
  
            //recorrido producto mas vendido
            let con3 = 15;
            ListaInformacionLLenar = response.data.TotalesVendido;
            ListaFormaPagoChart = response.data.FormaPago;
     
            for (var iterator of ListaInformacionLLenar) {
  
  
            
              if (iterator.idProducto == 1) {
  
                  this.ListInformacion.dieselgalones = parseFloat(iterator.Total_cantidad).toFixed(2);
                  this.ListInformacion.dieseltotal = parseFloat(iterator.Total_dolares).toFixed(2);
                  
              }
  
              if ( iterator.idProducto == 2) {
  
                  this.ListInformacion.extragalones = parseFloat(iterator.Total_cantidad).toFixed(2);
                  this.ListInformacion.extratotal = parseFloat(iterator.Total_dolares).toFixed(2);
  
                  }
                  if ( iterator.idProducto == 3) {
  
                      this.ListInformacion.supergalones = parseFloat(iterator.Total_cantidad).toFixed(2);
                      this.ListInformacion.supertotal = parseFloat(iterator.Total_dolares).toFixed(2);
  
                      }
              // this.ListInformacion.GalonesTotalMes;
  
              // this.ListProductoMasVendidoEstaciones.push(
              //   ListaProductoMasVendidoEstaVentasLubri[iterator]["max"]
              //     .des_estacion +
              //     " " +
              //     ListaProductoMasVendidoEstaVentasLubri[iterator]["max"]
              //       .DesProducto
              // );
              // this.ListValorProductoMasVendidoEstaciones.push(
              //   ListaProductoMasVendidoEstaVentasLubri[iterator][
              //     "max"
              //   ].Total_dolares.toFixed(2)
              // );
              // this.ListCantidadProductoMasVendidoEstaciones.push(
              //   ListaProductoMasVendidoEstaVentasLubri[iterator]["max"]
              //     .Total_cantidad
              // );
              // con3++;
               
            }
            /// formas de pagos for
            for (var iterator of ListaFormaPagoChart) {
            
              let objeto = {};
              this.ListFormaPago.push(iterator.des_estacion);
              this.GalonesTotalMesFormaPago.push(iterator.Total_cantidad);
              this.MontoTotalMesFormaPago.push(iterator.Total_dolares);
            }
  
           
            this.loading = false;
            this.totalesMesFormaPago();
  
            
          })
          .catch((error) => {
            //Errores de validación
            console.log("error de sistema aqui" + error);
          });
      },
  
      totalesMesFormaPago() {
              var cirSuspendida = {
                  label: "GALONES VENDIDO POR MES",
                  data: this.GalonesTotalMesFormaPago,
                  backgroundColor: "rgba(255, 0, 0, 1)",
                  borderColor: "rgba(99, 132, 0, 1)",
                  // lineTension: 0,
                  // fill: false,
                  // borderColor: "orange",
                  // backgroundColor: "transparent",
                  // borderDash: [5, 5],
                  // pointBorderColor: "orange",
                  // pointBackgroundColor: "rgba(255,150,0,0.5)",
                  // pointRadius: 5,
                  // pointHoverRadius: 10,
                  // pointHitRadius: 30,
                  // pointBorderWidth: 1,
                  // pointStyle: "rectRounded",
              };
              var CirMontoDolares = {
                  label: "MONTO EN DOLARES VENDIDO POR MES",
                  data: this.MontoTotalMesFormaPago,
                  backgroundColor: "rgb(0, 100, 0)",
                  borderColor: "rgb(0, 100, 0)",
                  //  lineTension: 0,
                  //  fill: false,
  
                  // backgroundColor: "transparent",
                  // borderDash: [5, 5],
                  // pointBorderColor: "orange",
                  // pointBackgroundColor: "rgba(255,150,0,0.5)",
                  // pointRadius: 5,
                  // pointHoverRadius: 10,
                  // pointHitRadius: 30,
                  // pointBorderWidth: 2,
                  // pointStyle: "rectRounded",
              };
              var totalesData = {
                  labels: this.ListFormaPago,
                  datasets: [cirSuspendida, CirMontoDolares],
              };
              var chartOptions = {
                  // scales: {
                  //     xAxes: [
                  //         {
                  //             barPercentage: 1,
                  //             categoryPercentage: 0.6,
                  //         },
                  //     ],
                  //     yAxes: [
                  //         {
                  //             id: "y-axis-density",
                  //         },
                  //         {
                  //             id: "y-axis-gravity",
                  //         },
                  //     ],
                  // },
              };
              this.vardatos = document
                  .getElementById("formaPagosChart")
                  .getContext("2d");
              this.chartGalonesMesFormaPago = new Chart(this.vardatos, {
                  type: "horizontalBar",
  
                  data: totalesData,
                  options: chartOptions,
                  //options: chartOptions
              });
          },
      generarId() {
        this.IdEstacionWeb = this.$route.params.id;
        this.NombreEstacion = this.$route.params.nombre;
      },
      GenerarTaks() {
        // let url =
        //     this.$store.state.ApiGasquil +
        //     "Dashboard/GetVentasDiariosFechaApertura";
        //  console.log("se activo");
        let url =
          this.$store.getters.getRuta + "/modulos/admision/paciente/GetDia";
  
        let ListaVentasFecha = [];
        let ListaVentasFecha2 = [];
        let _ListaComparar = ["DIESEL", "ECO", "SUPER"];
  
        axios
          .get(url)
          .then((response) => {
            //  ListaVentasFecha.push(response.data.Resp);
  
            ListaVentasFecha = response.data.Resp;
          })
          .catch((error) => {});
      },
      GenerarModal(value) {
        this.dialog = true;
      },
  
   
    },
  };
  </script>
  <style scoped>
  h3 {
    margin: 40px 0 0;
  }
  ul {
    list-style-type: none;
    padding: 0;
  }
  li {
    display: inline-block;
    margin: 0 10px;
  }
  a {
    color: #42b983;
  }
  </style>
  <style>
  .v-icon.outlined {
    position: relative;
    top: -40px;
    left: 0px;
  }
  </style>
  