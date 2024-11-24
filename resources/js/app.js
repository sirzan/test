import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia'
import VueSweetalert2 from 'vue-sweetalert2';


import '@fortawesome/fontawesome-free/css/all.css';
import 'sweetalert2/dist/sweetalert2.min.css';
const app = createApp(App).use(router);

const pinia = createPinia()
app.use(pinia)
app.use(VueSweetalert2)

app.mount('#app');