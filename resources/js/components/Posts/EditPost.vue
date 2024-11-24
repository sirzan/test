<template>
  <ModalBootstrap ref="modal">
    <template v-slot="{ openModal }">
      <button type="button" @click="openModal" class="btn btn-secondary">
        Editar
      </button>
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
      <button type="button" class="btn btn-dark" @click="updatePost">
        Guardar Cambios
      </button>
    </template>
  </ModalBootstrap>
</template>
  
  <script setup>
import { reactive, ref } from "vue";
import ModalBootstrap from "../Tools/ModalBootstrap.vue";
import Swal from "sweetalert2";
import axios from "axios";

const props = defineProps({
  info: Object,
  callback: Function,
});

// Asociamos correctamente la referencia del modal
const modal = ref(null);

const datos = reactive({
  title: props.info.title,
  content: props.info.content,
});

const updatePost = async () => {
  try {
    const { data } = await axios.put(`/api/posts/${props.info.id}`, {
      ...datos,
    });

    if (data) {
      modal.value.closeModal(); // Correcta referencia al modal
      Swal.fire({
        title: "Actualizado!",
        text: "El post fue actualizado.",
        icon: "success",
      });
      props.callback(data); // Llamamos al callback con los nuevos datos
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Surgió un error al actualizar el post!",
    });
  }
};
</script>
  