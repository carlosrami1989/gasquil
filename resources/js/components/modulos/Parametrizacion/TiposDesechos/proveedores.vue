<template>
  <div>
    <v-card elevation="5" class="mx-auto">
      <v-card-title primary-title> Mantenimiento de Proveedores </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field
              label="Nombre"
              hint="Nombre"
              v-model="form.nombre"
              
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              label="Apellido"
              hint="Ingrese apellido"
              v-model="form.apellido"
            
              required
            ></v-text-field>
          </v-col>

          <v-col cols="12" sm="6">
            <v-text-field
              label="Ruc"
              hint="Ruc"
              v-model="form.ruc"
              type="number"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              label="Cedula"
              hint="Ingrese cedula"
              v-model="form.cedula"
              type="number"
              required
            ></v-text-field>
          </v-col>
        </v-row>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-text-field
            v-model="form.razon_social"
            label="Razón Social"
            required
          ></v-text-field>

          <v-text-field
            v-model="form.direccion"
            label="direccion"
            required
          ></v-text-field>

          <v-text-field
            v-model="form.telefono"
            :counter="10"
            :rules="nameRules"
            label="telefono"
            type="number"
            required
          ></v-text-field>

          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                :disabled="!valid"
                color="success"
                class="mr-4"
                v-bind="attrs"
                v-on="on"
                @click="createPaciente()"
              >
                <v-icon>{{ form.icono }}</v-icon>
              </v-btn>
            </template>
            <span>Generar/Modificar Registro</span>
          </v-tooltip>

          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="error"
                class="mr-4"
                @click="limpiar()"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon>mdi-file-star</v-icon>
              </v-btn>
            </template>
            <span>Limpiar Registro</span>
          </v-tooltip>
        </v-form>
        <v-card-title>
          Detalles
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table :headers="headers" :items="desserts" :search="search">
          <template v-slot:item.acciones="{ item }">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-icon
                  large
                  color="purple"
                  @click="agregar(item)"
                  v-bind="attrs"
                  v-on="on"
                >
                  mdi-refresh-circle
                </v-icon>
              </template>
              <span>Modificar Registro</span>
            </v-tooltip>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>

    <v-snackbar
      v-model="snackbar"
      :timeout="timeout"
      absolute
      top
      top
      :color="color"
    >
      <v-icon>{{ icono }}</v-icon>
      {{ text }}
      <!-- <template v-slot:action="{ attrs }">
        <v-btn
          color="blue" 
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template> -->
    </v-snackbar>
  </div>
</template>
<script>
export default {
  data() {
    return {
      valid: true,
      form: {
        id: 0,
        nombre: "",
        apellido: "",
        ruc: 0,
        cedula: 0,
        razon_social: 0,
        direccion: 0,
        telefono: 0,
        correo: 0,
      },
      icono: "mdi-checkbox-marked",
      snackbar: false,
      text: "",
      timeout: 4000,
      color: "purple darken-4",
      name: "",
      search: "",
      nameRules: [
        (v) => !!v || "Name is required",
        (v) => (v && v.length <= 10) || "Name must be less than 10 characters",
      ],
      email: "",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      select: null,
      items: ["Item 1", "Item 2", "Item 3", "Item 4"],
      checkbox: false,
      headers: [
        {
          text: "codigo",
          align: "start",
          sortable: false,
          value: "id",
        },
        { text: "nombres", value: "NOMBRESALL" },
        { text: "ruc", value: "ruc" },
        { text: "Razon Social", value: "razon_social" },
        { text: "acciones", value: "acciones" },
      ],
      desserts: [],
    };
  },
  mounted() {
    this.consultasPaciente();
    this.limpiar();
  },
  methods: {
    limpiar() {
      this.form.id = 0;
      this.form.nombre = "";
      this.form.apellido = "";
      this.form.ruc = "";
      this.form.cedula = "";
      this.form.razon_social = "";
      this.form.direccion = "";
      this.form.telefono = "";
      this.form.correo = "";
      this.form.icono = "mdi-content-save-all";
      this.$refs.form.reset();
    },
    agregar(value) {
      
      this.form.id = value.id;
      this.form.nombre = value.nombre;
      this.form.apellido = value.apellido;
      this.form.ruc = value.ruc;
      this.form.cedula = value.cedula;
      this.form.razon_social = value.razon_social;
      this.form.direccion = value.direccion;
      this.form.telefono = value.telefono;
      this.form.correo = value.correo;

      console.log();
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
    createPaciente() {
      this.$refs.form.validate();
      let that = this;
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/createProveedor";

      axios
        .post(url, that.form)
        .then((response) => {
          that.mensajeAler(response.data.consulta, true);
          that.limpiar();
          that.consultasPaciente();

          // loader.hide();
        })
        .catch((error) => {
          let objeto = [];
          objeto = Object.values(error.response.data.errors);
          //   console.log(objeto);
          //   console.log(objeto.length);

          for (let index = 0; index < objeto.length; index++) {
            // const element = array[index];
            // console.log(objeto.[index][0]);
            that.mensajeAler(objeto[index][0], false);
          }
          //that.mensajeAler(response.data.data,false);
          //Errores de validación
          //loader.hide();
        });
      this.consultasPaciente();
    },
    consultasPaciente() {
      let url =
        this.$store.getters.getRuta +
        "/modulos/admision/paciente/ConsultarProveedor";

      axios
        .get(url)
        .then((response) => {
          this.desserts = response.data.consulta;
         
        })
        .catch((error) => {
          console.log("desserts", error);
          //Errores de validación
          //loader.hide();
        });
    },
    validate() {},
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
  },
};
</script>