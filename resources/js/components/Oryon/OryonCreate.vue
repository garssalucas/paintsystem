<template>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Criar Produto</h1>
    <OryonForm :produto="produto" @submit="criarProduto" />
  </div>
</template>

<script setup>
import OryonForm from './OryonForm.vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { reactive } from 'vue';

const router = useRouter();

const produto = reactive({
  codigo: '',
  descricao: '',
  preco: null,
  categoria: '',
  estoque: null
});

async function criarProduto(produto) {
  try {
    await axios.get('/sanctum/csrf-cookie');
    await axios.post('/api/produtos_oryon', produto);
    alert('Produto criado com sucesso!');
    router.push('/produtos_oryon');
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao criar produto');
  }
}
</script>