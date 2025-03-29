import '../css/app.css';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './App.vue';
import Alert from './components/Alert.vue';

window.Alpine = Alpine;
Alpine.start();

const app = createApp(App);
app.mount('#app');
const alert = createApp(Alert);
app.component('alert', Alert);
alert.mount('#alert');