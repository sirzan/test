import { defineStore } from 'pinia';

export const useAuthStore = defineStore({
  id: 'auth',
  state: () => ({
    user: null,
    token: null,
  }),
  actions: {
    setAuthData(token, user) {
        this.token = token;
        this.user = user;
        localStorage.setItem('token', token);  // Guardar el token en localStorage
      },
    logout() {
      this.user = null;
      this.token = null;
      localStorage.removeItem('token');
      
    },
    checkAuth() {
      const token = localStorage.getItem('token');
      if (token) {
        this.token = token;
      }
    },
  },
});
