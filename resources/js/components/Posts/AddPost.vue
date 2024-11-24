<template>
  <ModalBootstrap ref="model">
    <template v-slot="{ openModal }">
      <button class="btn btn-warning" @click="openModal">Agregar post</button>
    </template>
    <template #body>
      <div>
        <div class="mb-3">
          <label for="">Titulo</label>
          <input type="text" v-model="datos.title" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Contenido</label>
          <textarea v-model="datos.content" class="form-control"></textarea>
        </div>
      </div>
    </template>
    <template #submit>
      <button class="btn btn-dark" @click="handleSubmit">Crear post</button>
    </template>
  </ModalBootstrap>
</template>
<script setup>
import { reactive, ref } from "vue";
import ModalBootstrap from "../Tools/ModalBootstrap.vue";
import Swal from "sweetalert2";

const props = defineProps({
  callback: Function,
});

const model = ref('');
const info = {
  title: "",
  content: "",
};

const datos = reactive({
  ...info,
});

const handleSubmit = async () => {
  try {
    const { data } = await axios.post("/api/posts", { ...datos });
    if (data) {
      Swal.fire({
        title: "Guardar",
        text: "Se guardaron los cambios con éxito",
        icon: "success",
        allowOutsideClick: false,
        allowEscapeKey: false,
      }).then((result) => {
        if (result) {
          Object.assign(datos, { ...info });
          props.callback(data);
          model.value.closeModal();
        }
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Something went wrong!",
    });
  }
};
</script>