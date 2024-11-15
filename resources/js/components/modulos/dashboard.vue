<template>
    <div>
         
        <v-divider></v-divider>
        <br />
        <v-row>
            
                    
            <v-col cols="12" sm="6" md="2" class="py-1"
             v-for="item of ListEstaciones"
             :key="item.id">
                <v-card class="pa-5" outlined tile  >
                    <router-link :to="{ name:'Item' , params: { id: item.id, nombre: item.nombre }}"    > 
                    <v-img
                        src="/img/gasquil.png"
                       
                    ></v-img>
                </router-link>        
                     
                        <v-card-text>
                            <v-icon large :color="item.color">{{ item.icon }} </v-icon> <b> {{ item.nombre}}</b>
                        </v-card-text>
                         
                </v-card>
            </v-col>
            <v-col cols="12" sm="6" md="2" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <router-link to="/modulos/bi/administracion"> 
                    
                    <v-img
                    src="/img/next.png"
                       
                    ></v-img>
                </router-link>     
                        <v-card-text>
                            <v-icon large color="primary">mdi-fuel</v-icon> Administrador
                        </v-card-text>
                         
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" md="2" class="py-1">
                <v-card class="pa-2" outlined tile elevation="15">
                    <router-link to="/modulos/bi/operoil"> 
                    
                    <v-img
                    src="/img/LogOperoil.png"
                       
                    ></v-img>
                </router-link>     
                        <v-card-text>
                            <v-icon large color="primary">mdi-oil</v-icon> Administrador
                        </v-card-text>
                         
                </v-card>
            </v-col>
            <!-- <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                   
                    <v-img
                    src="/img/next.png"
                       
                    ></v-img>
                   
                        <v-card-text>
                            <v-icon large color="primary">mdi-fuel</v-icon> Cerecita
                        </v-card-text>
                         
                </v-card>
            </v-col>
            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img   src="/img/churute.png"></v-img>
                     
                        <v-card-text>
                            <v-icon large color="orange">mdi-fuel </v-icon> Churute
                        </v-card-text>
                         
                </v-card>
            </v-col>
            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img src="/img/next.png"></v-img>
                     
                        <v-card-text>
                            <v-icon large color="blue">mdi-fuel </v-icon> GasHouse
                        </v-card-text>
                         
                </v-card>
            </v-col>
            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img src="/img/gasquil.png"></v-img>
                     
                        <v-card-text>
                            <v-icon large color="black">mdi-fuel </v-icon> Carchi
                        </v-card-text>
                         
                </v-card>
            </v-col>
  -->
        </v-row>



       
       
    </div>
    <!-- aqui termina :v -->
</template>
<script>
import { prefix, url } from "../../variables";

export default {
    props: {
        user: {
            type: Object,
        },
    },
    data() {
        return {
            rating1: 5,
            rating2: 4.5,
            ListEstaciones:[],
            items: [
                {
                    text: "Guayaquil",
                    icon: "mdi-city",
                    color: "purple darken-3",
                },
                {
                    text: "Duran",
                    icon: "mdi-home-city",
                    color: "indigo darken-1",
                },
                {
                    text: "Daule",
                    icon: "mdi-city-variant-outline",
                    color: "green darken-2",
                },
            ],
           
            chartData: {
                labels: [],
                series: [
                    [1, 2],
                    [4, 5],
                ],
            },
            chartOptions: {
                lineSmooth: false,
            },
            datos: null,
            chardatos: null,
            datos: [],
            vardatosTotal: [],
            vardatosMes: [],
            value: [],
            datos: {
                total_r: 0,
                total_k_d: 0,
                total_k_t: 0,
            },
            valor: [],
            rutas:{
                guayaquil:"",
                cerecita:"",
                gashouse:"",
                churute:"",
                carchi:"",
                sevilla_oro:"",
            },
        };
    },
    mounted() {
        this.rutas.guayaquil = prefix + "/modulos/bi/dashboardGasquil";
        this.consultasEstaciones();
       
        // this.consultasTotales();
        // this.consultasDashboard();
        // this.totalesCirugia();g
    },
    methods: {
        EnviarId(value){
            console.log("value",value);
        },
        consultarExcel(value) {
            // console.log(value);

            window.open(
                this.$store.getters.getRuta +
                    "/modulos/admision/paciente/generacionExcel"
            );
        },

        consultasEstaciones() {
            let that = this;
            let url =
                this.$store.getters.getRuta +
                "/modulos/admision/paciente/ConsultaEstaciones";
            let ListEstacionesRecorrer = [];
            axios
                .get(url)
                .then((response) => {
                 
                    ListEstacionesRecorrer = response.data.Resp;
                   // console.log("ListaEstaciones1",ListEstacionesRecorrer);
                    //  that.valor = response.data.data;
                   
                     ListEstacionesRecorrer.forEach(element => {
                        let objeto = {};
                        objeto.id = element.id;
                        objeto.nombre = element.descripcion;
                        objeto.icon = "mdi-fuel";
                        objeto.color = "primary";
                        this.ListEstaciones.push(objeto);
                     });
                    
                     //console.log("ListaEstaciones2",this.ListEstaciones);
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
    },
};
</script>

<style>
.v-sheet--offset {
    top: -24px;
    position: relative;
}
</style>
