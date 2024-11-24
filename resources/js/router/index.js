import { createRouter, createWebHistory } from "vue-router";
import routes from "virtual:generated-pages";

import { useAuthStore } from "@/stores/auth"; // Importar el store de autenticación


const router = createRouter({
    history: createWebHistory("/"),
    routes,
});


// Usamos un guardia global para proteger las rutas
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
  
    // Verificar si el usuario está autenticado
    authStore.checkAuth();
  
    // Rutas protegidas
    const publicPages = ['/posts', '/projects', '/','/login','/register']; // Páginas públicas
  
    if (!authStore.token && !publicPages.includes(to.path)) {
      // Si no está autenticado, redirigir a login
      return next('/login');
    }
  
    if (authStore.token && (to.path === '/login' || to.path === '/register')) {
        // Si el usuario está autenticado y trata de acceder a login o register, redirigir a home u otra página
        return next('/');
      }
    // Permitir la navegación si todo está bien
    next();
  });

export default router;
