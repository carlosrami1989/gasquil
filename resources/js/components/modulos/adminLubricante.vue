<template>
  <div>
    <v-row no-gutters>
      <v-col cols="12" sm="2" class="align-center">
        <br />
        <v-img src="/img/LogOperoil.png" class="grey darken-4"> </v-img>
      </v-col>
      <v-col cols="12" sm="2" class="pa-1">
        <v-card outlined tile elevation="8" class="rounded-lg">
          <v-system-bar color="indigo darken-2" dark class="white--text"
            >AÑO</v-system-bar
          >

          <v-chip-group active-class="success" column>
            <v-chip
              v-for="tag in Listanio"
              :key="tag"
              @click="Consultaanio(tag)"
            >
              {{ tag }}
            </v-chip>
          </v-chip-group>
        </v-card>
      </v-col>

      <v-col cols="12" sm="8" class="pa-1">
        <v-card outlined tile elevation="8" class="rounded-lg">
          <v-system-bar color="indigo darken-2" dark class="white--text"
            >mes</v-system-bar
          >
          <v-chip-group active-class="success" column>
            <v-chip
              v-for="tag in Listames"
              :key="tag.id"
              @click="ConsultaMes(tag.id)"
            >
              {{ tag.mes }}
            </v-chip>
          </v-chip-group>
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
    <v-row no-gutters> </v-row>
    <!-- INICIO DE LA LISTA -->

    <v-row no-gutters>
      <v-col cols="12" sm="6" class="pa-1">
        <v-card
          outlined
          tile
          elevation="8"
          class="rounded-lg"
          :loader-height="5"
          :loading="loading"
        >
          <v-system-bar color="indigo darken-2" dark class="white--text"
            >Ventas Por Estaciones</v-system-bar
          >
          <v-card-text>
            <canvas id="VentasPorEstaciones" width="200" height="200"></canvas>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" class="pa-1">
        <v-card
          outlined
          tile
          elevation="8"
          class="rounded-lg"
          :loader-height="5"
          :loading="loading"
        >
          <v-system-bar color="indigo darken-2" dark class="white--text"
            >Producto mas Vendido</v-system-bar
          >
          <v-card-text>
            <canvas
              id="VentasPorductoMaxPorEstaciones"
              width="200"
              height="200"
            ></canvas>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

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
            >Mejor Vendedor por estacion</v-system-bar
          >

          <v-card-text>
            <canvas
              id="VentasMejorPorEstaciones"
              width="200"
              height="100"
            ></canvas>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <!-- <v-row no-gutters>
       

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
            >Mejor Vendedor por estacion Por Cantidad</v-system-bar
          >

          <v-card-text>
            <canvas
              id="VentasMejorPorEstacionesCantidad"
              width="200" height="100"
            ></canvas>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row> -->
    <!-- fin de las lista -->

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
              <input type="date" v-model="fecha_buscar" />
              <label>Seleccione Fecha fin :</label>
              <input type="date" v-model="fecha_buscar_hasta" />
              <v-btn color="success" @click="consultasEstacionesPorFecha()"
                >Generar Reporte</v-btn
              >
              <v-card-text>
                <v-text-field
                  v-model="searchVentasStockEstaciones"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
                <v-data-table
                  :headers="CabeceraVentasStockEstaciones"
                  :items="ListaVentasStockEstaciones"
                  :search="searchVentasStockEstaciones"
                  :items-per-page="30"
                >
                  <template v-slot:[`item.stock`]="{ item }">
                    <v-chip color="success" dark>
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
            >STOCK POR ESTACION</v-system-bar
          >
          <v-card-title>
            <v-card-text>
              <v-text-field
                v-model="searchStockEstaciones"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
              <v-data-table
                :headers="CabeceraStockEstaciones"
                :items="ListaStockEstaciones"
                :search="searchStockEstaciones"
                :items-per-page="30"
              >
              </v-data-table>

              <v-row dense xl="4" md="2">
                <v-col>
                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        color="green"
                        dark
                        v-bind="attrs"
                        v-on="on"
                        @click="GenerarDocumentoExcelStockEstaciones()"
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
            </v-card-text>
          </v-card-title>

          <div style="width: auto; text-align: center"></div>
        </v-card>
      </v-col>
    </v-row>

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
            >CONSOLIDADO DE VENTAS POR ESTACION</v-system-bar
          >
          <v-card-title>
            <v-card-text>
              <v-text-field
                v-model="searchEstaciones"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
              <v-data-table
                :headers="CabeceraEstacione"
                :items="ListaConsolidadoEstaciones"
                :search="searchEstaciones"
                :items-per-page="30"
              >
              </v-data-table>

              <v-row dense xl="4" md="2">
                <v-col>
                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        color="green"
                        dark
                        v-bind="attrs"
                        v-on="on"
                        @click="GenerarDocumentoExcel()"
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
            </v-card-text>
          </v-card-title>

          <div style="width: auto; text-align: center"></div>
        </v-card>
      </v-col>
    </v-row>

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
            >Consolidado Productos Por estaciones</v-system-bar
          >
          <v-card-title>
            <v-card-text>
              <v-text-field
                v-model="searchEstacionesProducto"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
              <v-data-table
                :headers="CabeceraProductoConsolidado"
                :items="ListaConsolidadoProducto"
                :search="searchEstacionesProducto"
                :items-per-page="30"
              >
              </v-data-table>
              <v-row dense xl="4" md="2">
                <v-col>
                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        color="green"
                        dark
                        v-bind="attrs"
                        v-on="on"
                        @click="GenerarDocumentoExcelConsolidado()"
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

    <v-snackbar
      v-model="snackbar"
      :timeout="timeout"
      absolute
      top
      :color="color"
    >
      <v-icon>{{ icono }}</v-icon>
      {{ text }}
    </v-snackbar>
  </div>
</template>
<script>
import { prefix, url } from "../../variables";
import { funcionesGlobales } from "../../funciones";
import { fill } from "lodash";
export default {
  props: {
    user: {
      type: Object,
    },
  },
  data() {
    return {
      snackbar: false,
      color: "purple darken-4",
      text: "",
      icono: "mdi-checkbox-marked",
      timeout: 4000,
      EstacionItem: "",
      mesItem: "",
      diaItem: "",
      diaActual: "",
      anioItem: "",
      justify: ["start", "center", "end", "space-around", "space-between"],
      Listanio: ["2022", "2023", "2024"],
      Listames: [
        { id: "1", mes: "Enero" },
        { id: "2", mes: "Febrero" },
        { id: "3", mes: "Marzo" },
        { id: "4", mes: "Abril" },
        { id: "5", mes: "Mayo" },
        { id: "6", mes: "Junio" },
        { id: "7", mes: "Julio" },
        { id: "8", mes: "Agosto" },
        { id: "9", mes: "Septiembre" },
        { id: "10", mes: "Octubre" },
        { id: "11", mes: "Noviembre" },
        { id: "12", mes: "Diciembre" },
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
      fecha_buscar: new Date().toISOString().slice(0, 10),
      fecha_buscar_hasta: new Date().toISOString().slice(0, 10),
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

      //ventas de lubricantes por estaciones
      chartvarChartVentasEstaciones: null,
      varChartVentasEstaciones: null,
      LIstEstacionesIndicesVentasEstaciones: [],
      LIstValorEstacionesIndicesVentasEstaciones: [],
      LIstCantidadEstacionesIndicesVentasEstaciones: [],
      LIstColorIndicesVentasEstacionesc: [],
      LIstColorIndicesVentasEstaciones: [],

      //Mejor vendedor por estacion
      chartMejorVentasEstaciones: null,
      varCharMejortVentasEstaciones: null,
      ListEstacionesMejorVentasEstaciones: [],
      ListValorMejorVentasEstaciones: [],
      ListCantidadMejorVentasEstaciones: [],
      ListVendedorMejorVentasEstaciones: [],
      LIstColorMejorVentasEstaciones: [],

      //Mejor vendedor por estacion Cantidad
      chartMejorVentasEstacionesC: null,
      varCharMejortVentasEstacionesC: null,
      ListEstacionesMejorVentasEstacionesC: [],
      ListValorMejorVentasEstacionesC: [],
      ListVendedorMejorVentasEstacionesC: [],
      LIstColorMejorVentasEstacionesC: [],

      //Producto mas Vendido
      chartProductoMasVendidoEstaciones: null,
      varCharProductoMasVendidoEstaciones: null,
      ListProductoMasVendidoEstaciones: [],
      ListValorProductoMasVendidoEstaciones: [],
      ListCantidadProductoMasVendidoEstaciones: [],
      LIstColorProductoMasVendidoEstaciones: [],

      //fin

      //fin

      //fin
      indice: [],
      valores: [],

      DescripcionTotalMes: [],

      chartGalonesMes: null,
      loading: false,
      sliderTimer: null,
      search: "",

      ListaGastos: [],
      /***GRID ESTACIONES */
      searchEstaciones: "",
      searchEstacionesProducto: "",
      searchVentasStockEstaciones: "",
      searchStockEstaciones: "",

      CabeceraEstacione: [
        {
          text: "Estación",
          align: "start",

          value: "des_estacion",
          class: "indigo darken-2 white--text",
        },
        {
          text: "Fecha",
          value: "Fecha",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "Cliente",
          value: "Nombre",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "MontoDolares",
          value: "MontoDolares",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "numerofactura",
          value: "numerofactura",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "Vendedor",
          value: "Vendedor",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "DesProducto",
          value: "DesProducto",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "Cantidad",
          value: "Cantidad",
          class: "indigo darken-2 white--text ",
        },

        {
          text: "Precio",
          value: "Precio",
          class: "indigo darken-2 white--text",
        },
        {
          text: "MontoDolaresDes",
          value: "MontoDolaresDes",
          class: "indigo darken-2 white--text",
        },
        {
          text: "Fecha Actualizacion",
          value: "created_at",
          class: "indigo darken-2 white--text",
        },
      ],
      ListaConsolidadoEstaciones: [],

      CabeceraProductoConsolidado: [
        {
          text: "Estación",
          align: "start",

          value: "estacion",
          class: "indigo darken-2 white--text",
        },
        {
          text: "Producto",
          value: "producto",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "Cantidad",
          value: "Total_cantidad",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "MontoDolares",
          value: "Total_dolares",
          class: "indigo darken-2 white--text ",
        },
      ],
      ListaConsolidadoProducto: [],

      //StockVentas
      CabeceraVentasStockEstaciones: [
        {
          text: "Estación",
          align: "start",

          value: "estacion",
          class: "indigo darken-2 white--text",
        },
        {
          text: "Descripcion",
          value: "producto",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "stock",
          value: "stock",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "facturado",
          value: "facturado",
          class: "indigo darken-2 white--text ",
        },
        { text: "total", value: "total", class: "red red-2 white--text " },
        {
          text: "estado",
          value: "estado",
          class: "indigo darken-2 white--text ",
        },
      ],
      ListaVentasStockEstaciones: [],
      //StockVentasEstaciones
      CabeceraStockEstaciones: [
        {
          text: "Estación",
          align: "start",

          value: "des_estacion",
          class: "indigo darken-2 white--text",
        },
        {
          text: "Descripcion",
          value: "Descripcion",
          class: "indigo darken-2 white--text ",
        },
        {
          text: "stock",
          value: "Cantidad",
          class: "indigo darken-2 white--text ",
        },
      ],
      ListaStockEstaciones: [],
      ///
      /**chart dia */
      IndiceVentasEstaciones: [],
      GalonesDiariaApertura: [],
      MontoTotalMesDiariaApertura: [],
      chartDiarioApertura: null,
    };
  },
  mounted() {
    //  setInterval(  this.GenerarVentasDiariasFecha(), 8000);
    // this.GenerarTotalVentas();
    let that = this;
    this.consultasEstaciones();
    // this.sliderTimer = setInterval(function () {
    //   //  console.log("hola");

    //   that.consultasVentasLubriPorEstacion();
    // }, 4000);
    //this.GenerarToken();
  },
  methods: {
    generar() {},
    GenerarDocumentoExcelStockEstaciones() {
      let that = this;

      let form = {
        desde: this.fecha_buscar,
        hasta: this.fecha_buscar_hasta,
        estacion: this.ItemEstacion,
      };
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/generacionExcelLubricantesStockEstacion";
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
    GenerarDocumentoExcelStockVentas() {
      let that = this;

      let form = {
        desde: this.fecha_buscar,
        hasta: this.fecha_buscar_hasta,
        estacion: this.ItemEstacion,
      };
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/generacionExcelLubricantesStockVentas";
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
    GenerarDocumentoExcel() {
      let that = this;

      let form = {
        desde: this.fecha_buscar,
        hasta: this.fecha_buscar_hasta,
        estacion: this.ItemEstacion,
      };
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/generacionExcelLubricantes";
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
    GenerarDocumentoExcelConsolidado() {
      let that = this;

      let form = {
        desde: this.fecha_buscar,
        hasta: this.fecha_buscar_hasta,
        estacion: this.ItemEstacion,
      };
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/generacionExcelLubricantesConso";
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
        "/modulos/admision/paciente/ConsultarReporte/" +
        this.ItemEstacion +
        "/" +
        this.fecha_buscar +
        "/" +
        this.fecha_buscar_hasta;
      this.ListaConsolidadoEstaciones = [];
      this.ListaConsolidadoProducto = [];
      this.ListaVentasStockEstaciones = [];
      this.ListaStockEstaciones = [];
      let ListaEstacionesConsilidadEsPro = [];
      let ListaVentasStockEstacionesList = [];
      axios
        .get(url)
        .then((response) => {
          this.ListaConsolidadoEstaciones = response.data.TotalesEstaciones;
          ListaEstacionesConsilidadEsPro =
            response.data.TotalesEstacionesProducto;
          ListaVentasStockEstacionesList = response.data.productoVenta;
          this.ListaStockEstaciones = response.data.productoVentaStock;

          console.log(
            "ListaVentasStockEstacionesList",
            ListaVentasStockEstacionesList
          );

          // lista estaciones por stock ventas
          for (
            let index = 0;
            index < ListaVentasStockEstacionesList.length;
            index++
          ) {
            //const element = array[index];
            // console.log("for",this.MontoTotalMes);
            // console.log("consolidado", this.ListaConsolidadoEstaciones[index].des_estacion);
            let objeto = {};
            objeto.estacion =
              this.ItemEstacion == 0
                ? "COPEDESA"
                : ListaVentasStockEstacionesList[index].des_estacion;

            objeto.producto = ListaVentasStockEstacionesList[index].codigop;
            objeto.stock = ListaVentasStockEstacionesList[index].stock;
            objeto.facturado = ListaVentasStockEstacionesList[index].facturado;
            objeto.total = ListaVentasStockEstacionesList[index].total;
            objeto.estado = ListaVentasStockEstacionesList[index].estado;

            this.ListaVentasStockEstaciones.push(objeto);
          }

          console.log(
            "ListaVentasStocEkstaciones",
            this.ListaVentasStockEstaciones
          );
          /////

          for (
            let index = 0;
            index < ListaEstacionesConsilidadEsPro.length;
            index++
          ) {
            //const element = array[index];
            // console.log("for",this.MontoTotalMes);
            // console.log("consolidado", this.ListaConsolidadoEstaciones[index].des_estacion);
            let objeto = {};
            objeto.estacion =
              this.ItemEstacion == 0
                ? "COPEDESA"
                : ListaEstacionesConsilidadEsPro[index].des_estacion;

            objeto.producto = ListaEstacionesConsilidadEsPro[index].DesProducto;
            objeto.Total_cantidad =
              ListaEstacionesConsilidadEsPro[index].Total_cantidad;
            objeto.Total_dolares =
              ListaEstacionesConsilidadEsPro[index].Total_dolares;

            this.ListaConsolidadoProducto.push(objeto);
          }

          console.log(
            "ListaConsolidadoProducto",
            this.ListaConsolidadoProducto
          );
        })
        .catch((error) => {
          //Errores de validación
        });
    },
    totalesEstacionDia() {
      this.loading = false;
      var cirSuspendida = {
        label: "GALONES VENDIDO POR DIA",
        data: this.GalonesDiariaApertura,
        backgroundColor: "#00008B",
        borderColor: "#00008B",
        lineTension: 0,
        fill: false,
      };
      var CirMontoDolares = {
        label: "MONTO EN DOLARES VENDIDO POR DIA",
        data: this.MontoTotalMesDiariaApertura,
        backgroundColor: "#008000",
        borderColor: "#008000",
        lineTension: 0,
        fill: false,
      };
      var totalesData = {
        labels: this.IndiceVentasEstaciones,
        datasets: [cirSuspendida, CirMontoDolares],
      };
      var chartOptions = {
        title: {
          display: true,
          text: "Total de ventas por estaciones",
        },
        legend: {
          display: true,
          position: "left",
          labels: {
            boxWidth: 80,
            fontColor: "black",
            position: "left",
          },
        },
      };

      this.vardatos = document
        .getElementById("EstacionesPorDia")
        .getContext("2d");
      this.chartDiarioApertura = new Chart(this.vardatos, {
        type: "bar",

        data: totalesData,
        options: chartOptions,
        //options: chartOptions
      });
      clearInterval(this.sliderTimer);
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
    // ConsultaEstacionItem(id) {
    //   this.EstacionItem = id;
    //   this.consultasVentasLubriPorEstacion();
    // },

    consultasVentasLubriPorEstacion() {
      let that = this;

      //   if (this.EstacionItem === "") {
      //     this.mensajeAler("selecione la estación", false);
      //     return;
      //   }
      if (this.anioItem === "") {
        this.mensajeAler("selecione el año", false);
        return;
      }
      if (this.mesItem === "") {
        this.mensajeAler("selecione el mes", false);
        return;
      }
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/ConsultarVendedorPorEstacion/" +
        this.mesItem +
        "/" +
        this.anioItem;

      if (this.chartvarChartVentasEstaciones != null) {
        this.chartvarChartVentasEstaciones.clear();
        this.chartvarChartVentasEstaciones.destroy();
      }

      if (this.chartMejorVentasEstaciones != null) {
        this.chartMejorVentasEstaciones.clear();
        this.chartMejorVentasEstaciones.destroy();
      }

      if (this.chartProductoMasVendidoEstaciones != null) {
        this.chartProductoMasVendidoEstaciones.clear();
        this.chartProductoMasVendidoEstaciones.destroy();
      }

      if (this.chartMejorVentasEstacionesC != null) {
        this.chartMejorVentasEstacionesC.clear();
        this.chartMejorVentasEstacionesC.destroy();
      }

      this.LIstEstacionesIndicesVentasEstaciones = [];
      this.LIstValorEstacionesIndicesVentasEstaciones = [];
      this.LIstCantidadEstacionesIndicesVentasEstaciones = [];
      this.LIstCantidadEstacionesIndicesVentasEstaciones2 = [];
      this.LIstColorIndicesVentasEstaciones = [];

      this.ListEstacionesMejorVentasEstacionesC = [];
      this.ListValorMejorVentasEstacionesC = [];
      this.ListVendedorMejorVentasEstacionesC = [];
      this.LIstColorMejorVentasEstacionesC = [];

      this.ListEstacionesMejorVentasEstaciones = [];
      this.ListValorMejorVentasEstaciones = [];
      this.ListVendedorMejorVentasEstaciones = [];
      this.ListCantidadMejorVentasEstaciones = [];

      this.ListProductoMasVendidoEstaciones = [];
      this.ListValorProductoMasVendidoEstaciones = [];
      this.LIstColorProductoMasVendidoEstaciones = [];
      this.ListCantidadProductoMasVendidoEstaciones = [];

      let ListaEstacionesVentasLubri = [];
      let ListaMejorVendedorEstaVentasLubri = [];
      let ListaMejorVendedorEstaVentasLubriC = [];
      let ListaProductoMasVendidoEstaVentasLubri = [];

      this.loading = true;
      axios
        .get(url)
        .then((response) => {
          ListaEstacionesVentasLubri = response.data.TotalesVendido;
          ListaMejorVendedorEstaVentasLubri =
            response.data.ListadoVendedorTodosMax;
          ListaMejorVendedorEstaVentasLubriC =
            response.data.ListadoVendedorCantidad;
          ListaProductoMasVendidoEstaVentasLubri = response.data.productoMax;

          //console.log("objetoPruebaMaximo", this.ListEstacionesMejorVentasEstaciones);

          //recorrido del mejor vendedor Cantidad
          // let con4 = 15;
          // for (const iterator in ListaMejorVendedorEstaVentasLubriC) {
          //   this.ListEstacionesMejorVentasEstacionesC.push(
          //     ListaMejorVendedorEstaVentasLubriC[iterator]["maxC"].des_estacion +
          //       " " +
          //       ListaMejorVendedorEstaVentasLubriC[iterator]["maxC"].Vendedor
          //   );
          //   this.ListValorMejorVentasEstacionesC.push(
          //     ListaMejorVendedorEstaVentasLubriC[iterator][
          //       "maxC"
          //     ].Total_cantidad
          //   );
          //   this.ListVendedorMejorVentasEstacionesC.push(
          //     ListaMejorVendedorEstaVentasLubriC[iterator]["maxC"].Vendedor
          //   );
          //   con4++;
          //   let n = (con4 * 0xfffff * 5000).toString(16);

          //   this.LIstColorMejorVentasEstacionesC.push("#" + n.slice(0, 6));
          // }

          //recorrido de las ventas x estacion
          let con = 14;
          ListaEstacionesVentasLubri.forEach((element) => {
            con++;

            this.LIstEstacionesIndicesVentasEstaciones.push(
              element.des_estacion
            );

            this.LIstValorEstacionesIndicesVentasEstaciones.push(
              element.Total_dolares.toFixed(2)
            );

            this.LIstCantidadEstacionesIndicesVentasEstaciones.push(
              element.Total_cantidad
            );

            let n = (con * 0xfffff * 2000).toString(16);
            let j = (con * 0xfffff * 3000).toString(16);

            this.LIstColorIndicesVentasEstaciones.push("#" + n.slice(0, 6));
            this.LIstColorIndicesVentasEstacionesc.push("#" + j.slice(0, 6));
          });

          //recorrido producto mas vendido
          let con3 = 15;

          for (const iterator in ListaProductoMasVendidoEstaVentasLubri) {
            this.ListProductoMasVendidoEstaciones.push(
              ListaProductoMasVendidoEstaVentasLubri[iterator]["max"]
                .des_estacion +
                " " +
                ListaProductoMasVendidoEstaVentasLubri[iterator]["max"]
                  .DesProducto
            );
            this.ListValorProductoMasVendidoEstaciones.push(
              ListaProductoMasVendidoEstaVentasLubri[iterator][
                "max"
              ].Total_dolares.toFixed(2)
            );
            this.ListCantidadProductoMasVendidoEstaciones.push(
              ListaProductoMasVendidoEstaVentasLubri[iterator]["max"]
                .Total_cantidad
            );
            con3++;
            let n = (con3 * 0xfffff * 5000).toString(16);

            this.LIstColorProductoMasVendidoEstaciones.push(
              "#" + n.slice(0, 6)
            );
          }

          //recorrido del mejor vendedor
          let con2 = 15;
          // console.log(
          //   "ListaMejorVendedorEstaVentasLubri",
          //   ListaMejorVendedorEstaVentasLubri
          // );

          for (const iterator in ListaMejorVendedorEstaVentasLubri) {
            let objeto = [];
            console.log("entro undife",  ListaMejorVendedorEstaVentasLubri[iterator]);

            if ( ListaMejorVendedorEstaVentasLubri[iterator] != undefined) {
              objeto.push(
              ListaMejorVendedorEstaVentasLubri[iterator]["max"][0]
                .des_estacion +
                " " +
                ListaMejorVendedorEstaVentasLubri[iterator]["max"][0].Vendedor
            );
            objeto.push(
              ListaMejorVendedorEstaVentasLubri[iterator]["max"][1]
                .des_estacion +
                " " +
                ListaMejorVendedorEstaVentasLubri[iterator]["max"][1].Vendedor);
                this.ListEstacionesMejorVentasEstaciones.push(objeto);

                this.ListValorMejorVentasEstaciones.push(
              ListaMejorVendedorEstaVentasLubri[iterator]["max"][0]
                .Total_cantidad
            );

            this.ListCantidadMejorVentasEstaciones.push(
              ListaMejorVendedorEstaVentasLubri[iterator]["max"][1]
                .Total_cantidad
            );

            this.ListVendedorMejorVentasEstaciones.push(
              ListaMejorVendedorEstaVentasLubri[iterator]["max"].Vendedor
            );
            con2++;
            let n = (con2 * 0xfffff * 5000).toString(16);

            this.LIstColorMejorVentasEstaciones.push("#" + n.slice(0, 6));

            }
          

              

            //  if (ListaMejorVendedorEstaVentasLubri[iterator]["max"][1] === undefined) {
            //   console.log("entro undife");
            //   objeto.push(
            //   ListaMejorVendedorEstaVentasLubri[iterator]["max"][0]
            //     .des_estacion +
            //     " " +
            //     ListaMejorVendedorEstaVentasLubri[iterator]["max"][0].Vendedor);
            //  }else{
             
            
            //  }
 
             

            //  console.log("ListaMejorVendedorEstaVentasLubriobjeto1",objeto);

          

            // if (ListaMejorVendedorEstaVentasLubri[iterator]["max"][1] === undefined) {
              
            // }else{

            // }

           
          }

          this.loading = false;

          this.totalesiaDriasMonto();
          this.totalesMejorVendedorMonto();
          //this.totalesMejorVendedorMontoC();
          this.totalesProductoMasVendidoMonto();
        })
        .catch((error) => {
          //Errores de validación
          console.log("error de sistema aqui" + error);
          this.loading = false;
          this.totalesiaDriasMonto();

          //this.totalesMejorVendedorMontoC();
          this.totalesProductoMasVendidoMonto();
          this.totalesMejorVendedorMonto();
        });
    },
    totalesiaDriasMonto() {
      var dsValoresVentas = {
        label: "Ventas Por Estaciones",
        data: this.LIstValorEstacionesIndicesVentasEstaciones,
        backgroundColor: this.LIstColorIndicesVentasEstaciones,
        borderColor: "black",
        borderWidth: 2,
      };

      var dsCantidadsVentas = {
        label: "Cantidad Por Estaciones",
        data: this.LIstCantidadEstacionesIndicesVentasEstaciones,
        backgroundColor: this.LIstColorIndicesVentasEstacionesc,
        borderColor: "black",
        borderWidth: 2,
      };

      var totalesData = {
        labels: this.LIstEstacionesIndicesVentasEstaciones,
        datasets: [dsValoresVentas, dsCantidadsVentas],
      };
      var chartOptions = {
        title: {
          display: true,
          text: "Total de ventas por estaciones",
        },
        legend: {
          display: true,
          position: "top",
        },
        layout: {
          padding: {
            top: 30,
            bottom: 30,
          },
        },
        elements: {
          bar: {
            borderWidth: 2,
          },
        },
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: "top",
          },
          datalabels: {
            display: true,
            position: "top",
          },
        },
      };
      this.varChartVentasEstaciones = document
        .getElementById("VentasPorEstaciones")
        .getContext("2d");

      this.chartvarChartVentasEstaciones = new Chart(
        this.varChartVentasEstaciones,
        {
          type: "horizontalBar",

          data: totalesData,
          options: chartOptions,
          //options: chartOptions
        }
      );
    },

    totalesMejorVendedorMonto() {
      var dsValoresVentas = {
        label: "Total Monto Cantidad Primero",
        data: this.ListValorMejorVentasEstaciones,
        backgroundColor: this.LIstColorMejorVentasEstaciones,
        borderColor: "black",
        borderWidth: 2,
        fill: false,
      };
      var dsValoresVentasCantidad = {
        label: "Total Monto Cantidad Segundo",
        data: this.ListCantidadMejorVentasEstaciones,
        backgroundColor: this.LIstColorMejorVentasEstaciones,
        borderColor: "black",
        borderWidth: 2,
        fill: false,
      };

      var totalesData = {
        labels: this.ListEstacionesMejorVentasEstaciones,
        datasets: [dsValoresVentas, dsValoresVentasCantidad],
      };
      var chartOptions4 = {
        title: {
          display: true,
        },

        legend: {
          display: true,
          position: "top",
          labels: { color: "red", position: "left" },
        },
        scales: {
          yAxesA: {
            id: "yAxisA",
            type: "linear",
            position: "left",
            ticks: {
              display: true,
              mirror: true,
              labelOffset: -5,
              padding: 5,
            },
          },
        },

        // animations: {
        //   tension: {
        //     duration: 1000,
        //     easing: "linear",
        //     from: 1,
        //     to: 0,
        //     loop: true,
        //   },
        // },
        // plugins: {
        //   datalabels: {
        //     display: true,
        //   },
        //   legend: {
        //     display: false,
        //     position : 'left',
        //     labels: {
        //       // This more specific font property overrides the global property
        //       font: {
        //         size: 14,
        //       },
        //     },
        //   },
        // },
        // scales: {
        //   y: {
        //     // defining min and max so hiding the dataset does not change scale range
        //     min: 0,
        //     max: 100,
        //   },
        // },
      };
      this.varCharMejortVentasEstaciones = document
        .getElementById("VentasMejorPorEstaciones")
        .getContext("2d");

      this.chartMejorVentasEstaciones = new Chart(
        this.varCharMejortVentasEstaciones,
        {
          type: "horizontalBar",

          data: totalesData,
          options: chartOptions4,
          //options: chartOptions
        }
      );
    },

    totalesMejorVendedorMontoC() {
      var dsValoresVentas = {
        label: "Total Monto Dolares",
        data: this.ListValorMejorVentasEstacionesC,
        backgroundColor: this.LIstColorMejorVentasEstacionesC,
        borderColor: "black",
        borderWidth: 2,
        fill: false,
      };

      var totalesData = {
        labels: this.ListEstacionesMejorVentasEstacionesC,
        datasets: [dsValoresVentas],
      };
      var chartOptions4 = {
        title: {
          display: true,
        },

        legend: {
          display: true,
          position: "top",
          labels: { color: "red", position: "left" },
        },
        scales: {
          yAxesA: {
            id: "yAxisA",
            type: "linear",
            position: "left",
            ticks: {
              display: true,
              mirror: true,
              labelOffset: -5,
              padding: 5,
            },
          },
        },

        // animations: {
        //   tension: {
        //     duration: 1000,
        //     easing: "linear",
        //     from: 1,
        //     to: 0,
        //     loop: true,
        //   },
        // },
        // plugins: {
        //   datalabels: {
        //     display: true,
        //   },
        //   legend: {
        //     display: false,
        //     position : 'left',
        //     labels: {
        //       // This more specific font property overrides the global property
        //       font: {
        //         size: 14,
        //       },
        //     },
        //   },
        // },
        // scales: {
        //   y: {
        //     // defining min and max so hiding the dataset does not change scale range
        //     min: 0,
        //     max: 100,
        //   },
        // },
      };
      this.varCharMejortVentasEstacionesC = document
        .getElementById("VentasMejorPorEstacionesCantidad")
        .getContext("2d");

      this.chartMejorVentasEstacionesC = new Chart(
        this.varCharMejortVentasEstacionesC,
        {
          type: "horizontalBar",

          data: totalesData,
          options: chartOptions4,
          //options: chartOptions
        }
      );
    },

    totalesProductoMasVendidoMonto() {
      var dsValoresMOnto = {
        label: "Total Monto Dolares",
        data: this.ListValorProductoMasVendidoEstaciones,
        backgroundColor: this.LIstColorProductoMasVendidoEstaciones,
        borderColor: "white",
        borderWidth: 2,
        fill: true,
      };

      var dsValoresCantidad = {
        label: "Total en Cantidad",
        data: this.ListCantidadProductoMasVendidoEstaciones,
        backgroundColor: this.LIstColorProductoMasVendidoEstaciones,
        borderColor: "white",
        borderWidth: 2,
        fill: true,
      };

      var totalesData = {
        labels: this.ListProductoMasVendidoEstaciones,
        datasets: [dsValoresMOnto, dsValoresCantidad],
      };
      var chartOptions = {
        responsive: true,
        plugins: {
          legend: {
            position: "top",
          },
          title: {
            display: true,
            text: "Chart.js Pie Chart",
          },
        },
      };
      this.varCharProductoMasVendidoEstaciones = document
        .getElementById("VentasPorductoMaxPorEstaciones")
        .getContext("2d");

      this.chartProductoMasVendidoEstaciones = new Chart(
        this.varCharProductoMasVendidoEstaciones,
        {
          type: "pie",

          data: totalesData,
          options: chartOptions,
          //options: chartOptions
        }
      );
    },

    mensajeAler(value, value2) {
      if (value2) {
        if (value) {
          this.icono = "mdi-checkbox-marked";
          (this.color = "green"), (this.snackbar = true);
          this.text = "Transacción realizada de manera exitosa";
        } else {
          this.icono = "mdi-close-box";
          (this.color = "light-blue darken-4"), (this.snackbar = true);
          this.text = "Transacción actualizada de manera exitosa";
        }
      } else {
        this.icono = "mdi-close-box";
        (this.color = "red darken-4"), (this.snackbar = true);
        this.text = "Error en el sistema " + value;
      }
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
td {
  font-size: 20px !important;
}

.v-icon.outlined {
  position: relative;
  top: -40px;
  left: 0px;
}
</style>
