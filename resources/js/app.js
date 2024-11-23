import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia'


import '@fortawesome/fontawesome-free/css/all.css';

const app = createApp(App).use(router);

const pinia = createPinia()
app.use(pinia)

app.mount('#app');