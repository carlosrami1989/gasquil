<template>
    <div>
        <v-navigation-drawer app v-model="drawer">
            <!-- -->
            <v-list-item v-model="selectedItem" color="teal lighten-3">
                <v-list-item-content>
                    <v-list-item-title class="text-h6">
                        <v-img src="/img/logo.bmp" class="grey darken-4">
                        </v-img>
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        CORPALVAH - Gestion de Proyectos
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense nav>
                <v-list-item-group>
                    <v-list-item v-for="name in items" :key="name.name">
                        <v-list-item-icon>
                            <v-icon :color="name.color">{{ name.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>
                                <router-link :to="prefijo + name.ruta">
                                    {{ name.name }}
                                </router-link></v-list-item-title
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app>
            <!-- -->
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>

            <v-toolbar-title>
                Sistema Gestión de Proyectos y Servicios</v-toolbar-title
            >

            <v-spacer></v-spacer>
            <div v-for="item in usuario" :key="item.id">
                <span>{{ item.name }}</span>
            </div>

            <v-btn icon>
                <v-icon>mdi-account</v-icon>
            </v-btn>

            <v-btn icon @click="logout()">
                <v-icon>mdi-close-circle</v-icon>
            </v-btn>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                <router-view></router-view>
            </v-container>
        </v-main>
    </div>
</template>

<script>
import { prefix, url } from "../../../variables";
export default {
    // props: ['user'],
    props: {
        user: {
            type: Object,
        },
    },
    name: "HomeAppBar",

    data: () => ({
        usuario: [],
        selectedItem: 1,
        icons: ["mdi-facebook", "mdi-twitter", "mdi-linkedin", "mdi-instagram"],
        drawer: true,
        group: null,
        value: 1,
        prefijo: "",
        //drawer: null,
        text: "white--text lighten-1--text",
        bg: "secondary",
        base: "video",
        items: [],
    }),
    mounted() {
        this.consultaPerfil();
        this.consultasUsuario();
        //  console.log('aqui');

        //console.log( this.$props.user.id);
    },

    methods: {
        logout() {
            window.location.replace("/logout");
            // let url =
            //     this.$store.getters.getRuta +
            //     "/logout";

            //   axios
            //     .get(url)
            //     .then(function (response) {
            //       this.$router.go('/login');

            //     })
            //     .catch((error) => {
            //       //Errores de validación

            //     });
        },

            consultasUsuario() {
                let that = this;
                let url =
                    this.$store.getters.getRuta +
                    "/modulos/admision/paciente/cargarUsuario/" +
                    this.$props.user.id;

                axios
                    .get(url)
                    .then(function (response) {
                        that.usuario = response.data.data;
                    })
                    .catch((error) => {
                        //Errores de validación
                    });
            },
        consultaPerfil() {
            let that = this;
            let url =
                this.$store.getters.getRuta +
                "/modulos/admision/paciente/IncipSession/" +
                this.$props.user.id;
            
            axios
                .get(url)
                .then(function (response) {
                console.log(response.data);
                    if (response.data.data[0].perfil == 1) {
                        that.items.push(
                            {
                                name: "Dashboard",
                                icon: "mdi-view-dashboard",
                                ruta: "/admin",
                                color: "primary",
                            },
                            {
                                name: "Operoil",
                                icon: "mdi-oil-level",
                                ruta: "/modulos/bi/operoil",
                                color: "orange",
                            },
                            {
                                name: "Copemarket",
                                icon: "mdi-store",
                                ruta: "/contifico",
                                color: "green",
                            },
                            {
                                name: "Administradores Contifico",
                                icon: "mdi-store",
                                ruta: "/admincontifico",
                                color: "green",
                            },
                            {
                                name: "Proyectos",
                                icon: "mdi-certificate",
                                ruta:
                                    prefix + "/modulos/parametrizacion/tareas",
                                color: "purple",
                            },
                            {
                                name: "Tareas Normales",
                                icon: "mdi-clipboard-list-outline",
                                ruta:
                                    prefix + "/modulos/parametrizacion/tareasNormales",
                                color: "purple",
                            },
                            {
                                name: "Ingreso de Gastos",
                                icon: "mdi-feature-search-outline",
                                ruta:
                                    prefix + "/gastosestacion",
                                color: "red",
                            },
                             
                            {
                                name: "Ingreso de Combustible",
                                icon: "mdi-gas-station",
                                ruta:
                                    prefix + "/ingresocombustible",
                                color: "blue",
                            },
                            {
                                name: "Ingreso de Proveedores",
                                icon: "mdi-store",
                                ruta:
                                    prefix + "/proveedores",
                                color: "red",
                            },
                            {
                                name: "Ingreso de Blindado",
                                icon: "mdi-bus-articulated-front",
                                ruta:
                                    prefix + "/blindado",
                                color: "green",
                            },

                            {
                                name: "Ingreso de Bitacora",
                                icon: "mdi-fuel",
                                ruta:
                                    prefix +
                                    "/modulos/parametrizacion/tipodesechos",
                                color: "pink",
                            },
                            {
                                name: "Reportes de Estaciones",
                                icon: "mdi-clipboard-text-multiple",
                                ruta:
                                    prefix +
                                    "/modulos/parametrizacion/clasificaciondesechos",
                                color: "cyan darken-4",
                            },
                            // {
                            //     name: "Copemarket",
                            //     icon: "mdi-shopping",
                            //     ruta:
                            //         prefix +
                            //         "/modulos/visor/copemarket",
                            //     color: "amber darken-4",
                            // },
                            // {
                            //     name: "Calidad",
                            //     icon: "mdi-quality-low",
                            //     ruta:
                            //         prefix +
                            //         "/modulos/calidad",
                            //     color: "amber",
                            // },
                            // {
                            //     name: "Transporte",
                            //     icon: "mdi-truck",
                            //     ruta:
                            //         prefix +
                            //         "/modulos/transporte",
                            //     color: "success",
                            // }
                            //  {name:'Ingreso de Desechos',icon: 'mdi-clipboard-check', ruta:prefix+'/modulos/administracion/ingreso',color:'green darken-4'},
                            //  //{name:'Asignación de Perfil',icon: 'mdi-account-multiple-plus', ruta:prefix+'',color:'orange darken-4'},
                            //  {name:'Creación de Usuario',icon: 'mdi-account-lock', ruta:prefix+'/modulos/seguridad/registrar',color:'teal'},
                            //  {name:'Reportes General',icon: 'mdi-clipboard-text-multiple', ruta:prefix+'/modulos/reporte/mostrar',color:'red'},

                            //{name:'Departamentos',icon: 'mdi-file-document', ruta:prefix+'-',color:'green darken-4'},
                            //{name:'Rotary Astillero',icon: 'mdi-earth', ruta:'-',color:'orange darken-4'}
                        );
                    } else {
                        that.items.push(
                        //   {
                        //         name: "Dashboard",
                        //         icon: "mdi-view-dashboard",
                        //         ruta: "/",
                        //         color: "primary",
                        //     },
                        {
                                name: "Operoil",
                                icon: "mdi-oil-level",
                                ruta: "/modulos/bi/operoil",
                                color: "orange",
                            },
                            {
                                name: "Copemarket",
                                icon: "mdi-store",
                                ruta: "/contifico",
                                color: "green",
                            },
                        {
                                name: "Ingreso de Gastos",
                                icon: "mdi-feature-search-outline",
                                ruta:
                                    prefix + "/gastosestacion",
                                color: "red",
                            },
                             
                            {
                                name: "Ingreso de Combustible",
                                icon: "mdi-gas-station",
                                ruta:
                                    prefix + "/ingresocombustible",
                                color: "blue",
                            },
                            {
                                name: "Ingreso de Proveedores",
                                icon: "mdi-store",
                                ruta:
                                    prefix + "/proveedores",
                                color: "red",
                            },
                            {
                                name: "Ingreso de Blindado",
                                icon: "mdi-bus-articulated-front",
                                ruta:
                                    prefix + "/blindado",
                                color: "green",
                            },
                            {
                                name: "Tareas",
                                icon: "mdi-certificate",
                                ruta:
                                    prefix + "/modulos/parametrizacion/tareas",
                                color: "purple",
                            },
                            {
                                name: "Tareas Normales",
                                icon: "mdi-clipboard-list-outline",
                                ruta:
                                    prefix + "/modulos/parametrizacion/tareasNormales",
                                color: "purple",
                            },

                        );
                    }
                    // that.usuario = response.data.data.id_perfil;
                    console.log(response.data.data[0].id_perfil);
                })
                .catch((error) => {
                  console.log(error);
                    //Errores de validación
                });
        },
    },
    watch: {
        group() {
            this.drawer = false;
        },
    },
};
</script>
