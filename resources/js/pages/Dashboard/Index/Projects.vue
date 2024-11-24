<template>
  <AddProject :callback="setProject"></AddProject>
  <div class="table-responsive my-3">
    <table class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Proyecto</th>
          <th>Descripción</th>
          <th>Usuarios</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="list.length === 0">
          <td colspan="5" class="text-center">No hay registros</td>
        </tr>
        <tr v-else v-for="item in list" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.description.substr(0, 100) }}...</td>
          <td>
            <span
              class="badge text-bg-secondary"
              v-for="user in item.users"
              :key="user.id"
              >{{ user.name }}</span
            >
          </td>
          <td>
            <div
              class="btn-group"
              role="group"
              aria-label="Basic mixed styles example"
            >
              <EditProject :info="item" :callback="updateList"></EditProject>
              <button
                type="button"
                class="btn btn-danger"
                @click="deleteProject(item.id)"
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
import AddProject from "../../../components/Projects/AddProject.vue";
import EditProject from "../../../components/Projects/EditProject.vue";
import Swal from "sweetalert2";

const list = ref([]);

const getProjects = async () => {
  try {
    const { data } = await axios.get("/api/projects");
    list.value = data;
  } catch (error) {
    console.log(error);
  }
};

const setProject = (item) => {
  list.value = { item, ...list.value };
};

const deleteProject = (id) => {
  Swal.fire({
    title: "¿Deseas eliminar este proyecto?",
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
        const { data } = await axios.delete("/api/projects/" + id);
        if (data) {
          Swal.fire({
            title: "Eliminado!",
            text: "El Proyecto fue eliminado.",
            icon: "success",
          });
          list.value = list.value.filter((item) => item.id != id);
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Surgio un error al eliminar el proyecto!",
        });
      }
    }
  });
};

const updateList = (datos) => {
  list.value = list.value.map((item) => {
    if (item.id == datos.id) {
      return {
        ...item,
        name: datos.name,
        description: datos.description,
        users: datos.users,
      };
    } else {
      return item;
    }
  });
};

onMounted(() => {
  getProjects();
});
</script>