<template>
  <div>
    <v-row no-gutters>
      <v-col cols="12" sm="2" class="align-center">
        <br />
        <v-img src="/img/undostres2.png" class="grey darken-4"> </v-img>
      </v-col>
      <v-col cols="12" sm="10" class="pa-1">
        <v-card outlined tile elevation="8" class="rounded-lg">
          <v-system-bar color="#005A70" dark class="white--text"
            >Bodegas</v-system-bar
          >

          <v-chip-group active-class="success" column>
            <v-chip
              v-for="(tag, index) in ListaBodegas"
              :key="index"
              @click="Consultaanio(tag)"
            >
              {{ tag.nombre }}
            </v-chip>
          </v-chip-group>
        </v-card>
      </v-col>
    </v-row>

    <!-- INICIO DE LA LISTA -->

    <v-row no-gutters>
      <v-col cols="12" sm="12" class="pa-1">
        <v-card
          outlined
          tile
          elevation="8"
          class="rounded-lg"
          :loader-height="10"
          :loading="loading"
          loading-text="Loading... Please wait"
        >
          <v-system-bar color="#005A70" dark class="white--text"
            >Filtro de fechas</v-system-bar
          >
          <v-card-text>
            <label>Seleccione Fecha inicio :</label>
            <input type="date" v-model="fecha_buscar" />
            <label>Seleccione Fecha fin :</label>
            <input type="date" v-model="fecha_buscar_hasta" />
            <v-btn
              class="ma-2"
              :loading="loading"
              :disabled="loading"
              color="success"
             @click="consultasFechaExpiracion()"
            >
            Generar Consulta
              <template v-slot:loader>
                <span>Cargando...</span>
              </template>
            </v-btn>
            <!-- <v-btn color="success" @click="consultasFechaExpiracion()"
              >Generar Consulta</v-btn
            > -->
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- card de datos rapidos -->

    <v-row no-gutters>
      <v-col cols="12" sm="4" class="pa-1">
        <v-card tile class="mx-auto rounded-lg" elevation="8">
          <v-list-item three-line>
            <v-list-item-content>
              <div class="text-overline mb-4">Copemarket</div>
              <v-list-item-title class="text-h5 mb-1">
                {{ ListaDashboard.documentos_generados }}
              </v-list-item-title>
              <v-list-item-subtitle>Documentos Generados</v-list-item-subtitle>
            </v-list-item-content>

            <v-icon tile size="100" offset-xl10 color="#005A70"
              >mdi-file</v-icon
            >
          </v-list-item>
        </v-card>
      </v-col>

      <v-col cols="12" sm="4" class="pa-1">
        <v-card tile class="mx-auto rounded-lg" elevation="8">
          <v-list-item three-line>
            <v-list-item-content>
              <div class="text-overline mb-4">Copemarket</div>
              <v-list-item-title class="text-h5 mb-1">
                {{ ListaDashboard.documentos_anulados }}
              </v-list-item-title>
              <v-list-item-subtitle>Documentos Anulados</v-list-item-subtitle>
            </v-list-item-content>

            <v-icon tile size="100" offset-xl10 color="red"
              >mdi-close-box-multiple</v-icon
            >
          </v-list-item>
        </v-card>
      </v-col>
      <v-col cols="12" sm="4" class="pa-1">
        <v-card tile class="mx-auto rounded-lg" elevation="8">
          <v-list-item three-line>
            <v-list-item-content>
              <div class="text-overline mb-4">Copemarket</div>
              <v-list-item-title class="text-h5 mb-1">
                {{ ListaDashboard.documentos_notas_creditos }}
              </v-list-item-title>
              <v-list-item-subtitle
                >Documentos Notas de Credito</v-list-item-subtitle
              >
            </v-list-item-content>

            <v-icon tile size="100" offset-xl10 color="primary"
              >mdi-restore</v-icon
            >
          </v-list-item>
        </v-card>
      </v-col>
    </v-row>

    <v-row no-gutters>
      <v-col cols="12" sm="4" class="pa-1">
        <v-card tile class="mx-auto rounded-lg" elevation="8">
          <v-list-item three-line>
            <v-list-item-content>
              <div class="text-overline mb-4">Copemarket</div>
              <v-list-item-title class="text-h5 mb-1">
                {{ ListaDashboard.documentos_fac_compra }}
              </v-list-item-title>
              <v-list-item-subtitle>
                Facturas de Compras Regis</v-list-item-subtitle
              >
            </v-list-item-content>

            <v-icon tile size="100" offset-xl10 color="cyan"
              >mdi-shopping</v-icon
            >
          </v-list-item>
        </v-card>
      </v-col>
      <v-col cols="12" sm="4" class="pa-1">
        <v-card tile class="mx-auto rounded-lg" elevation="8">
          <v-list-item three-line>
            <v-list-item-content>
              <div class="text-overline mb-4">Copemarket</div>
              <v-list-item-title class="text-h5 mb-1">
                {{ ListaDashboard.documentos_no_autorizados }}
              </v-list-item-title>
              <v-list-item-subtitle>
                Documentos No Autorizados</v-list-item-subtitle
              >
            </v-list-item-content>

            <v-icon tile size="100" offset-xl10 color="orange"
              >mdi-credit-card-plus</v-icon
            >
          </v-list-item>
        </v-card>
      </v-col>
      <v-col cols="12" sm="4" class="pa-1">
        <v-card tile class="mx-auto rounded-lg" elevation="8">
          <v-list-item three-line>
            <v-list-item-content>
              <div class="text-overline mb-4">Copemarket</div>
              <v-list-item-title class="text-h5 mb-1">
                {{ ListaDashboard.documentos_total_venta }}
              </v-list-item-title>
              <v-list-item-subtitle> Total en Dolares</v-list-item-subtitle>
            </v-list-item-content>

            <v-icon tile size="100" offset-xl10 color="green"
              >mdi-cash-multiple</v-icon
            >
          </v-list-item>
        </v-card>
      </v-col>
    </v-row>

    <v-row no-gutters>
      <v-col cols="12" sm="12" class="pa-1">
        <v-card
          outlined
          tile
          elevation="8"
          class="rounded-lg"
          :loader-height="5"
          :loading="loading"
        >
          <v-system-bar color="#005A70" dark class="white--text"
            >Facturas de Ventas</v-system-bar
          >

          <v-divider></v-divider>
          <v-card-text>
            <v-text-field
              v-model="searchBusquedaProductoventas"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
            <v-data-table
              :headers="CabeceraDocumentoVentas"
              :items="ListaDocumentoVentas"
              :search="searchBusquedaProductoventas"
              :items-per-page="10"
              :loading="loading"
              loading-text="Loading... La consulta puede demorar segun la fecha"
            >
            cobros
            <template v-slot:[`item.cobros`]="{ item }">
                <v-row>
                  
                    <div   v-for="(tag, index) in item.cobros"
                    :key="index"  >
                     
                       
                    {{ tag.forma_cobro }}

                    </div>
                
                </v-row>
              </template>

              <template v-slot:[`item.acciones`]="{ item }">
                <v-row>
                  <v-col cols="6">
                    <v-icon
                      color="indigo"
                      @click="GenerarModalProductosFacturaCompra(item)"
                      class="mr-2"
                    >
                      mdi-select-all
                    </v-icon>
                  </v-col>
                </v-row>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
     
    </v-row>

    <!-- <v-row no-gutters>
      <v-col cols="12" sm="12" class="pa-1">
        <v-card
          outlined
          tile
          elevation="8"
          class="rounded-lg"
          :loader-height="5"
          :loading="loading"
        >
          <v-system-bar color="#005A70" dark class="white--text"
            >Facturas de proveedores(Liquidacion de compra)</v-system-bar
          >
          

          <v-divider></v-divider>
          <v-card-text>
            <v-text-field
              v-model="searchBusquedaProductoCaduco"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
            <v-data-table
              :headers="CabeceraDocumentoCaduca"
              :items="ListaDocumentoCaduca"
              :search="searchBusquedaProductoCaduco"
              :items-per-page="30"
            >
              <template v-slot:[`item.acciones`]="{ item }">
                <v-row>
                  <v-col cols="6">
                    <v-icon
                      color="indigo"
                      @click="GenerarModalProductosFacturaCompra(item)"
                      class="mr-2"
                    >
                      mdi-select-all
                    </v-icon>
                  </v-col>
                </v-row>
              </template>
            </v-data-table>
          </v-card-text>
          <div style="min-height: 4px">
            <v-progress-linear
              striped
              color="deep-orange"
              rounded
              height="10"
              v-model="progresCompras.value"
              :active="progresCompras.show"
              :indeterminate="progresCompras.query"
              :query="true"
            ></v-progress-linear>
          </div>
        </v-card>
      </v-col>
    </v-row>
 -->

    <v-row no-gutters>
      <v-col cols="12" sm="12" class="pa-1">
        <v-card
          outlined
          tile
          elevation="8"
          class="rounded-lg"
          :loader-height="5"
          :loading="loading"
        >
          <v-system-bar color="#005A70" dark class="white--text"
            >Visualizacion de Cuadre de Caja</v-system-bar
          >
          

          <v-divider></v-divider>
          <v-card-text>
            <v-text-field
              v-model="searchBusquedaCuadreCaja"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
            <v-data-table
              :headers="CabeceraDocumentoCuadreCaja"
              :items="ListaDocumentoCuadreCaja"
              :search="searchBusquedaCuadreCaja"
              :items-per-page="30"
            >
              <template v-slot:[`item.acciones`]="{ item }">
                <v-row>
                  <v-col cols="6">
                    <v-icon
                      color="indigo"
                      @click="GenerarModalProductosFacturaCompra(item)"
                      class="mr-2"
                    >
                      mdi-select-all
                    </v-icon>
                  </v-col>
                </v-row>
              </template>
              <template v-slot:[`item.total_fisico`]="{ item }">
                <v-row>
                  <v-col cols="6">
                    <v-text-field
                      name="name"
                      label="label"
                      id="id"
                      
                    >{{ item.total_fisico  }}</v-text-field>
                   
                  </v-col>
                </v-row>
              </template>
            </v-data-table>
          </v-card-text>
          <div style="min-height: 4px">
            <v-progress-linear
              striped
              color="deep-orange"
              rounded
              height="10"
              v-model="progresCompras.value"
              :active="progresCompras.show"
              :indeterminate="progresCompras.query"
              :query="true"
            ></v-progress-linear>
          </div>
        </v-card>
      </v-col>
    </v-row>

    <v-row no-gutters>
      <v-col cols="12" sm="12"  >
        <v-card
          outlined
          tile
          elevation="8"
          class="rounded-lg"
          :loader-height="8"
          :loading="loadingChart"
          
        >
          <v-system-bar color="#005A70" dark class="white--text"
            >Total por locales</v-system-bar
          >
          <v-card-text>
            <v-btn
              class="ma-2"
              :loading="loadingChart"
              :disabled="loadingChart"
              color="success"
             @click="consultasValoresLocalesTodos()"
            >
            Generar Consulta
              <template v-slot:loader>
                <span>Cargando gráfico...</span>
              </template>
            </v-btn>
            <!-- <v-btn color="success" @click="consultasValoresLocalesTodos()"
              >Generar Consulta</v-btn
            > -->
          </v-card-text>

          <v-divider></v-divider>
          <v-card-text>
            <v-card-text>
            <canvas
              id="MejorLocalVentas"
              
            ></canvas>
          </v-card-text>
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
    </v-row> -->
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

    <!-- dialogo -->
    <v-row justify="center">
      <v-dialog v-model="ModelProductoCaducado" persistent max-width="600px">
        <v-card>
          <v-card-title primary-title> Detalles de Productos </v-card-title>
          <v-card-text>
            <v-data-table
              :headers="CabeceraProducto"
              :items="ListProductos"
              :items-per-page="30"
            >
            </v-data-table>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="ModelProductoCaducado = false"
            >
              Cerrar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>
  <script>
import { forEach } from "lodash";

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
          class: "yellow darken-2 white--text",
        },
        {
          text: "Fecha",
          value: "Fecha",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Cliente",
          value: "Nombre",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "MontoDolares",
          value: "MontoDolares",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "numerofactura",
          value: "numerofactura",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Vendedor",
          value: "Vendedor",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "DesProducto",
          value: "DesProducto",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Cantidad",
          value: "Cantidad",
          class: "yellow darken-2 white--text ",
        },

        {
          text: "Precio",
          value: "Precio",
          class: "yellow darken-2 white--text",
        },
        {
          text: "MontoDolaresDes",
          value: "MontoDolaresDes",
          class: "yellow darken-2 white--text",
        },
        {
          text: "Fecha Actualizacion",
          value: "created_at",
          class: "yellow darken-2 white--text",
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
      /** contifico */
      ListaBodegas: [],
      searchBusquedaProductoCaduco: "",
      CabeceraDocumentoCaduca: [
        {
          text: "fecha_creacion",
          align: "start",

          value: "fecha_creacion",
          class: "yellow darken-2 white--text",
        },
        {
          text: "fecha_emision",
          value: "fecha_emision",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "tipo_documento",
          value: "tipo_documento",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "tipo_registro",
          value: "tipo_registro",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "persona",
          value: "persona.razon_social",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "nombre_comercial",
          value: "persona.nombre_comercial",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "fecha_vencimiento",
          value: "fecha_vencimiento",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Acciones",
          value: "acciones",
          class: "yellow darken-2 white--text ",
        },
      ],
      ListaDocumentoCaduca: [],
      ListaConsultaDocumentoCaducidad: {
        fecha_inicial: 0,
        fecha_final: 0,
        bodega_id: 0,
      },
      ModelProductoCaducado: false,
      CabeceraProducto: [
        {
          text: "producto_nombre",
          align: "start",

          value: "producto_nombre",
          class: "yellow darken-2 white--text",
        },
        {
          text: "cantidad",
          value: "cantidad",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "precio",
          value: "precio",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "base_gravable",
          value: "base_gravable",
          class: "yellow darken-2 white--text ",
        },
      ],
      ListProductos: [],

      progresCompras: {
        value: 0,
        query: false,
        show: true,
        interval: 0,
      },
      // CabeceraDocumentoVentas: [
      //   {
      //     text: "documento",
      //     align: "start",

      //     value: "documento",
      //     class: "yellow darken-2 white--text",
      //   },
      //   {
      //     text: "tipo_documento",
      //     align: "start",

      //     value: "tipo_documento",
      //     class: "yellow darken-2 white--text",
      //   },
      //   {
      //     text: "fecha_creacion",
      //     align: "start",

      //     value: "fecha_creacion",
      //     class: "yellow darken-2 white--text",
      //   },
      //   {
      //     text: "fecha_emision",
      //     value: "fecha_emision",
      //     class: "yellow darken-2 white--text ",
      //   },
      //   {
      //     text: "tipo_documento",
      //     value: "tipo_documento",
      //     class: "yellow darken-2 white--text ",
      //   },
      //   {
      //     text: "tipo_registro",
      //     value: "tipo_registro",
      //     class: "yellow darken-2 white--text ",
      //   },
      //   {
      //     text: "persona",
      //     value: "persona.razon_social",
      //     class: "yellow darken-2 white--text ",
      //   },
      //   {
      //     text: "Vendedor",
      //     value: "vendedor.razon_social",
      //     class: "yellow darken-2 white--text ",
      //   },
      //   {
      //     text: "cedula",
      //     value: "persona.cedula",
      //     class: "yellow darken-2 white--text ",
      //   },
      //   {
      //     text: "adicional1_cliente",
      //     value: "persona.adicional1_cliente",
      //     class: "yellow darken-2 white--text ",
      //   },
      //   {
      //     text: "Acciones",
      //     value: "acciones",
      //     class: "yellow darken-2 white--text ",
      //   },
      // ],
      // ListaDocumentoVentas: [],
      searchBusquedaProductoventas: "",
      pagination: {
        current: 1,
        total: 0,
      },
      ListaDashboard: {
        documentos_generados: 0,
        documentos_anulados: 0,
        documentos_notas_creditos: 0,
        documentos_fac_compra: 0,
        documentos_no_autorizados: 0,
        documentos_total_venta: 0,
      },
      CabeceraDocumentoVentas: [
        {
          text: "documento",
          align: "start",

          value: "documento",
          class: "yellow darken-2 white--text",
        },
        {
          text: "tipo_documento",
          align: "start",

          value: "tipo_documento",
          class: "yellow darken-2 white--text",
        },
        {
          text: "fecha_creacion",
          align: "start",

          value: "fecha_creacion",
          class: "yellow darken-2 white--text",
        },
        {
          text: "fecha_emision",
          value: "fecha_emision",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "tipo_documento",
          value: "tipo_documento",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "tipo_registro",
          value: "tipo_registro",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Vendedor",
          value: "vendedor.razon_social",
          class: "blue darken-2 white--text ",
        },
        {
          text: "persona",
          value: "persona.razon_social",
          class: "yellow darken-2 white--text ",
        },
        
        {
          text: "cedula",
          value: "persona.cedula",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "tipo de Cobro",
          value: "cobros",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "adicional1_cliente",
          value: "persona.adicional1_cliente",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "total",
          value: "total",
          class: "success white--text ",
        },
        {
          text: "Acciones",
          value: "acciones",
          class: "yellow darken-2 white--text ",
        },
      ],
      ListaDocumentoVentas: [],
      //Producto mas Vendido copemarket
      chartProductoMasVendidoCopemarket: null,
      varCharProductoMasVendidoCopemarket: null,
      ListProductoMasVendidoECopemarket: [],
      ListValorProductoMasVendidoCopemarket: [],
      ListCantidadProductoMasVendidoCopemarket: [],
      LIstColorProductoMasVendidoCopemarket: [],

      //charts mejor vendedor por estacion

      chartMejorVendedorCopemarket: null,
      varCharMejorVendedorCopemarket: null,
      ListMejorVendedorECopemarket: [],
      ListValorMejorVendedorCopemarket: [],
      ListCantidadMejorVendedorCopemarket: [],
      LIstColorMejorVendedorCopemarket: [],

      //charts local mejor posicionado

      chartMejorLocalVentasCopemarket: null,
      varCharMejorLocalVentasCopemarket: null,
      ListMejorLocalVentasECopemarket: [],
      ListValorMejorLocalVentasCopemarket: [],
      ListCantidadMejorLocalVentasCopemarket: [],
      LIstColorMejorLocalVentasCopemarket: [],
      loadingChart : false,

      ///cuadre de caja 
      searchBusquedaCuadreCaja: "",
      CabeceraDocumentoCuadreCaja: [
        {
          text: "CAJERO",
          align: "start",

          value: "cajero",
          class: "yellow darken-2 white--text",
        },
        {
          text: "fecha_emision",
          value: "fecha_emision",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "TURNO",
          value: "turno",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Saldo Efectivo",
          value: "saldo_efectivo",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Efectivo",
          value: "monto_caja",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Tarjetas",
          value: "monto_tc",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "total ventas",
          value: "sum_total",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Total Fisico",
          value: "total_fisico",
          class: "yellow darken-2 white--text ",
        },

        {
          text: "Diferencia",
          value: "diferencia",
          class: "yellow darken-2 white--text ",
        },
        {
          text: "Acciones",
          value: "acciones",
          class: "yellow darken-2 white--text ",
        },
      ],
      ListaDocumentoCuadreCaja: [],
    };
  },
  mounted() {
    //  setInterval(  this.GenerarVentasDiariasFecha(), 8000);
    // this.GenerarTotalVentas();
    let that = this;
    this.consultasBodegasCentro();
    // this.sliderTimer = setInterval(function () {
    //   //  console.log("hola");

    //   that.consultasVentasLubriPorEstacion();
    // }, 4000);
    //this.GenerarToken();
  },
  methods: {
    GenerarModalProductosFacturaCompra(item) {
      // console.log("producto",item);
      this.ListProductos = item.detalles;
      this.ModelProductoCaducado = true;

      //   this.tarea.id = item.id;
      //   this.tarea.estacion = item.estacion;
      //   this.tarea.tipo_gasto = item.tipo_gasto;
      //   this.tarea.fecha_emision = item.fecha_emision;
      //   this.tarea.detalle = item.detalle;
      //   this.tarea.proveedor = parseInt(item.proveedor);
      //  // this.tarea.ruc = item.ruc;
      //   this.tarea.factura = item.factura;
      //   this.tarea.ruc = item.ruc;
      //   this.tarea.total = item.total;
    },
    /**contifinco fin */
    cargarProgres() {
      this.progresCompras.query = true;
      this.progresCompras.show = true;
      this.progresCompras.value = 0;

      setTimeout(() => {
        this.progresCompras.query = false;

        this.progresCompras.interval = setInterval(() => {
          // if (this.progres.value === 100) {
          // clearInterval(this.progres.interval)
          // this.show = false
          // return setTimeout(this.cargarProgres, 2000)
          // }
          this.progresCompras.value += 25;
        }, 1000);
      }, 2500);
    },
    consultasValoresLocalesTodos() {
      let that = this;
    

      this.ListaConsultaDocumentoCaducidad.fecha_inicial = this.fecha_buscar;
      this.ListaConsultaDocumentoCaducidad.fecha_final =
        this.fecha_buscar_hasta;
      // this.ListaConsultaDocumentoCaducidad.bodega_id= this.ListaBodegas;
      // this.cargarProgres();
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/GetDocumentoTodoLocales";

      if (this.chartMejorLocalVentasCopemarket != null) {
        this.chartMejorLocalVentasCopemarket.clear();
        this.chartMejorLocalVentasCopemarket.destroy();
      }

       

      this.ListMejorLocalVentasECopemarket = [];
      this.ListCantidadMejorLocalVentasCopemarket = [];
      this.LIstColorMejorLocalVentasCopemarket = [];

      let ListTotalVentasLocales = [];
      this.loadingChart = true;
      axios
        .post(url, this.ListaConsultaDocumentoCaducidad)
        .then((response) => {

          ListTotalVentasLocales = response.data.ListTotalVentasLocales;

          let ListaOrdenarVentas = [];
          let ListaOrdenarLLenarVentas = [];

          let con3 = 15;

          for (const iterator in ListTotalVentasLocales) {
            this.ListMejorLocalVentasECopemarket.push(
              ListTotalVentasLocales[iterator]["nombre"]
            );
            this.ListCantidadMejorLocalVentasCopemarket.push(
              ListTotalVentasLocales[iterator]["contenido"]
            );

            con3++;
            let n = (con3 * 0xfffff * 5000).toString(16);

            this.LIstColorMejorLocalVentasCopemarket.push(
              "#" + n.slice(0, 6)
            );
            
            
          }

          

          console.log("ListMejorLocalVentasECopemarket",ListTotalVentasLocales);
          console.log("ListMejorLocalVentasECopemarket",this.ListMejorLocalVentasECopemarket);
          console.log("ListCantidadMejorLocalVentasCopemarket",this.ListCantidadMejorLocalVentasCopemarket);
          console.log("LIstColorMejorLocalVentasCopemarket",this.LIstColorMejorLocalVentasCopemarket);
         
         this.totalesProductoVentasLocales();
          this.loadingChart = false;
          //  that.valor = response.data.data;
        })
        .catch((error) => {
          this.loadingChart = false;
          console.log("error del sistema" + error);
          // clearInterval(this.progresCompras.interval);
        });
    },

    totalesProductoVentasLocales() {
      var dsValoresCantidad = {
        label: "Total en Cantidad",
        data: this.ListCantidadMejorLocalVentasCopemarket,
        backgroundColor: this.LIstColorMejorLocalVentasCopemarket,
        borderColor: "white",
        borderWidth: 2,
        fill: true,
      };

      var totalesData = {
        labels: this.ListMejorLocalVentasECopemarket,
        datasets: [dsValoresCantidad],
      };

      var chartOptions = {
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
      };

      this.varCharMejorLocalVentasCopemarket = document
        .getElementById("MejorLocalVentas")
        .getContext("2d");

      this.chartMejorLocalVentasCopemarket = new Chart(
        this.varCharMejorLocalVentasCopemarket,
        {
          type: "bar",

          data: totalesData,
          options: chartOptions,
          //options: chartOptions
        }
      );
    },


    consultasFechaExpiracion() {
      let that = this;
      this.cargarProgres();

      this.ListaConsultaDocumentoCaducidad.fecha_inicial = this.fecha_buscar;
      this.ListaConsultaDocumentoCaducidad.fecha_final =
        this.fecha_buscar_hasta;
      // this.ListaConsultaDocumentoCaducidad.bodega_id= this.ListaBodegas;
      // this.cargarProgres();
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/GetDocumentoCompraAdmin";

      if (this.chartProductoMasVendidoCopemarket != null) {
        this.chartProductoMasVendidoCopemarket.clear();
        this.chartProductoMasVendidoCopemarket.destroy();
      }

      if (this.chartMejorVendedorCopemarket != null) {
        this.chartMejorVendedorCopemarket.clear();
        this.chartMejorVendedorCopemarket.destroy();
      }

      this.ListaDocumentoCaduca = [];
      this.ListaDocumentoVentas = [];

      this.ListProductoMasVendidoECopemarket = [];
      this.ListCantidadProductoMasVendidoCopemarket = [];
      this.LIstColorProductoMasVendidoCopemarket = [];

      this.ListMejorVendedorECopemarket = [];
      this.ListCantidadMejorVendedorCopemarket = [];
      this.LIstColorMejorVendedorCopemarket = [];

      this.ListaDocumentoCuadreCaja=[];

      this.ListaDashboard = {
        documentos_generados: 0,
        documentos_anulados: 0,
        documentos_notas_creditos: 0,
        documentos_fac_compra: 0,
        documentos_no_autorizados: 0,
        documentos_total_venta: 0,
      };

      let ListaProductoMejorVendido = [];
      let ListaMejorVendedorCopem = [];

      let ListDocumentoCuadreCajaArrayPrimer = [];
      let ListDocumentoCuadreCajaArraySegundo = [];
      let ListDocumentoCuadreCajaArrayTercer = [];
      let ListDocumentoCuadreCajaArrayTercerDos = [];

      this.loading = true;
      axios
        .post(url, this.ListaConsultaDocumentoCaducidad)
        .then((response) => {
          this.ListaDocumentoCaduca = response.data.compra;
          this.ListaDocumentoVentas = response.data.ventas;
          this.ListaDashboard.documentos_generados =
            response.data.documentos_generados;
          this.ListaDashboard.documentos_anulados =
            response.data.documentos_anulados;
          this.ListaDashboard.documentos_notas_creditos =
            response.data.documentos_notas_creditos;
          this.ListaDashboard.documentos_fac_compra =
            response.data.documentos_fac_compra;

          this.ListaDashboard.documentos_no_autorizados =
            response.data.documentos_no_autorizados;

          this.ListaDashboard.documentos_total_venta =
            response.data.documentos_total_venta;

          ListaProductoMejorVendido = response.data.lista_vendido_produc_suma2;
          // organizamos el arreglo
          let ListaOrdenar = [];
          let ListaOrdenarLLenar = [];

          for (const iterator in ListaProductoMejorVendido) {
            let objeto = {};
            objeto.producto_nombre =
              ListaProductoMejorVendido[iterator]["producto_nombre"];
            objeto.sum_cantidad =
              ListaProductoMejorVendido[iterator]["sum_cantidad"];
            ListaOrdenar.push(objeto);
          }

          ListaOrdenarLLenar = ListaOrdenar.sort((a, b) => {
            return b.sum_cantidad - a.sum_cantidad;
          });

          let con3 = 15;
          for (const iterator in ListaOrdenarLLenar) {
            this.ListProductoMasVendidoECopemarket.push(
              ListaOrdenarLLenar[iterator]["producto_nombre"]
            );
            this.ListCantidadProductoMasVendidoCopemarket.push(
              ListaOrdenarLLenar[iterator]["sum_cantidad"]
            );

            con3++;
            let n = (con3 * 0xfffff * 5000).toString(16);

            this.LIstColorProductoMasVendidoCopemarket.push(
              "#" + n.slice(0, 6)
            );
          }

          ///mejor vendedir charts
          //mejor vendedor
          ListaMejorVendedorCopem = response.data.lista_mejor_vendedor;

          // ListaProductoMejorVendido = ListaProductoMejorVendido.sort(function(a, b){return a - b});

          let ListaOrdenarMejorVendedor = [];
          let ListaOrdenarLLenarMejorVendedor = [];

          for (const iterator in ListaMejorVendedorCopem) {
            let objeto = {};
            objeto.vendedor =
              ListaMejorVendedorCopem[iterator]["arregl"].razon_social;
            objeto.sum_total = ListaMejorVendedorCopem[iterator]["sum_total"];
            ListaOrdenarMejorVendedor.push(objeto);
          }

          ListaOrdenarLLenarMejorVendedor = ListaOrdenarMejorVendedor.sort(
            (a, b) => {
              return b.sum_total - a.sum_total;
            }
          );

          let con4 = 15;
          for (let iterator of ListaOrdenarLLenarMejorVendedor) {
            this.ListMejorVendedorECopemarket.push(iterator["vendedor"]);
            this.ListCantidadMejorVendedorCopemarket.push(
              iterator["sum_total"]
            );

            con4++;
            let n = (con4 * 0xfffff * 5000).toString(16);

            this.LIstColorMejorVendedorCopemarket.push("#" + n.slice(0, 6));
          }

          // console.log(
          //   "ListaOrdenarLLenarMejorVendedor",
          //   ListaOrdenarLLenarMejorVendedor
          // );

          // console.log(
          //   "ListMejorVendedorECopemarket",
          //   this.ListMejorVendedorECopemarket
          // );
          // console.log(
          //   "ListCantidadMejorVendedorCopemarket",
          //   this.ListCantidadMejorVendedorCopemarket
          // );
          // console.log(
          //   "LIstColorMejorVendedorCopemarket",
          //   this.LIstColorMejorVendedorCopemarket
          // );
          ///arqueo de caja
          ListDocumentoCuadreCajaArrayPrimer = response.data.ListaArqueoCaja;
          ListDocumentoCuadreCajaArraySegundo = response.data.ListaMejorArqueCajaSegundo;
          ListDocumentoCuadreCajaArrayTercer = response.data.ListaMejorArqueCajaTercero;
          ListDocumentoCuadreCajaArrayTercerDos = response.data.ListaMejorArqueCajaEnviarTercerDos;
         //primer turno
          for (const iterator in ListDocumentoCuadreCajaArrayPrimer) {
            let objeto = {};
            objeto.id_cajero =
            ListDocumentoCuadreCajaArrayPrimer[iterator]["id"];
            objeto.cajero =
              ListDocumentoCuadreCajaArrayPrimer[iterator]["vendedor"];
            objeto.fecha_emision =
              ListDocumentoCuadreCajaArrayPrimer[iterator]["fecha_emision"];
              objeto.turno =
              ListDocumentoCuadreCajaArrayPrimer[iterator]["TURNO_1"];
              objeto.saldo_efectivo = 60;
              objeto.monto_caja =
              ListDocumentoCuadreCajaArrayPrimer[iterator]["monto_caja"];
              objeto.monto_tc =
              ListDocumentoCuadreCajaArrayPrimer[iterator]["monto_tc"];
              objeto.sum_total =
              ListDocumentoCuadreCajaArrayPrimer[iterator]["sum_total"];
              objeto.total_fisico = 0;
              objeto.diferencia = 0;

            this.ListaDocumentoCuadreCaja.push(objeto);
          }

           //segundo turno
           for (const iterator in ListDocumentoCuadreCajaArraySegundo) {
            let objeto = {};
            objeto.id_cajero =
            ListDocumentoCuadreCajaArraySegundo[iterator]["id"];
            objeto.cajero =
              ListDocumentoCuadreCajaArraySegundo[iterator]["vendedor"];
            objeto.fecha_emision =
              ListDocumentoCuadreCajaArraySegundo[iterator]["fecha_emision"];
              objeto.turno =
              ListDocumentoCuadreCajaArraySegundo[iterator]["TURNO_2"];
              objeto.saldo_efectivo = 60;
              objeto.monto_caja =
              ListDocumentoCuadreCajaArraySegundo[iterator]["monto_caja"];
              objeto.monto_tc =
              ListDocumentoCuadreCajaArraySegundo[iterator]["monto_tc"];
              objeto.sum_total =
              ListDocumentoCuadreCajaArraySegundo[iterator]["sum_total"];
              objeto.total_fisico = 0;
              objeto.diferencia = 0;

            this.ListaDocumentoCuadreCaja.push(objeto);
          }


          //tercer turno
          for (const iterator in ListDocumentoCuadreCajaArrayTercer) {
            let objeto = {};
            objeto.id_cajero =
            ListDocumentoCuadreCajaArrayTercer[iterator]["id"];
            objeto.cajero =
              ListDocumentoCuadreCajaArrayTercer[iterator]["vendedor"];
            objeto.fecha_emision =
              ListDocumentoCuadreCajaArrayTercer[iterator]["fecha_emision"];
              objeto.turno =
              ListDocumentoCuadreCajaArrayTercer[iterator]["TURNO_3"];
              objeto.saldo_efectivo = 60;
              objeto.monto_caja =
              ListDocumentoCuadreCajaArrayTercer[iterator]["monto_caja"];
              objeto.monto_tc =
              ListDocumentoCuadreCajaArrayTercer[iterator]["monto_tc"];
              objeto.sum_total =
              ListDocumentoCuadreCajaArrayTercer[iterator]["sum_total"];
              objeto.total_fisico = 0;
              objeto.diferencia = 0;

            this.ListaDocumentoCuadreCaja.push(objeto);
          }

           //tercer turno dos
           for (const iterator in ListDocumentoCuadreCajaArrayTercerDos) {
            let objeto = {};
            objeto.id_cajero =
            ListDocumentoCuadreCajaArrayTercerDos[iterator]["id"];
            objeto.cajero =
              ListDocumentoCuadreCajaArrayTercerDos[iterator]["vendedor"];
            objeto.fecha_emision =
              ListDocumentoCuadreCajaArrayTercerDos[iterator]["fecha_emision"];
              objeto.turno =
              ListDocumentoCuadreCajaArrayTercerDos[iterator]["TURNO_3_2"];
              objeto.saldo_efectivo = 60;
              objeto.monto_caja =
              ListDocumentoCuadreCajaArrayTercerDos[iterator]["monto_caja"];
              objeto.monto_tc =
              ListDocumentoCuadreCajaArrayTercerDos[iterator]["monto_tc"];
              objeto.sum_total =
              ListDocumentoCuadreCajaArrayTercerDos[iterator]["sum_total"];
              objeto.total_fisico = 0;
              objeto.diferencia = 0;

            this.ListaDocumentoCuadreCaja.push(objeto);
          }

 



          this.totalesProductoMasCopemarket();
          this.totalesMejorVendedorCopemarket();
         // this.consultasValoresLocalesTodos();
          this.loading = false;
          //  that.valor = response.data.data;
        })
        .catch((error) => {
          this.loading = false;
          console.log("error del sistema" + error);
          // clearInterval(this.progresCompras.interval);
        });
    },

    totalesProductoMasCopemarket() {
      var dsValoresCantidad = {
        label: "Total en Cantidad",
        data: this.ListCantidadProductoMasVendidoCopemarket,
        backgroundColor: this.LIstColorProductoMasVendidoCopemarket,
        borderColor: "white",
        borderWidth: 2,
        fill: true,
      };

      var totalesData = {
        labels: this.ListProductoMasVendidoECopemarket,
        datasets: [dsValoresCantidad],
      };

      var chartOptions = {
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
      };

      this.varCharProductoMasVendidoCopemarket = document
        .getElementById("VentasPorductoMasVendidoCopemarket")
        .getContext("2d");

      this.chartProductoMasVendidoCopemarket = new Chart(
        this.varCharProductoMasVendidoCopemarket,
        {
          type: "horizontalBar",

          data: totalesData,
          options: chartOptions,
          //options: chartOptions
        }
      );
    },

    totalesMejorVendedorCopemarket() {
      var dsValoresCantidad = {
        label: "Total en Cantidad",
        data: this.ListCantidadMejorVendedorCopemarket,
        backgroundColor: this.LIstColorMejorVendedorCopemarket,
        borderColor: "white",
        borderWidth: 2,
        fill: true,
      };

      var totalesData = {
        labels: this.ListMejorVendedorECopemarket,
        datasets: [dsValoresCantidad],
      };

      var chartOptions = {
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
      };

      this.varCharMejorVendedorCopemarket = document
        .getElementById("MejorVendedorCopemarket")
        .getContext("2d");

      this.chartMejorVendedorCopemarket = new Chart(
        this.varCharMejorVendedorCopemarket,
        {
          type: "horizontalBar",

          data: totalesData,
          options: chartOptions,
          //options: chartOptions
        }
      );
    },

    consultasBodegasCentro() {
      let that = this;
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/GetConsultarBodegas";
      let ListEstacionesRecorrer = [];
      this.ListaBodegas = [];
      axios
        .get(url)
        .then((response) => {
          this.ListaBodegas = response.data.consulta;

          //  that.valor = response.data.data;
        })
        .catch((error) => {
          console.log("error del sistema" + error);
        });
    },
    GetCentrosCostos() {
      let url = this.$store.state.ApiContifico + "contabilidad/centro-costo/";

      let _Lista = [];
      const headers = {
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Methods": "GET, PUT, POST, DELETE, OPTIONS",
        "Content-Type": "application/json",
        Authorization: `YlL5LnVsxErqwus5bWJB3Uv8QUR8gVHHpkMvrVjqW3w`,
      };

      axios
        .get(url, { headers: headers })
        .then((response) => {
          console.log("api retorno", response.data);
          let objeto = {};
        })
        .catch((error) => {
          console.log(error);
          // let objeto = [];
          // objeto = Object.values(error.response.data.errors);
          // for (
          //     let index = 0;
          //     index < objeto.length;
          //     index++
          // ) {
          //     this.mensajeAler(objeto[index][0], false);
          // }
        });
    },

    /**contifinco fin */
    generar() {},

    Consultaanio(id) {
      this.ListaConsultaDocumentoCaducidad.bodega_id = id.id;

      //console.log("anio click",this.ListaConsultaDocumentoCaducidad.bodega_id);

      // this.consultasVentasLubriPorEstacion();
    },
    ConsultaMes(id) {
      this.mesItem = id;
      this.consultasVentasLubriPorEstacion();
    },
    // ConsultaEstacionItem(id) {
    //   this.EstacionItem = id;
    //   this.consultasVentasLubriPorEstacion();
    // },
 
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
<style>
.custom-loader {
  animation: loader 1s infinite;
  display: flex;
}
@-moz-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-webkit-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-o-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
  