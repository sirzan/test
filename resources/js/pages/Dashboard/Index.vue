<template>
    <Sidebar>
       
        <div class="card">
            <div class="card-header">
                <div class="d-flex gap-3">
                    <router-link to="/dashboard/posts" class="nav-link"><span class="fw-semibold">Lista de Posts</span></router-link>
                    <router-link to="/dashboard/projects" class="nav-link"><span class="fw-semibold">Lista de Proyectos</span></router-link>
                </div>
            </div>
            <div class="card-body">
                <router-view />
            </div>
        </div>
        
    </Sidebar>
</template>
<script setup>
import Sidebar from "../../components/layouts/Sidebar.vue";

</script>