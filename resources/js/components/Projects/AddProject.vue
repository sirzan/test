<template>
  <button class="btn btn-warning" @click="openModal">Crear Proyecto</button>
  <ModalBootstrap ref="modal">
    <template #body>
      <div>
        <div class="mb-3">
          <label for="">Proyecto</label>
          <input type="text" v-model="datos.name" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Descripción</label>
          <textarea v-model="datos.description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
          <label for="">Usuario</label>
          <multiselect
            v-model="datos.users"
            :multiple="true"
            :taggable="true"
            track-by="id"
            label="name"
            placeholder="Seleccionar Usuarios"
            :options="options"
          ></multiselect>
        </div>
      </div>
    </template>
    <template #submit>
      <button class="btn btn-dark" @click="handleSubmit">Crear proyecto</button>
    </template>
  </ModalBootstrap>
</template>
  <script setup>
import { reactive, ref } from "vue";
import ModalBootstrap from "../Tools/ModalBootstrap.vue";
import Swal from "sweetalert2";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
const props = defineProps({
  callback: Function,
});

const modal = ref("");
const info = {
  name: "",
  description: "",
  users: [],
};

const datos = reactive({
  ...info,
});

const options = ref([]);

const getUsers = async () => {
  try {
    const { data } = await axios.get("/api/users");
    options.value = data;
  } catch (error) {
    console.log(error);
  }
};

const openModal = () => {
  modal.value.openModal();
  getUsers();
};

const handleSubmit = async () => {
  try {
    var listUser = [];
    datos.users.forEach((e) => {
      listUser = [...listUser, e?.id];
    });

    const { data } = await axios.post("/api/projects", {
      name: datos.name,
      description: datos.description,
      users: listUser,
    });
    if (data) {
      Swal.fire({
        title: "Guardar",
        text: "Se ha creado un nuevo proyecto",
        icon: "success",
        allowOutsideClick: false,
        allowEscapeKey: false,
      }).then((result) => {
        if (result) {
          Object.assign(datos, { ...info });
          props.callback(data);
          modal.value.closeModal();
        }
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Surgio un error al crear el proyecto!",
    });
  }
};
</script>