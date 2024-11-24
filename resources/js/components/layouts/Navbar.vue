<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light w-100">
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/posts" class="nav-link d-sm-none"
            >Posteos</router-link
          >
        </li>
        <li class="nav-item">
          <router-link to="/projects" class="nav-link d-sm-none"
            >Proyectos</router-link
          >
        </li>
      </ul>
    </div>
  </nav>
</template>
  
  <script>
export default {
  name: "Navbar",
};
</script>


