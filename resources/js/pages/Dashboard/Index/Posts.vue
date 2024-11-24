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
              <button class="btn btn-danger">Eliminar</button>
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

onMounted(() => {
  getPosts();
});
</script>