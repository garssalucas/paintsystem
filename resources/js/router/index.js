import { createRouter, createWebHistory } from 'vue-router';
import OryonList from '../components/Oryon/OryonList.vue';
import OryonCreate from '../components/Oryon/OryonCreate.vue';
import OryonEdit from '../components/Oryon/OryonEdit.vue';

const routes = [
  { path: '/dashboard', redirect: '/produtos_oryon' },
  { path: '/produtos_oryon', component: OryonList },
  { path: '/produtos_oryon/new', component: OryonCreate },
  { path: '/produtos_oryon/:id/edit', component: OryonEdit },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;