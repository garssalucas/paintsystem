import '../css/app.css';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './App.vue';
import OryonList from './components/Oryon/OryonList.vue'
//import Alert from './components/Alert.vue';

window.Alpine = Alpine;
Alpine.start();

const app = createApp(App);
app.component('oryon-list', OryonList);
app.mount('#app');
//const alert = createApp(Alert);
//app.component('alert', Alert);
//alert.mount('#alert');
