<template>
  <div>
    <div
      class="modal fade"
      id="abrirmodales"
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
            <form @submit.prevent="editarCategoria(categoria)" >
              <h3>Editar Categoria</h3>
              <input
                type="text"
                class="form-control mb-2"
                placeholder="Nombre de la nota"
                v-model="categoria.nombre_categoria"
              />
              <button class="btn btn-warning" type="submit">Editar</button>
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
      <h3>Agregar Categoria</h3>
      <input
        type="text"
        class="form-control mb-2"
        placeholder="Nombre de la nota"
        v-model="categoria.nombre_categoria"
      />

      <button class="btn btn-primary" type="submit">Agregar</button>
    </form>
    <hr />
    <h3>Lista de notas:</h3>
    <ul class="list-group">
      <li class="list-group-item" v-for="(item, index) in categorias" :key="item">
        <p>
          <strong>Nombre Categoria:</strong>
          {{item.nombre_categoria}}
        </p>
        <p>
          <button class="btn btn-warning btn-sm" data-toggle="modal"
            data-target="#abrirmodales" @click="editarFormulario(item)">Editar</button>
          <button class="btn btn-danger btn-sm" @click="eliminarCategoria(item, index)">Eliminar</button>
        </p>
      </li>
    </ul>
    <!-- <table class="table" id="example">
     <thead class="thead-dark">
       <tr>
         <th scope="col">#</th>
         <th scope="col">Nombre Categoria</th>
      
       </tr>
     </thead>
     <tbody>
       <tr v-for="(item, index) in categorias" :key="index">
         <th scope="row">{{item.id}}</th>
         <td>{{item.nombre_categoria}}</td>
        
       </tr>
       
     </tbody>
    </table>-->
  </div>
</template>

<script>
export default {
  data() {
    return {
      categorias: [],
      modoEditar: false,
      categoria: { nombre_categoria: "" }
    };
  },
  created() {
    axios.get("/categorias").then(res => {
      this.categorias = res.data;
    });
  },
  methods: {
    agregar() {
      if (this.categoria.nombre_categoria.trim() === "") {
        alert("Debes completar todos los campos antes de guardar");
        return;
      }
      const categoriaNueva = this.categoria;
      this.categoria = { nombre_categoria: "" };
      axios.post("/categorias", categoriaNueva).then(res => {
        const categoriaServidor = res.data;
        this.categorias.push(categoriaServidor);
        alert("Datos Almacenados");
      });
    },
    eliminarCategoria(categoria, index) {
      const confirmacion = confirm(
        `Eliminar categoria ${categoria.nombre_categoria}`
      );
      if (confirmacion) {
        axios.delete(`/categorias/${categoria.id}`).then(res => {
          this.categoria.splice(index, 1);
          const categoriaServidor = res.data;
          this.categorias.push(categoriaServidor);
        });
      }
    },
    editarFormulario(item) {
      this.categoria.nombre_categoria = item.nombre_categoria;
      this.categoria.id = item.id;
      this.modoEditar = true;
    },
    editarCategoria(categoria) {
      const params = { nombre_categoria: categoria.nombre_categoria };
      axios.put(`/categorias/${categoria.id}`, params).then(res => {
        this.modoEditar = false;
        const index = this.categorias.findIndex(
          item => item.id === categoria.id
        );
        this.categorias[index] = res.data;
        this.categoria = { nombre: "" };
        alert("Datos Modificados");
      });
    },
    cancelarEdicion() {
      this.modoEditar = false;
      this.categoria = { nombre: "" };
    }
  }
};
</script>