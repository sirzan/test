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
              <form @submit.prevent="register">
                <input
                  type="text"
                  v-model="name"
                  :class="['form-control mb-3', { 'is-invalid': nameError, 'is-valid': name && !nameError }]"
                  placeholder="Nombre"
                  required
                />
                <div v-if="nameError" class="text-danger mb-3">
                  El nombre es obligatorio.
                </div>

                <input
                  type="email"
                  v-model="email"
                  :class="['form-control mb-3', { 'is-invalid': emailError, 'is-valid': email && !emailError }]"
                  placeholder="Correo electrónico"
                  required
                />
                <div v-if="emailError" class="text-danger mb-3">
                  El correo electrónico es obligatorio o inválido.
                </div>

                <input
                  type="password"
                  v-model="password"
                  :class="['form-control mb-3', { 'is-invalid': passwordError, 'is-valid': password && !passwordError }]"
                  placeholder="Contraseña"
                  required
                />
                <div v-if="passwordError" class="text-danger mb-3">
                  La contraseña es obligatoria.
                </div>

                <input
                  type="password"
                  v-model="confirmPassword"
                  :class="['form-control mb-3', { 'is-invalid': confirmPasswordError, 'is-valid': confirmPassword && !confirmPasswordError }]"
                  placeholder="Confirmar contraseña"
                  required
                />
                <div v-if="confirmPasswordError" class="text-danger mb-3">
                  Las contraseñas no coinciden.
                </div>

                <div class="d-grid gap-2">
                  <button class="btn btn-dark" type="submit" :disabled="loading">
                    Registrarse
                  </button>
                </div>
                <div class="mt-3">
                  <router-link to="/login">Iniciar sesión</router-link>
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
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth"; 

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");
const nameError = ref(false);
const emailError = ref(false);
const passwordError = ref(false);
const confirmPasswordError = ref(false);
const loading = ref(false);
const router = useRouter();
const authStore = useAuthStore();

// Función para validar los campos
const validateFields = () => {
  nameError.value = !name.value;
  emailError.value = !email.value || !/\S+@\S+\.\S+/.test(email.value); // Verificar formato de correo
  passwordError.value = !password.value;
  confirmPasswordError.value = password.value !== confirmPassword.value;
};

// Función de registro
const register = async () => {
  validateFields();

  // Verificar si hay errores
  if (nameError.value || emailError.value || passwordError.value || confirmPasswordError.value) {
    return;
  }

  loading.value = true;

  try {
    // Enviar solicitud de registro al backend con Axios
    const response = await axios.post("/api/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: confirmPassword.value,
    });

    // Guardar el token y los datos del usuario en el store
    authStore.setAuthData(response.data.access_token, response.data.user);

    // Redirigir a la página principal o dashboard
    router.push("/dashboard");
  } catch (error) {
    alert("Hubo un error al registrar el usuario");
  } finally {
    loading.value = false;
  }
};
</script>
