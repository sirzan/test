<template>
  <Sidebar>
    <div class="px-3 py-3">
      <div class="card mb-3" v-for="item in listPosts" :key="item.id">
        <div class="card-body">
          <h2>{{ item.title }}</h2>
          <p>
            {{ item.content }}
          </p>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-between mb-3">
            <h5>
              Comentarios
              <span class="badge text-bg-secondary">{{
                item?.comments.length
              }}</span>
            </h5>
            <AddComment :info="item" :callback="addNewComment"></AddComment>
          </div>
          <div
            class="card mb-3"
            v-for="comment in item?.comments"
            :key="comment.id"
          >
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <span class="fw-bold">{{ comment.user.name }}</span>
                <span class="fw-semibold">{{ comment.created_at }}</span>
              </div>
              <p class="m-0 p-0">{{ comment.content }}</p>
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
    const { data } = await axios.get("/api/posts");
    listPosts.value = data;
  } catch (error) {
    console.log(error);
  }
};

const addNewComment = (datos) => {
  listPosts.value = listPosts.value.map((item) => {
    if (item.id === datos.post_id) {
      return {
        ...item,
        comments: { datos, ...item.comments },
      };
    } else {
      return item;
    }
  });
};

onMounted(() => {
  getPost();
});
</script>