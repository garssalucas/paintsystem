import '../css/app.css';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index';

window.Alpine = Alpine;
Alpine.start();

const app = createApp(App);
app.use(router);
app.mount('#app');