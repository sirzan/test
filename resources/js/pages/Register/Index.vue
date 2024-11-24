<template>
  <div
    style="height: 100vh"
    class="bg-dark d-flex align-items-center justify-content-center"
  >
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-5">
          <div class="card">
            <div class="card-body">
              <h3 class="mb-3 text-center">Registro de usuarios</h3>
              <input
                type="text"
                class="form-control mb-3"
                placeholder="Nombre"
              />
              <input
                type="text"
                class="form-control mb-3"
                placeholder="Correo electrónico"
              />
              <input
                type="password"
                class="form-control mb-3"
                placeholder="Contraseña"
              />
              <input
                type="password"
                class="form-control mb-3"
                placeholder="Confirmar contraseña"
              />
              <div class="d-grid gap-2">
                <button class="btn btn-dark">Registrarse</button>
              </div>
              <div class="mt-3">
                <router-link to="/login">Iniciar Sesión</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>