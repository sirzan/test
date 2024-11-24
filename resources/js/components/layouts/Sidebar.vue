<template>
  <div class="" id="wrapper">
    <!-- Sidebar -->
    <div
      :class="[
        'bg-dark text-white',
        { 'd-none': !isSidebarVisible, 'd-md-block': true },
      ]"
      id="sidebar"
    >
      <div class="sidebar-heading my-3 px-2">Mi Proyecto</div>
      <div class="list-group list-group-flush">
        <!-- <router-link
          to="/"
          class="list-group-item list-group-item-action bg-dark text-white"
        >
          Inicio
        </router-link> -->
        <router-link
          to="/posts"
          class="list-group-item list-group-item-action bg-dark text-white"
        >
          Posteos
        </router-link>
        <router-link
          to="/projects"
          class="list-group-item list-group-item-action bg-dark text-white"
        >
          Proyectos
        </router-link>
        <a
          v-if="authStore.token"
          href=""
          @click.prevent="logout"
          class="list-group-item list-group-item-action bg-dark text-white"
        >
          Cerrar Sesión
        </a>
      </div>
    </div>

    <!-- Content Wrapper -->
    <div id="page-content-wrapper">
      <Navbar @toggleSidebar="toggleSidebar"></Navbar>
      <div class="container-fluid">
        <slot></slot>
        <!-- El contenido se inyecta aquí -->
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Navbar from "./Navbar.vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "../../stores/auth";

const authStore = useAuthStore();
const router = useRouter();
// Función para cerrar sesión
const logout = () => {
  authStore.logout();
  router.push("/");
};

// Estado para el sidebar
const isSidebarVisible = ref(false);

// Alternar visibilidad del sidebar
const toggleSidebar = () => {
  isSidebarVisible.value = !isSidebarVisible.value;
};
</script>

<style scoped>
#sidebar {
  height: 100vh;
  width: 250px;
  position: fixed;
  transition: transform 0.3s ease;
  z-index: 1050;
}

#page-content-wrapper {
  margin-left: 250px;
  transition: margin-left 0.3s ease;
}

@media (max-width: 768px) {
  #sidebar {
    transform: translateX(-100%);
  }
  #sidebar.d-block {
    transform: translateX(0);
  }

  #page-content-wrapper {
    margin-left: 0;
  }
}
</style>
