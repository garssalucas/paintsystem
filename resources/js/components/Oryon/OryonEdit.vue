<template>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Editar Produto</h1>
    <OryonForm :produto="produto" :isEdit="true" @submit="atualizarProduto" />
  </div>
</template>

<script setup>
import OryonForm from './OryonForm.vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';

const route = useRoute();
const router = useRouter();

const produto = ref({
  codigo: '',
  descricao: '',
  preco: null,
  categoria: '',
  estoque: null
});

onMounted(async () => {
  try {
    const response = await axios.get(`/api/produtos_oryon/${route.params.id}`);
    produto.value = response.data;
  } catch (err) {
    alert('Erro ao carregar produto');
    router.push('/produtos_oryon');
  }
});

async function atualizarProduto(produtoAtualizado) {
  try {
    await axios.put(`/api/produtos_oryon/${route.params.id}`, produtoAtualizado);
    alert('Produto atualizado com sucesso!');
    router.push('/produtos_oryon');
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao atualizar produto');
  }
}
</script>