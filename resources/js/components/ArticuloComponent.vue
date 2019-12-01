<template>
  <div>
    <div
      class="modal fade"
      id="abrirmodal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Modificar Articulo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="editarArticulo(articulo)">
              <h3>Modificar Articulo</h3>
              <select class="form-control" v-model="articulo.categoria_id" @change="changeLocation">
                
                <option
                  v-for="(item, index) in categorias"
                  :key="index"
                  v-bind:value="item.id"
                >{{ item.nombre_categoria }}</option>
              </select>
              <input
                type="number"
                class="form-control mb-2"
                placeholder="Numero Registro"
                v-model="articulo.numero_registro"
              />
              <input
                type="text"
                class="form-control mb-2"
                placeholder="Nombre Articulo"
                v-model="articulo.nombre_articulo"
              />
              <input
                type="number"
                class="form-control mb-2"
                placeholder="Cantidad"
                v-model="articulo.cantidad"
              />

              <button class="btn btn-warning"  type="submit">Editar</button>
              <button  class="btn btn-danger" type="submit" @click="cancelarEdicion" data-dismiss="modal" aria-label="Close">
              Cancelar
              </button>
              
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <form @submit.prevent="agregar">
      <h3>Agregar Articulo</h3>
      <select class="form-control" v-model="articulo.categoria_id" @change="changeLocation">
        
        <option
          v-for="(item, index) in categorias"
          :key="index"
          v-bind:value="item.id"
        >{{ item.nombre_categoria }}</option>
      </select>
      <input
        type="number"
        class="form-control mb-2"
        placeholder="Numero Registro"
        v-model="articulo.numero_registro"
      />
      <input
        type="text"
        class="form-control mb-2"
        placeholder="Nombre Articulo"
        v-model="articulo.nombre_articulo"
      />
      <input
        type="number"
        class="form-control mb-2"
        placeholder="Cantidad"
        v-model="articulo.cantidad"
      />

      <button class="btn btn-primary" type="submit">Agregar</button>
    </form>
    <hr />
    <ul class="list-group">
      <li class="list-group-item" v-for="(item, index) in articulos" :key="index">
        <p>
          <strong>Numero Registro:</strong>
          {{item.numero_registro}}
        </p>
        <p>
          <strong>Nombre Articulo:</strong>
          {{item.nombre_articulo}}
        </p>
        <p>
          <strong>Cantidad:</strong>
          {{item.cantidad}}
        </p>
        <p>
          <strong>Categoria:</strong>
          {{item.categoria}}
        </p>
        <p>
          <button
            class="btn btn-warning btn-sm"
            data-toggle="modal"
            data-target="#abrirmodal"
            @click="editarFormulario(item)"
          >Editar</button>
          <button class="btn btn-danger btn-sm" @click="eliminarArticulo(item, index)">Eliminar</button>
        </p>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      articulos: [],
      modoEditar: false,
      articulo: {
        numero_registro: "",
        nombre_articulo: "",
        cantidad: "",
        categoria_id: ""
      },
      categorias: [],
      categoria: { nombre_categoria: "" }
    };
  },
  created() {
    axios.get("/articulos").then(res => {
      this.articulos = res.data;
    }),
      axios.get("/categorias").then(res => {
        this.categorias = res.data;
      });
  },
  methods: {
    agregar() {
      const articuloNuevo = this.articulo;
      this.articulo = {
        numero_registro: "",
        nombre_articulo: "",
        cantidad: "",
        categoria_id: ""
      };
      axios.post("/articulos", articuloNuevo).then(res => {
        const articuloServidor = res.data;
        this.articulos.push(articuloServidor);
        alert("Datos Almacenados");
      });
    },
    eliminarArticulo(articulo, index) {
      const confirmacion = confirm(
        `Eliminar articulo ${articulo.nombre_articulo}`
      );
      if (confirmacion) {
        axios.delete(`/articulos/${articulo.id}`).then(res => {
          this.articulo.splice(index, 1);
        });
      }
    },
    editarFormulario(item) {
      this.articulo.numero_registro = item.numero_registro;
      this.articulo.nombre_articulo = item.nombre_articulo;
      this.articulo.cantidad = item.cantidad;
      this.articulo.categoria_id = item.categoria_id;
      this.articulo.id = item.id;
      this.modoEditar = true;
    },
    editarArticulo(articulo) {
      const params = {
        nombre_articulo: articulo.nombre_articulo,
        numero_registro: articulo.numero_registro,
        cantidad: articulo.cantidad,
        categoria_id: articulo.categoria_id
      };
      axios.put(`/articulos/${articulo.id}`, params).then(res => {
        this.modoEditar = false;
        const index = this.articulos.findIndex(item => item.id === articulo.id);
        this.articulos[index] = res.data;
        this.articulo = {
          nombre_articulo: "",
          numero_registro: "",
          cantidad: "",
          categoria_id: ""
        };
        alert("Datos Modificados");
      });
    },
    cancelarEdicion() {
      this.modoEditar = false;
      this.articulo = {
        nombre_articulo: "",
        numero_registro: "",
        cantidad: "",
        categoria_id: ""
      };
    }
  }
};
</script>