<template>
    <div>
        <v-divider></v-divider>
        <br />

        <v-row dense>
            <v-col cols="12" md="3">
                <!-- la primera card -->
                <v-card max-height="344" max-width="200" elevation="24">
                    <v-card-title primary-title>
                        <v-icon
                            class="outlined"
                            size="70"
                            color="purple darken-2"
                        >
                            mdi-book-multiple
                        </v-icon>

                        <v-btn
                            color="orange lighten-2"
                            text
                            @click="dialog = true"
                            >Tareas
                        </v-btn>
                    </v-card-title>

                    <v-card-subtitle> </v-card-subtitle>
                </v-card>
                <!-- fin -->
            </v-col>

            <v-col cols="12" md="3">
                <!-- la primera card -->
                <v-card max-height="344" max-width="200" elevation="24">
                    <v-card-title primary-title>
                        <v-icon
                            class="outlined"
                            size="70"
                            color="orange darken-1"
                        >
                            mdi-cogs</v-icon
                        >

                        <v-btn color="orange lighten-2" text>Segui. </v-btn>
                    </v-card-title>

                    <v-card-subtitle> </v-card-subtitle>
                </v-card>
                <!-- fin -->
            </v-col>
        </v-row>

        <!-- empieza el dialogo -->
        <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="600px">
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card>
                        <v-card-title>
                            <span class="text-h5">Ingreso de Tareas</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            label="Tarea principal"
                                            hint="Descripción de la tarea principal"
                                            v-model="tarea.descripcion"
                                            :rules="nameRules"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            label="Observación"
                                            hint="Observación de la tarea"
                                            v-model="tarea.observacion"
                                            :rules="nameRules"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-combobox
                                            v-model="modelEmpresa"
                                            :items="itemsEmpresa"
                                            :search-input.sync="searchEmpresa"
                                            hide-selected
                                            item-text="razon_social"
                                            item-value="id"
                                            label="Seleccione la empresa"
                                            :rules="nameRulesCmb"
                                            persistent-hint
                                            small-chips
                                        >
                                            <template v-slot:no-data>
                                                <v-list-item>
                                                    <v-list-item-content>
                                                        <v-list-item-title>
                                                            No results matching
                                                            "<strong>{{
                                                                searchEmpresa
                                                            }}</strong
                                                            >". Press
                                                            <kbd>enter</kbd> to
                                                            create a new one
                                                        </v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </template>
                                        </v-combobox>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-combobox
                                            v-model="modelPrincipal"
                                            :items="itemsPrincipal"
                                            :search-input.sync="searchPrincial"
                                            hide-selected
                                            item-text="FULLNAME"
                                            item-value="id"
                                            label="Seleccione Lider de la Tarea"
                                            :rules="nameRulesCmb"
                                            persistent-hint
                                            small-chips
                                        >
                                            <template v-slot:no-data>
                                                <v-list-item>
                                                    <v-list-item-content>
                                                        <v-list-item-title>
                                                            No results matching
                                                            "<strong>{{
                                                                searchPrincial
                                                            }}</strong
                                                            >". Press
                                                            <kbd>enter</kbd> to
                                                            create a new one
                                                        </v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </template>
                                        </v-combobox>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-combobox
                                            v-model="modelAdicional"
                                            :items="itemsAdicional"
                                            :search-input.sync="searchAdicional"
                                            hide-selected
                                            item-text="FULLNAME"
                                            item-value="id"
                                            label="Seleccione Involucrados"
                                            multiple
                                            persistent-hint
                                            small-chips
                                        >
                                            <template v-slot:no-data>
                                                <v-list-item>
                                                    <v-list-item-content>
                                                        <v-list-item-title>
                                                            No results matching
                                                            "<strong>{{
                                                                searchAdicional
                                                            }}</strong
                                                            >". Press
                                                            <kbd>enter</kbd> to
                                                            create a new one
                                                        </v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </template>
                                        </v-combobox>
                                    </v-col>

                                    <v-col cols="12" align="center">
                                        <v-date-picker
                                            justify="center"
                                            v-model="dates"
                                            range
                                        ></v-date-picker>
                                    </v-col>
                                    <v-col cols="12" align="center">
                                        <v-text-field
                                            v-model="dateRangeText"
                                            label="Fecha de inicio y final del proyecto"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                        ></v-text-field>
                                        model: {{ dates }}
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="dialog = false"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="grabarTarea()"
                            >
                                Grabar Tarea
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>
        <!-- dialogo de seguimiento -->

        <!-- empieza el dialogo -->
        <v-row justify="center">
            <v-dialog v-model="dialogSeguimiento" persistent max-width="600px">
                <v-form ref="formSeguimiento" v-model="valid" lazy-validation>
                    <v-card>
                        <v-card-title>
                            <span class="text-h5">Ingreso de Seguimiento</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            label="Titulo"
                                            hint="Titulo de seguimiento"
                                            v-model="SeguimientoTarea.titulo"
                                            :rules="nameRules"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            label="Observación"
                                            hint="Observación del Seguimiento"
                                            v-model="
                                                SeguimientoTarea.observacion
                                            "
                                            :rules="nameRules"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-file-input
                                            label="Agregar Documento / fotos "
                                            filled
                                            prepend-icon="mdi-camera"
                                        ></v-file-input>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        sm="4"
                                        md="4"
                                    >
                                        <v-checkbox
                                        v-show="showFinalizar"
                                        v-model="SeguimientoTarea.chk_finalizar"
                                        label="Finalizar Tarea"
                                        color="success"
                                       
                                        hide-details
                                        ></v-checkbox>
                                        
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="dialogSeguimiento = false"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="grabarSeguimientoTarea()"
                            >
                                Agregar Seguimiento
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>
        <!-- fin del dialogo -->
        <!-- empieza el dialogo seguimiento -->
        <v-row justify="center">
            <v-dialog
                v-model="dialogSeguimientoVisualizar"
                persistent
                max-width="600px"
            >
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Seguimientos Ingresados</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-timeline align-top dense>
                                        <v-timeline-item
                                            v-for="item in ListaTareasSeguimientoV"
                                            :key="item.id"
                                            :color="GetCadenaColor(item.id_perfil)"
                                            large
                                        >
                                        <template v-slot:icon>
                                            <span
                                                            class="white--text"
                                                            >{{
                                                         GetCadena(item.nombres)      
                                                        
                                                    }}</span
                                                        >
                                        </template>
                                            <v-row class="pt-1">
                                                <v-col cols="3">
                                                    <strong>{{
                                                        item.fecha_seguimiento
                                                    }}</strong>
                                                </v-col>
                                                <v-col>
                                                    <strong>{{
                                                        item.titulo
                                                    }}</strong>
                                                    <div
                                                        class="text-caption mb-2"
                                                    >
                                                        {{ item.observacion }}
                                                    </div>
                                                    <v-icon
                                                    color="orange"
                                                    >mdi-camera</v-icon>
                                                </v-col>
                                            </v-row>
                                        </v-timeline-item>
                                    </v-timeline>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="CerrarModal()"
                        >
                            Cerrar
                        </v-btn>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="grabarSeguimientoTarea()"
                        >
                            Agregar Seguimiento
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <!-- fin del dialogo -->
        <v-row>
            <v-col cols="12">
                <v-card>
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
                        <template v-slot:item.porcentaje="{ item }">
                            <v-progress-linear
                                v-model="item.porcentaje"
                                :color="getColor(item.porcentaje)"
                                height="25"
                            >
                                <template v-slot:default="{}">
                                    <strong>{{ item.porcentaje }}%</strong>
                                </template>
                            </v-progress-linear>
                        </template>
                        <template v-slot:item.acciones="{ item }">
                            <v-icon color="indigo" class="mr-2">
                                mdi-pencil
                            </v-icon>
                            <v-icon
                                color="purple"
                                @click="GenerarModalSeguimientoVisulizar(item)"
                                class="mr-2"
                            >
                                mdi-eye-circle
                            </v-icon>
                            <v-icon
                                color="blue"
                                class="mr-2"
                                @click="GenerarModalSeguimiento(item)"
                            >
                                mdi-file-document
                            </v-icon>
                        </template>
                    </v-data-table>
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
        <!-- finaliza el dialogo -->
    </div>
    <!-- aqui termina :v -->
</template>
<script>
export default {
    data() {
        return {
            //DatosTareas
            Cabeceratareas: [
                {
                    text: "Id Tareas",
                    align: "start",
                    filterable: false,
                    value: "id",
                },
                { text: "Empresa", value: "razon_social" },
                { text: "Apellidos", value: "apellidos" },
                { text: "Nombres", value: "nombres" },
                { text: "Tarea", value: "descripcion" },
                { text: "Total Segui.", value: "totales_count" },
                {
                    text: "Tiempo de finalización ",
                    value: "porcentaje",
                    width: "20%",
                },
                { text: "Acciones", value: "acciones", width: "15%" },
            ],
            ListaTareas: [],
            ListaTareasSeguimientoV: [],
            BusquedaCabecera: "",
            //validacion
            valid: false,
            allowSpaces: false,
            match: "Foobar",
            max: 1,
            model: "Foobar",
            showFinalizar:false,
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
            //model para correos y persona
            modelAdicional: [],
            itemsAdicional: [],
            searchAdicional: null,
            // arreglo de tarea
            tarea: {
                id: 0,
                id_empresa: 0,
                descripcion: "",
                observacion: "",
                id_persona: 0,
                estado_tarea: 1,
                estado: 1,
                fecha_ini: 0,
                fecha_fin: 0,
            },
            SeguimientoTarea: {
                id_tareas: 0,
                titulo: "",
                observacion: "",
                ruta_imagen: "",
                chk_finalizar:false,
            },

            dates: ["2023-01-10", "2023-01-20"],
            dialog: false,
            dialogSeguimiento: false,
            dialogSeguimientoVisualizar: false,
            nameRules: [
                (v) => !!v || "El campo es requerido",
                (v) =>
                    (v && v.length <= 100) ||
                    "Name must be less than 10 characters",
            ],
            nameRulesCmb: [
                (v) => !!v || "El campo es requerido",
                // v => ( v == null) || 'Name must be less than 10 characters',
            ],
            valor: [],
            cont:0,
            color_avatar:"",
        };
    },
    mounted() {
        // this.consultasTotales();
        // this.consultasDashboard();
        // this.totalesCirugia();
        this.consultasPersonas();
        this.consultasPersonasInvolucradas();
        this.consultasTareas();
        this.consultasEmpresas();
    },
    methods: {
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
                    (this.color = "light-blue darken-4"),
                        (this.snackbar = true);
                    this.text = "Transacción actualizada de manera exitosa";
                }
            } else {
                this.icono = "mdi-close-box";
                (this.color = "red darken-4"), (this.snackbar = true);
                this.text = "Error en el sistema " + value;
            }
        },
        consultasTotales() {
            let that = this;
            let url =
                this.$store.getters.getRuta +
                "/modulos/admision/paciente/ConsultaDatos";

            axios
                .get(url)
                .then(function (response) {
                    //  that.valor = response.data.data;
                    that.datos.total_r = response.data.toal_registro;
                    that.datos.total_k_d = response.data.kilos_dia;
                    that.datos.total_k_t = response.data.kilos_total;
                })
                .catch((error) => {
                    //Errores de validación
                });
        },
        consultasDashboard() {
            let that = this;
            let url =
                this.$store.getters.getRuta +
                "/modulos/admision/paciente/graficosPorDia";

            axios
                .get(url)
                .then(function (response) {
                    that.valor = response.data.data;
                    let objeto = {};
                    for (let index = 0; index < that.valor.length; index++) {
                        //const element = array[index];
                        objeto.fecha = that.valor[index].fech;
                        that.labels.push(objeto.fecha);

                        objeto.peso = that.valor[index].total;
                        that.value.push(objeto.peso);
                    }
                    that.totalesCirugia();
                })
                .catch((error) => {
                    //Errores de validación
                });
        },
        totalesCirugia() {
            var cirSuspendida = {
                label: "DESECHOS POR DIA",
                data: this.value,
                backgroundColor: "rgba(255, 0, 0, 1)",
                borderColor: "rgba(99, 132, 0, 1)",
                lineTension: 0,
                fill: false,
                borderColor: "orange",
                backgroundColor: "transparent",
                borderDash: [5, 5],
                pointBorderColor: "orange",
                pointBackgroundColor: "rgba(255,150,0,0.5)",
                pointRadius: 5,
                pointHoverRadius: 10,
                pointHitRadius: 30,
                pointBorderWidth: 2,
                pointStyle: "rectRounded",
            };

            var totalesData = {
                labels: this.labels,
                datasets: [cirSuspendida],
            };

            var chartOptions = {
                scales: {
                    xAxes: [
                        {
                            barPercentage: 1,
                            categoryPercentage: 0.6,
                        },
                    ],
                    yAxes: [
                        {
                            id: "y-axis-density",
                        },
                        {
                            id: "y-axis-gravity",
                        },
                    ],
                },
            };

            this.vardatos = document
                .getElementById("ingresospacientes")
                .getContext("2d");

            this.chardatos = new Chart(this.vardatos, {
                type: "line",

                data: totalesData,
                options: chartOptions,
                //options: chartOptions
            });
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
                this.$store.getters.getRuta +
                "/modulos/admision/paciente/GetEmpresa";

            axios
                .get(url)
                .then((response) => {
                    this.itemsEmpresa = response.data.listasEmpresas;
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
            console.log(this.$refs.form.validate());
            if (this.$refs.form.validate()) {
                let url =
                    this.$store.getters.getRuta +
                    "/modulos/admision/paciente/createTarea";

                this.tarea.fecha_ini = this.dates[0];
                this.tarea.fecha_fin = this.dates[1];
                this.tarea.id_persona = this.modelPrincipal.id;
                this.tarea.id_empresa = this.modelEmpresa.id;

                let _Lista = {
                    tarea: this.tarea,
                    adicional: this.modelAdicional,
                };

                // console.log(this.tarea);
                // return;

                axios
                    .post(url, _Lista)
                    .then((response) => {
                        console.log(response.data.data);
                        this.mensajeAler("Tarea registrada con éxito", true);
                        this.dialog = false;
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
        grabarSeguimientoTarea() {
            // console.log(this.$refs.formSeguimiento.validate());
            if (this.$refs.formSeguimiento.validate()) {
                let url =
                    this.$store.getters.getRuta +
                    "/modulos/admision/paciente/createSeguimientoTarea";

                // console.log(this.tarea);
                // return;

                axios
                    .post(url, this.SeguimientoTarea)
                    .then((response) => {
                        console.log(response.data.data);
                        this.mensajeAler(
                            "Seguimiento registrado con éxito",
                            true
                        );
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
            let url = "/modulos/admision/paciente/GetTareas";

            axios
                .get(url)
                .then((response) => {
                    this.ListaTareas = response.data.listasTareas.sort(
                        (x, y) => y.porcentaje - x.porcentaje
                    );
                })
                .catch((error) => {
                    //Errores de validación
                });
        },
        getColor(porcentaje) {
            // let color = "";
            // switch (porcentaje) {
            //     case porcentaje > 100:
            //        color = "red";
            //         break;
            //     case porcentaje >80 :
            //         color = "orange";
            //         break;
            //     case porcentaje > 40:
            //         color =  "green";
            //         break;
            // }
            // return color;
            if (porcentaje > 100) return "red";
            else if (porcentaje > 60) return "orange";
            else if (porcentaje < 60) return "green";
        },
        GenerarModalSeguimiento(item) {
           
            console.log(item);
            this.SeguimientoTarea.id_tareas = item.id;
             
            let that = this;
            let url = "/modulos/admision/paciente/usuarioActual";

            axios
                .get(url)
                .then((response) => {
                   this.SeguimientoTarea.chk_finalizar = false;
                    if (response.data.user.perfil  == 1) {
                        this.showFinalizar = true;
                    }else{
                        this.showFinalizar = false;
                    }
                   
                    this.dialogSeguimiento = true;
                })
                .catch((error) => {
                    //Errores de validación
                });
        },
        GenerarModalSeguimientoVisulizar(item) {
            console.log(item);
            let that = this;
            let url = "/modulos/admision/paciente/GetSeguimiento/" + item.id;

            axios
                .get(url)
                .then((response) => {
                    this.ListaTareasSeguimientoV =
                        response.data.listasSeguimiento;
                    this.dialogSeguimientoVisualizar = true;
                })
                .catch((error) => {
                    //Errores de validación
                });
        },
        CerrarModal(){
            this.dialogSeguimientoVisualizar = false;
            this.cont = 0;
            this.color_avatar="";
        },
        GetCadena(value){
            let arr = value.split(' ');
           let A =  arr[0].charAt(0).toUpperCase();
           let B =  arr[1].charAt(0).toUpperCase();
           
            return A + B;
        },

        GetCadenaColor(value){
           // return "blue" ;
           var _color1  = "";
           var _color2  = value;
        //    var _color = ""
           if (value == 1) {
            this.cont = 1;
            return "green"
            this.color

             }else{
                return "blue"

             }
                       
        }
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

<style>
.v-icon.outlined {
    position: relative;
    top: -40px;
    left: 0px;
}
</style>
