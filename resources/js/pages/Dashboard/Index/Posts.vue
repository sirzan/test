<template>
  <AddPost :callback="setPost"></AddPost>
  <div class="table-responsive my-3">
    <table class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Titulo</th>
          <th>Content</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="list.length === 0">
          <td colspan="4" class="text-center">No hay registros</td>
        </tr>
        <tr v-else v-for="item in list" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.content.substr(0, 100) }}...</td>
          <td>
            <div
              class="btn-group"
              role="group"
              aria-label="Basic mixed styles example"
            >
              <button class="btn btn-secondary">Editar</button>
              <button
                type="button"
                class="btn btn-danger"
                @click="deletePost(item.id)"
              >
                Eliminar
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import AddPost from "../../../components/Posts/AddPost.vue";
import Swal from "sweetalert2";

const list = ref([]);

const getPosts = async () => {
  try {
    const { data } = await axios.get("/api/posts-user");
    list.value = data;
  } catch (error) {
    console.log(error);
  }
};

const setPost = (item) => {
  list.value = { item, ...list.value };
};

const deletePost = (id) => {
  Swal.fire({
    title: "¿Deseas eliminar este post?",
    text: "Si no estas seguro, puedes cancelar esta acción",
    icon: "warning",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const { data } = await axios.delete("/api/posts/" + id);
        if (data) {
          Swal.fire({
            title: "Eliminado!",
            text: "El post fue eliminado.",
            icon: "success",
          });
          list.value = list.value.filter((item) => item.id != id);
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Surgio un error al eliminar el post!",
        });
      }
    }
  });
};

onMounted(() => {
  getPosts();
});
</script>