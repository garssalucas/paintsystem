import './bootstrap';
import '../css/app.css';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './App.vue';

window.Alpine = Alpine;
Alpine.start();

// Inicializa o Vue e o anexa ao #app
const app = createApp(App);
app.mount('#app');