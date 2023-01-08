<template>
    <div>
        <!-- <v-row>
            <v-col>
                <v-card>
                    <v-card-title class="text-h5">
                        Gestión de Desechos
                    </v-card-title>
                    <br />
                    <br />

                    <v-spacer></v-spacer>
                    <canvas
              id="ingresospacientes"
              height="120px"
              width="auto"
              
             
            ></canvas>
                  
                </v-card>
            </v-col>
        </v-row> -->

        <v-divider></v-divider>
        <br />
        <v-row dense>
            <v-col cols="12" md="4">
                <!-- la primera card -->
                <v-card  max-height="344" max-width="350" elevation="24">
                    <v-img
                        src="/img/gasquil.png"
                        height="200px"
                    ></v-img>

                    <v-card-title>
                        <v-img src="/img/logo.bmp" class="grey darken-4"  max-height="50"
                                          max-width="250">
                        </v-img
                    ></v-card-title>

                    
                     <v-card-subtitle> <v-icon color="primary">mdi-fuel </v-icon>GASQUIL </v-card-subtitle>

                    <v-card-actions>
                     
                        <v-btn color="orange lighten-2" text>Mas Información   
                         
                        </v-btn>

                        <v-spacer></v-spacer>

                        
                    </v-card-actions>

             
                </v-card>
                <!-- fin -->
            </v-col>

            <v-col cols="12" md="4">
                <!-- la primera card -->
                <v-card  max-height="344" max-width="350" elevation="24">
                    <v-img
                        src="/img/churute.png"
                        height="200px"
                    ></v-img>

                    <v-card-title>
                        <v-img src="/img/logo.bmp" class="grey darken-4"  max-height="50"
                                          max-width="250">
                        </v-img
                    ></v-card-title>

                    
                     <v-card-subtitle> <v-icon color="primary">mdi-fuel </v-icon>CHURUTE </v-card-subtitle>

                    <v-card-actions>
                     
                        <v-btn color="orange lighten-2" text>Mas Información   
                         
                        </v-btn>

                        <v-spacer></v-spacer>

                        
                    </v-card-actions>

             
                </v-card>
                <!-- fin -->
            </v-col>

            <v-col cols="12" md="4">
                <!-- la primera card -->
                <v-card  max-height="344" max-width="350" elevation="24">
                    <v-img
                        src="/img/next.png"
                        height="200px"
                    ></v-img>

                    <v-card-title>
                        <v-img src="/img/logo.bmp" class="grey darken-4"  max-height="50"
                                          max-width="250">
                        </v-img
                    ></v-card-title>

                    
                     <v-card-subtitle> <v-icon color="primary">mdi-fuel </v-icon>GASHOUSE</v-card-subtitle>

                    <v-card-actions>
                     
                        <v-btn color="orange lighten-2" text>Mas Información   
                         
                        </v-btn>

                        <v-spacer></v-spacer>

                        
                    </v-card-actions>

             
                </v-card>
                <!-- fin -->
            </v-col>

            <v-col cols="12" md="4">
                <!-- la primera card -->
                <v-card  max-height="344" max-width="350" elevation="24">
                    <v-img
                        src="/img/rioverde.png"
                        height="200px"
                    ></v-img>

                    <v-card-title>
                        <v-img src="/img/logo.bmp" class="grey darken-4"  max-height="50"
                                          max-width="250">
                        </v-img
                    ></v-card-title>

                    
                     <v-card-subtitle> <v-icon color="primary">mdi-fuel </v-icon>RÍO VERDE</v-card-subtitle>

                    <v-card-actions>
                     
                        <v-btn color="orange lighten-2" text>Mas Información   
                         
                        </v-btn>

                        <v-spacer></v-spacer>

                        
                    </v-card-actions>

             
                </v-card>
                <!-- fin -->
            </v-col>

            <v-col cols="12" md="4">
                <!-- la primera card -->
                <v-card  max-height="344" max-width="350" elevation="24">
                    <v-img
                        src="/img/next.png"
                        height="200px"
                    ></v-img>

                    <v-card-title>
                        <v-img src="/img/logo.bmp" class="grey darken-4"  max-height="50"
                                          max-width="250">
                        </v-img
                    ></v-card-title>

                    
                     <v-card-subtitle> <v-icon color="primary">mdi-fuel </v-icon>CERECITA</v-card-subtitle>

                    <v-card-actions>
                     
                        <v-btn color="orange lighten-2" text>Mas Información   
                         
                        </v-btn>

                        <v-spacer></v-spacer>

                        
                    </v-card-actions>

             
                </v-card>
                <!-- fin -->
            </v-col>

            
            <v-col cols="12" md="4">
                <!-- la primera card -->
                <v-card  max-height="344" max-width="350" elevation="24">
                    <v-img
                        src="/img/sanfrancisco.png"
                        height="200px"
                    ></v-img>

                    <v-card-title>
                        <v-img src="/img/logo.bmp" class="grey darken-4"  max-height="50"
                                          max-width="250">
                        </v-img
                    ></v-card-title>

                    
                     <v-card-subtitle> <v-icon color="primary">mdi-fuel </v-icon>SAN FRANCISCO</v-card-subtitle>

                    <v-card-actions>
                     
                        <v-btn color="orange lighten-2" text>Mas Información   
                         
                        </v-btn>

                        <v-spacer></v-spacer>

                        
                    </v-card-actions>

             
                </v-card>
                <!-- fin -->
            </v-col>
        </v-row>

       
    </div>
    <!-- aqui termina :v -->
</template>
<script>
export default {
    data() {
        return {
            rating1: 5,
            rating2: 4.5,

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
            labels: [],
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
        };
    },
    mounted() {
        this.consultasTotales();
        this.consultasDashboard();
        this.totalesCirugia();
    },
    methods: {
        consultarExcel(value) {
            // console.log(value);

            window.open(
                this.$store.getters.getRuta +
                    "/modulos/admision/paciente/generacionExcel"
            );
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
    },
};
</script>

<style>
.v-sheet--offset {
    top: -24px;
    position: relative;
}
</style>
