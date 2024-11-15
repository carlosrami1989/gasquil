<template>
    <v-container class="grey lighten-5">
        <v-row>
            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img
                        src="/img/tv-pantalla-ancha.jpg"
                        @click="GenerarModal(1)"
                    ></v-img>

                    <v-card-text>
                        <v-icon large color="primary"
                            >mdi-television-play</v-icon
                        >
                        Cocina 1
                        <v-icon large color="red">mdi-play</v-icon>
                        Reproducir
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img src="/img/tv-pantalla-ancha.jpg"></v-img>

                    <v-card-text>
                        <v-icon large color="primary"
                            >mdi-television-play</v-icon
                        >
                        Cocina 2
                        <v-icon large color="red">mdi-play</v-icon>
                        Reproducir
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img src="/img/tv-pantalla-ancha.jpg"></v-img>

                    <v-card-text>
                        <v-icon large color="primary"
                            >mdi-television-play</v-icon
                        >
                        Cocina 3
                        <v-icon large color="red">mdi-play</v-icon>
                        Reproducir
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img src="/img/tv-pantalla-ancha.jpg"></v-img>

                    <v-card-text>
                        <v-icon large color="primary"
                            >mdi-television-play</v-icon
                        >
                        Entrada
                        <v-icon large color="red">mdi-play</v-icon>
                        Reproducir
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img src="/img/tv-pantalla-ancha.jpg"></v-img>

                    <v-card-text>
                        <v-icon large color="primary"
                            >mdi-television-play</v-icon
                        >
                        ShowRoom
                        <v-icon large color="red">mdi-play</v-icon>

                        <a href="/video/veticalvideo.mp4">Reproducir</a>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" sm="2" md="4" class="py-1">
                <v-card class="pa-2" outlined tile>
                    <v-img src="/img/tv-pantalla-ancha.jpg"></v-img>

                    <v-card-text>
                        <v-icon large color="primary"
                            >mdi-television-play</v-icon
                        >
                        Entrada2
                        <v-icon large color="red">mdi-play</v-icon>
                        Reproducir
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
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
                                    <video autoplay loop>
                                        <source
                                            src="/video/veticalvideo.mp4"
                                            type="video/mp4"
                                        />
                                        Your browser does not support the video
                                        tag.
                                    </video>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="success" @click="dialog = false"
                                >Close</v-btn
                            >
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>
    </v-container>
</template>
<script>
import { prefix, url } from "../../../variables";
export default {
    props: {
        user: {
            type: Object,
        },
    },
    data() {
        return {
            justify: [
                "start",
                "center",
                "end",
                "space-around",
                "space-between",
            ],
            ruta: "",
            playerOptions: {
                // videojs options
                muted: true,
                language: "en",
                playbackRates: [0.7, 1.0, 1.5, 2.0],
                sources: [
                    {
                        type: "video/mp4",
                        src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm",
                    },
                ],
                poster: "/static/images/author.jpg",
            },
            dialog: false,
        };
    },
    mounted() {
        this.ruta = prefix + "/modulos/visor/copemarket";
        // this.consultasTotales();
        //   console.log('this is current player instance object', this.player);
        // this.consultasDashboard();
        // this.totalesCirugia();
    },
    computed: {
        //   player() {
        //     return this.$refs.videoPlayer.player
        //   }
    },
    methods: {
        GenerarModal(value) {
            this.dialog = true;
        },
    },
};
</script>
