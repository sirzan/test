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
              <h3 class="mb-3 text-center">Inicio de sesión</h3>
              <form @submit.prevent="login">
                <input
                  type="email"
                  v-model="email"
                  class="form-control mb-3"
                  :class="{ 'is-invalid': emailError }"
                  placeholder="Correo electrónico"
                  required
                />
                <div v-if="emailError" class="invalid-feedback">
                  El correo electrónico es inválido.
                </div>
                <input
                  type="password"
                  v-model="password"
                  class="form-control mb-3"
                  :class="{ 'is-invalid': passwordError }"
                  placeholder="Contraseña"
                  required
                />
                <div v-if="passwordError" class="invalid-feedback">
                  La contraseña es incorrecta.
                </div>
                <div class="d-grid gap-2">
                  <button
                    class="btn btn-dark"
                    type="submit"
                    :disabled="loading"
                  >
                    Iniciar Sesión
                  </button>
                </div>
                <div class="mt-3 text-center">
                  <router-link to="/register">Crear nueva cuenta</router-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth"; // Importamos el store de Pinia

const email = ref("");
const password = ref("");
const emailError = ref(false);
const passwordError = ref(false);
const loading = ref(false);
const router = useRouter();
const authStore = useAuthStore();

// Función de login
const login = async () => {
  emailError.value = false;
  passwordError.value = false;

  // Validación simple
  if (!email.value || !password.value) {
    if (!email.value) emailError.value = true;
    if (!password.value) passwordError.value = true;
    return;
  }

  loading.value = true;

  try {
    // Enviamos la solicitud de login al backend con Axios
    const response = await axios.post("/api/login", {
      email: email.value,
      password: password.value,
    });

    // Guardamos el token y los datos del usuario en el store
    authStore.setAuthData(response.data.access_token, response.data.user);

    // Redirigimos a la página principal o al dashboard
    router.push("/dashboard");
  } catch (error) {
    // En caso de error, mostramos los errores
    if (error.response && error.response.status === 401) {
      passwordError.value = true; // Contraseña incorrecta
    } else {
      alert("Hubo un error al iniciar sesión");
    }
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  // Verificar si el usuario está autenticado al cargar el componente
  if (authStore.token) {
    // Si está autenticado, redirigir a la página principal
    router.push("/");
  }
});
</script>
  