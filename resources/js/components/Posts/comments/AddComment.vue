<template>
  <ModalBootstrap ref="modal">
    <template v-slot="{ openModal }">
      <button class="btn btn-dark btn-sm" @click="openModal">
        Agregar Comentario
      </button>
    </template>
    <template #body>
      <div class="my-3">
        <h5 class="mb-3">Agregar comentario</h5>
        <textarea
          class="form-control"
          v-model="datos.content"
          cols="30"
          rows="5"
        ></textarea>
      </div>
    </template>
    <template #submit>
      <button class="btn btn-dark" type="button" @click="addComment">Comentar</button>
    </template>
  </ModalBootstrap>
</template>
<script setup>
import { reactive, ref } from "vue";
import ModalBootstrap from "../../Tools/ModalBootstrap.vue";
import Swal from "sweetalert2";

const props = defineProps({
  info: Object,
  callback: Function,
});

const info = {
  content: "",
};

const modal = ref("");

const datos = reactive({ ...info });

const addComment = async () => {
  try {
    const { data } = await axios.post(`/api/posts/${props.info.id}/comments`,{...datos});
    if (data) {
      Swal.fire({
        title: "Guardar",
        text: "Se agregar tu comentario con éxito",
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
      text: "Surgio un error al agregar el comentario!",
    });
  }
};
</script>