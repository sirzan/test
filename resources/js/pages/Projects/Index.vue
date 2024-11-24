<template>
  <Sidebar>
    <div class="px-3 py-3">
      <div class="card mb-3" v-for="item in listPosts" :key="item.id">
        <div class="card-body">
          <h2>Proyecto: {{ item.name }}</h2>
          <p>
            Descripción: {{ item.description }}
          </p>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-between mb-3">
            <h5>
              Usuarios
              <span class="badge text-bg-secondary">{{
                item?.users.length
              }}</span>
            </h5>
          </div>
          <div class="card mb-3">
            <div class="card-body">
              <div class="">
                <span
                  v-for="user in item?.users"
                  :key="user.id"
                  class="badge text-bg-secondary me-3"
                  >{{ user.name }}</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Sidebar>
</template>
<script setup>
import Sidebar from "../../components/layouts/Sidebar.vue";
import AddComment from "../../components/Posts/comments/AddComment.vue";
import { onMounted, ref } from "vue";

const listPosts = ref([]);

const getPost = async () => {
  try {
    const { data } = await axios.get("/api/projects");
    listPosts.value = data;
  } catch (error) {
    console.log(error);
  }
};

onMounted(() => {
  getPost();
});
</script>