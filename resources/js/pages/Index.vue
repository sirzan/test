<template>
  <Sidebar>
    <div>
      <h1>Welcome to the Administration Panel</h1>
      <p>This is the home page of your admin panel.</p>
    </div>
  </Sidebar>
</template>
  
  <script setup>
  import { onMounted } from "vue";
import Sidebar from "../components/layouts/Sidebar.vue";
import { useRouter } from "vue-router";
const router = useRouter();
onMounted(() => {
  router.push("/posts");
});
</script>
  
  <style>
/* Estilos opcionales */
</style>
  