<template>
  <div>
    <v-row>
      <v-col cols="12">
        <v-card :loading="loading" elevation="8">
          <template slot="progress">
            <v-progress-linear
              color="deep-purple"
              height="10"
              indeterminate
            ></v-progress-linear>
          </template>
          <v-card-title>Ingreso de Blindado </v-card-title>
          <v-divider class="mx-4"></v-divider>

          <v-divider></v-divider>

          <v-card-text>
            <v-btn color="success" @click="nuevo()">Agregar Gastos</v-btn>
            <br />
            <v-card-title>
              <v-text-field
                v-model="BusquedaCabecera"
                append-icon="mdi-magnify"
                label="Busqueda de Tareas"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
            <v-data-table
              :headers="Cabeceratareas"
              :items="ListaTareas"
              :search="BusquedaCabecera"
              class="elevation-1"
            >
              <template v-slot:[`item.acciones`]="{ item }">
              
                <v-icon
                  color="indigo"
                  @click="GenerarModalSeguimientoVisulizar(item)"
                  class="mr-2"
                >
                mdi-pencil
                </v-icon>
               
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <!-- empieza el dialogo -->
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-card>
            <v-card-title>
              <span class="text-h5">Ingreso de Blindado</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-select
                      :items="ListEstaciones"
                      v-model="tarea.estacion"
                      item-text="nombre"
                      item-value="id"
                      persistent-hint
                      single-line
                      label="Estacioness"
                    ></v-select>
                  </v-col>
                  
                  <v-col cols="12" sm="6">
                    <label for="">Fecha emisión: </label>
                    <br>
                    <input type="date" v-model="tarea.fecha_emision" />
                  </v-col>
                  
                  <v-col cols="12" sm="6">
                    <v-text-field
                      label="Valor"
                      hint="Valor"
                      v-model="tarea.valor"
                      
                      type="number"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12"  sm="6">
                    <v-text-field
                      label="Deposito Real"
                      hint="Deposito Real"
                      v-model="tarea.deposito_real"
                      
                      type="number"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12"  sm="6">
                    <v-text-field
                      label="Valor Enviarse"
                      hint="Valor Enviarse"
                      v-model="tarea.valor_enviarse"
                      
                      type="number"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field
                      label="Diferencia"
                      hint="Diferencia"
                      v-model="tarea.diferencia"
                      type="number"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field
                      label="Detalle"
                      hint="Detalle"
                      v-model="tarea.detalle"
                    
                      required
                    ></v-text-field>
                  </v-col>
                
                 
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="dialog = false">
                Cerrar
              </v-btn>

              <v-btn color="blue darken-1" text @click="grabarTarea()">
                Grabar Gastos
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-dialog>
    </v-row>
    <!-- dialogo de seguimiento -->

    <!-- empieza el dialogo -->
    
    <!-- fin del dialogo -->
    <!-- empieza el dialogo seguimiento -->
    
    <!-- fin del dialogo -->

    <v-row>
      <v-col cols="12"> </v-col>
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
    <!-- finaliza el dialogo -->
  </div>
  <!-- aqui termina :v -->
</template>

<script>
const CLIENT_ID =
  "857376504585-qbak552vvvegamk3nmvkuceqjtuhbhsl.apps.googleusercontent.com";
const API_KEY = "AIzaSyCvsm3qol8_KS0q20cMFF7Lab6tSC3jl0s";
const DISCOVERY_DOCS = [
  "https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest",
];
const SCOPES = "https://www.googleapis.com/auth/calendar";
export default {
  data() {
    return {
      tab: null,
      loading: false,
      //DatosTareas
      ModelPrioridad: null,
      Listprioridad: [
        {
          id: "1",
          text: "Alta",
        },
        {
          id: "2",
          text: "Media",
        },
        {
          id: "3",
          text: "Baja",
        },
      ],
      Cabeceratareas: [
        {
          text: "Id",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "Estacion", value: "des_estacion", width: "25%" },
        { text: "fecha_emision", value: "fecha_emision", width: "15%" },

        { text: "Valor", value: "valor", width: "25%" },
       
        { text: "deposito_real", value: "deposito_real", width: "15%" },

        { text: "valor_enviarse", value: "valor_enviarse", width: "20%" },
        { text: "diferencia", value: "diferencia", width: "15%" },
        { text: "detalle", value: "detalle", width: "15%" },

        { text: "Acciones", value: "acciones", width: "15%" },
      ],
      ListaTareas: [],
      ListEstaciones: [],
      ListaTareasSeguimientoV: [],
      ListaProveedores: [],
      BusquedaCabecera: "",
      //validacion
      valid: false,
      allowSpaces: false,
      match: "Foobar",
      max: 1,
      model: "Foobar",
      showFinalizar: false,
      // mensajes de alerta
      snackbar: false,
      text: "",
      timeout: 4000,
      color: "purple darken-4",
      icono: "mdi-checkbox-marked",
      ///
      modelEmpresa: null,
      itemsEmpresa: [],
      searchEmpresa: null,

      modelPrincipal: null,
      itemsPrincipal: [],
      searchPrincial: null,

      ///
      modelEmpresaFiltro: null,
      itemsEmpresaFiltro: [],
      searchEmpresaFiltro: null,

      //model para correos y persona
      modelAdicional: [],
      itemsAdicional: [],
      searchAdicional: null,
      // arreglo de tarea
      tarea: {
        id: 0,
        estacion: 0,
        fecha_emision: 0,
        valor: 0,
        deposito_real: 0,
        valor_enviarse: 0,
        diferencia: "",
        detalle: "",
      },
      
      dates: ["2023-01-10", "2023-01-20"],
      dialog: false,
      dialogSeguimiento: false,
      dialogSeguimientoVisualizar: false,
      nameRules: [
        (v) => !!v || "El campo es requerido",
        (v) => (v && v.length <= 100) || "Name must be less than 10 characters",
      ],
      nameRulesCmb: [
        (v) => !!v || "El campo es requerido",
        // v => ( v == null) || 'Name must be less than 10 characters',
      ],
      valor: [],
      cont: 0,
      color_avatar: "",
      authorized: false,
      tokenClient: undefined,
      gapiInited: false,
      gisInited: false,
      items: null,
      /*** Arreglo de google */
      event: {
        summary: "",
        location: "",
        description: "",
        start: {
          dateTime: "",
          timeZone: "America/Bogota",
        },
        end: {
          dateTime: "2023-02-23T10:00:00-07:00",
          timeZone: "America/Bogota",
        },
        recurrence: ["RRULE:FREQ=DAILY;COUNT=2"],
        attendees: [],
        reminders: {
          useDefault: false,
          overrides: [
            { method: "email", minutes: 24 * 60 },
            { method: "popup", minutes: 10 },
          ],
        },
      },
      ListaCorreo: [],
      MsjAutorizacion: "",
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
      ListTipoGasto: [ ],
      ListProducto: [
        { id: 1, nombre: "DIESEL PREMIUM" },
        { id: 2, nombre: "EXTRA CON ETANOL" },
        { id: 3, nombre: "SUPER PREMIUM 95" },
      ],
    };
  },
  created() {
    // this.api = gapi;
    // this.gapiLoaded();
    // this.gisLoaded();
  },
  mounted() {
    this.consultasEstaciones();
    this.consultasProveedores();
    this.consultasTareas();
    this.consultasTiposGastos();
    //  google.accounts.id.prompt(); // also display the One Tap dialog
    // this.consultasTotales();
    // this.consultasDashboard();
    // this.totalesCirugia();
  },
  methods: {
    consultasTiposGastos() {
      let that = this;
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/ConsultarTiposGasto";
      let ListEstacionesRecorrer = [];
      this.ListTipoGasto = [];
      axios
        .get(url)
        .then((response) => {
          this.ListTipoGasto = response.data.consulta;
         
        })
        .catch((error) => {
          console.log("error del sistema" + error);
        });
    },
    consultaRucProveedor(){
      
      var resultado = this.ListaProveedores.find(
        (producto) => producto.id === this.tarea.proveedor
      );
     
      this.tarea.ruc = resultado.ruc;
    },
    consultasProveedores() {
      let that = this;
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/ConsultarProveedor";
      let ListEstacionesRecorrer = [];
      this.ListaProveedores = [];
      axios
        .get(url)
        .then((response) => {
          this.ListaProveedores = response.data.consulta;
 
          //  that.valor = response.data.data;

        
        })
        .catch((error) => {
          console.log("error del sistema" + error);
        });
    },
    nuevo(){
        this.dialog = true;
        this.tarea= {
        id: 0,
        estacion: 0,
        tipo_gasto: 0,
        fecha_emision: 0,
        detalle: "",
        proveedor: "",
        ruc: "",
        factura: 0,
        total: 0,
      };
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
         // console.log("ListaEstaciones1", ListEstacionesRecorrer);
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
    consultarExcel(value) {
      // console.log(value);

      window.open(
        this.$store.getters.getRuta +
          "/modulos/admision/paciente/generacionExcel"
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

    consultasPersonas() {
      let that = this;
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/cargar_persona/1";

      axios
        .get(url)
        .then((response) => {
          this.itemsPrincipal = response.data.persona;
        })
        .catch((error) => {
          //Errores de validación
        });
    },
    consultasEmpresas() {
      let that = this;
      let url =
        this.$store.getters.getRuta + "/modulos/admision/paciente/GetEmpresa";

      axios
        .get(url)
        .then((response) => {
          this.itemsEmpresa = response.data.listasEmpresas;
        })
        .catch((error) => {
          //Errores de validación
        });
    },
    consultasEmpresasFiltro() {
      let that = this;
      let url =
        this.$store.getters.getRuta + "/modulos/admision/paciente/GetEmpresa";

      axios
        .get(url)
        .then((response) => {
          this.itemsEmpresaFiltro = response.data.listasEmpresas;
        })
        .catch((error) => {
          //Errores de validación
        });
    },
    consultasPersonasInvolucradas() {
      let that = this;
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/cargar_persona/1";

      axios
        .get(url)
        .then((response) => {
          this.itemsAdicional = response.data.persona;
        })
        .catch((error) => {
          //Errores de validación
        });
    },
    grabarTarea() {
      //s this.handleCreateEvent();
      //   return;
      if (this.tarea.estacion == "" || this.tarea.estacion == 0) {
        this.$swal("Copedesa!!!", "Seleccione la estación", "error");
        return;
      }

       
      if (this.tarea.fecha_emision == "" || this.tarea.fecha_emision == 0) {
        this.$swal("Copedesa!!!", "Seleccione la fecha emisión", "error");
        return;
      }

      if (this.tarea.diferencia == "" || this.tarea.diferencia == 0) {
        this.$swal("Copedesa!!!", "Ingrese la diferencia", "error");
        return;
      }

      if (this.tarea.detalle == "" || this.tarea.detalle == 0) {
        this.$swal("Copedesa!!!", "Ingrese el detalle", "error");
        return;
      }

      if (this.tarea.valor == "" || this.tarea.valor == 0) {
        this.$swal("Copedesa!!!", "Ingrese el valor", "error");
        return;
      }

      if (this.tarea.deposito_real == "" || this.tarea.deposito_real == 0) {
        this.$swal("Copedesa!!!", "Ingrese el deposito_real", "error");
        return;
      }

      if (this.tarea.valor_enviarse == "" || this.tarea.valor_enviarse == 0) {
        this.$swal("Copedesa!!!", "Ingrese el valor_enviarse", "error");
        return;
      }

      

      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/createBlindado";

      
      // return;

      //this.desproducto = tarea.producto.id:

      axios
        .post(url, this.tarea)
        .then((response) => {
          console.log(response.data.data);
          this.$swal("Fuelcorp!!!", response.data.mensaje, "success");
          // this.mensajeAler("Tarea registrada con éxito", true);
          this.dialog = false;
          this.consultasTareas();
          this.tarea= {
                id: 0,
                estacion: 0,
                fecha_emision: 0,
                valor: 0,
                deposito_real: 0,
                valor_enviarse: 0,
                diferencia: "",
                detalle: "",
            };
          //  this.handleCreateEvent();
          // this.itemsAdicional = response.data.data;
        })
        .catch((error) => {
          let objeto = [];
          objeto = Object.values(error.response.data.errors);
          for (let index = 0; index < objeto.length; index++) {
            this.mensajeAler(objeto[index][0], false);
          }
        });
    },

    grabarHorario() {
      // const CLIENT_ID = '145697386104-42tuvofm93tdf19jlggcfl9k32anq5vp.apps.googleusercontent.com';
      //   const API_KEY = 'AIzaSyDLIrLbOmahI1oKFeYk4BaOfo9csPGEFwU';

      //   // Discovery doc URL for APIs used by the quickstart
      //   const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';

      //   // Authorization scopes required by the API; multiple scopes can be
      //   // included, separated by spaces.
      //   const SCOPES = 'https://www.googleapis.com/auth/calendar';

      let gapiInited = false;
      let gisInited = false;
      this.gisLoaded();
      const event = {
        summary: "Google I/O 2015",
        location: "800 Howard St., San Francisco, CA 94103",
        description: "A chance to hear more about Google's developer products.",
        start: {
          dateTime: "2023-02-18T09:00:00-07:00",
          timeZone: "America/Bogota",
        },
        end: {
          dateTime: "2023-02-18T17:00:00-07:00",
          timeZone: "America/Bogota",
        },
        recurrence: ["RRULE:FREQ=DAILY;COUNT=2"],
        attendees: [
          { email: "cramirez@operoil.com" },
          { email: "carlosrami1989@gmail.com" },
        ],
        reminders: {
          useDefault: false,
          overrides: [
            { method: "email", minutes: 24 * 60 },
            { method: "popup", minutes: 10 },
          ],
        },
      };

      const request = gapi.client.calendar.events.insert({
        calendarId: "primary",
        resource: event,
      });
      request.execute(function (event) {
        // appendPre('Event created: ' + event.htmlLink);
      });
    },

    grabarSeguimientoTarea() {
      // console.log(this.$refs.formSeguimiento.validate());
      if (this.$refs.formSeguimiento.validate()) {
        let url =
          this.$store.getters.getRuta +
          "/modulos/admision/paciente/ConsultaGuias";

        // console.log(this.tarea);
        // return;

        axios
          .post(url, this.SeguimientoTarea)
          .then((response) => {
            console.log(response.data.data);
            this.mensajeAler("Seguimiento registrado con éxito", true);
            this.dialogSeguimiento = false;
            this.consultasTareas();
            // this.itemsAdicional = response.data.data;
          })
          .catch((error) => {
            let objeto = [];
            objeto = Object.values(error.response.data.errors);
            for (let index = 0; index < objeto.length; index++) {
              this.mensajeAler(objeto[index][0], false);
            }
          });
      }
    },
    consultasTareas() {
      let that = this;
      let url = "/modulos/admision/paciente/ConsultarBlindado";

      axios
        .get(url)
        .then((response) => {
          //   this.ListaTareas = response.data.listasTareas.sort(
          //     (x, y) => y.porcentaje - x.porcentaje
          //   );
          this.ListaTareas = response.data.consulta;
        })
        .catch((error) => {
          //Errores de validación
        });
    },
    //GetTareasNormales
    getColor(porcentaje) {
      if (porcentaje == 1) return "red";
      else if (porcentaje == 2) return "orange";
      else if (porcentaje == 3) return "green";
    },

    getIcon(value) {
      if (value == 1) return "mdi-fire";
      else if (value == 2) return "mdi-minus-circle";
      else if (value == 3) return "mdi-coffee";
    },
  
    GenerarModalSeguimientoVisulizar(item) {
      console.log("modal",item);
        this.dialog = true;  
        this.tarea.id = item.id;
        this.tarea.estacion = item.estacion;
        this.tarea.valor = item.valor;
        this.tarea.fecha_emision = item.fecha_emision;
        this.tarea.detalle = item.detalle;
        this.tarea.proveedor = parseInt(item.proveedor);
       // this.tarea.ruc = item.ruc;
        this.tarea.deposito_real = item.deposito_real;
        this.tarea.valor_enviarse = item.valor_enviarse;
        this.tarea.diferencia = item.diferencia;
         
      
    },
    CerrarModal() {
      this.dialogSeguimientoVisualizar = false;
      this.cont = 0;
      this.color_avatar = "";
    },
    GetCadena(value) {
      let arr = value.split(" ");
      let A = arr[0].charAt(0).toUpperCase();
      let B = arr[1].charAt(0).toUpperCase();

      return A + B;
    },

    GetCadenaColor(value) {
      // return "blue" ;
      var _color1 = "";
      var _color2 = value;
      //    var _color = ""
      if (value == 1) {
        this.cont = 1;
        return "green";
        this.color;
      } else {
        return "blue";
      }
    },
    onSignIn(googleUser) {
      var profile = googleUser.getBasicProfile();
      console.log(profile);
    },
    /**
     *  On load, called to load the auth2 library and API client library.
     */
    /**
     * Callback after api.js is loaded.
     */
    gapiLoaded() {
      this.api.load("client", this.initializeGapiClient);
    },

    /**
     * Callback after the API client is loaded. Loads the
     * discovery doc to initialize the API.
     */
    async initializeGapiClient() {
      await this.api.client.init({
        apiKey: API_KEY,
        discoveryDocs: DISCOVERY_DOCS,
      });
      this.gapiInited = true;
      this.maybeEnableButtons();
    },

    /**
     * Callback after Google Identity Services are loaded.
     */
    gisLoaded() {
      this.tokenClient = google.accounts.oauth2.initTokenClient({
        client_id: CLIENT_ID,
        scope: SCOPES,
        callback: "", // defined later
      });
      this.gisInited = true;
      this.maybeEnableButtons();
    },

    /**
     *  Sign in the user upon button click.
     */
    handleAuthClick() {
      this.tokenClient.callback = async (resp) => {
        if (resp.error !== undefined) {
          throw resp;
        }
        this.authorized = true;
        await this.listUpcomingEvents();
      };

      if (gapi.client.getToken() === null) {
        // Prompt the user to select a Google Account and ask for consent to share their data
        // when establishing a new session.
        this.tokenClient.requestAccessToken({ prompt: "consent" });
      } else {
        // Skip display of account chooser and consent dialog for an existing session.
        this.tokenClient.requestAccessToken({ prompt: "" });
      }
    },

    /**
     * Print the summary and start datetime/date of the next ten events in
     * the authorized user's calendar. If no events are found an
     * appropriate message is printed.
     */
    async listUpcomingEvents() {
      let response;
      try {
        const request = {
          calendarId: "primary",
          timeMin: new Date().toISOString(),
          showDeleted: false,
          singleEvents: true,
          maxResults: 10,
          orderBy: "startTime",
        };
        response = await this.api.client.calendar.events.list(request);
      } catch (err) {
        document.getElementById("content").innerText = err.message;
        return;
      }

      const events = response.result.items;
      if (!events || events.length == 0) {
        document.getElementById("content").innerText = "No events found.";
        return;
      }
      // Flatten to string to display
      const output = events.reduce(
        (str, event) =>
          `${str}${event.summary} (${
            event.start.dateTime || event.start.date
          })\n`,
        "Events:\n"
      );
      document.getElementById("content").innerText = output;
    },

    /**
     *  Sign out the user upon button click.
     */
    handleSignOutClick() {
      const token = this.api.client.getToken();
      if (token !== null) {
        google.accounts.oauth2.revoke(token.access_token);
        this.api.client.setToken("");
        document.getElementById("content").innerText = "fghgfh";
        document.getElementById("authorize_button").innerText = "Authorize";
        document.getElementById("signout_button").style.visibility = "hidden";
      }
    },

    /**
     *  Create events
     */

    handleCreateEvent() {
      let _lista = [];

      if (this.modelPrincipal != null) {
        let objeto = {};
        if (this.modelPrincipal.email != undefined) {
          objeto.email = this.modelPrincipal.email.trim();

          _lista.push(objeto);
          // = _lista+ "{"+"email"+":"+this.modelPrincipal.email.trim();
        }
      }

      for (let index = 0; index < this.modelAdicional.length; index++) {
        //  const element = this.modelAdicional[index];
        let objeto = {};
        if (this.modelAdicional[index].email.trim().length > 0) {
          objeto.email = this.modelAdicional[index].email.trim();
          _lista.push(objeto);
        }

        //  _lista =_lista+  ","+"email:"+this.modelAdicional[index].email.trim();
      }

      const event = {
        summary: this.tarea.descripcion,
        location:
          "(" +
          this.tarea.descripcion +
          ") Sistema Gestion de Proyectos Copedesa App",
        description: this.tarea.observacion,
        start: {
          dateTime: this.dates[1] + "T23:00:00-00:00",
          timeZone: "America/Bogota",
        },
        end: {
          dateTime: this.dates[1] + "T23:00:00-00:00",
          timeZone: "America/Bogota",
        },
        recurrence: ["RRULE:FREQ=DAILY;COUNT=2"],
        // attendees: [
        // JSON.stringify( _lista)
        // ],
        reminders: {
          useDefault: false,
          overrides: [
            { method: "email", minutes: 24 * 60 },
            { method: "popup", minutes: 10 },
          ],
        },
      };

      event["attendees"] = [];
      var lista3 = "";
      console.log("eventos", event);
      var _listArray = [];
      // lista3 = lista3 + "["
      _lista.forEach((element) => {
        event.attendees.push({ email: element.email });
        lista3 = lista3 + JSON.stringify(element) + ",";
        // _listArray = JSON.stringify( element)
      });

      const request = gapi.client.calendar.events.insert({
        calendarId: "primary",
        resource: event,
      });

      request.execute(function (event) {
        // appendPre('Event created: ' + event.htmlLink);
      });
    },

    /**
     * Enables user interaction after all libraries are loaded.
     */
    maybeEnableButtons() {
      console.log({
        gapiInited: this.gapiInited,
        gisInited: this.gisInited,
      });
      if (this.gapiInited && this.gisInited) {
        // this.authorized = true;
      }
    },
  },

  computed: {
    dateRangeText() {
      return this.dates.join(" ~ ");
    },
    rulesCmb() {
      const rules = [];

      if (this.max) {
        const rule = (v) =>
          (v || "").length > 1 ||
          `A maximum of ${this.max} characters is allowed`;

        rules.push(rule);
        console.log("rules", rules);
      }

      // if (!this.allowSpaces) {
      //   const rule =
      //     v => (v || '').indexOf(' ') < 0 ||
      //       'No spaces are allowed'

      //   rules.push(rule)
      // }

      // if (this.match) {
      //   const rule =
      //     v => (!!v && v) === this.match ||
      //       'Values do not match'

      //   rules.push(rule)
      // }

      return rules;
    },
  },
  watch: {
    modelAdicional(val) {
      if (val.length > 5) {
        this.$nextTick(() => this.modelAdicional.pop());
      }
    },
  },
};
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
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
