<template>
  <div class="max-w-4xl mx-auto p-6 bg-gray-800 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-2 text-white">
      {{ isEdit ? 'Informações do Produto -> ' + form.id : 'Novo Produto' }}
    </h2>
    <p class="mb-6 text-gray-400">
      {{ isEdit ? 'Atualize abaixo as informações do produto' : 'Informe os dados do produto' }}
    </p>

    <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-300 mb-1">Código:</label>
        <input v-model="form.codigo" :placeholder="isEdit ? '' : 'Código do Produto'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 mb-1">Descrição:</label>
        <input v-model="form.descricao" :placeholder="isEdit ? '' : 'Descrição do Produto'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 mb-1">Preço:</label>
        <input type="number" v-model="form.preco" :placeholder="isEdit ? '' : 'Preço do Produto'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 mb-1">Categoria:</label>
        <input v-model="form.categoria" :placeholder="isEdit ? '' : 'Categoria do Produto'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 mb-1">Fornecedor:</label>
        <input v-model="form.fornecedor" :placeholder="isEdit ? '' : 'Fornecedor do Produto'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 mb-1">Código do Fornecedor:</label>
        <input v-model="form.codigo_fornecedor" :placeholder="isEdit ? '' : 'Código do Fornecedor'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 mb-1">Peso:</label>
        <input type="number" v-model="form.peso" :placeholder="isEdit ? '' : 'Peso do Produto'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 mb-1">Preço de Compra:</label>
        <input type="number" v-model="form.preco_compra" :placeholder="isEdit ? '' : 'Preço de Compra do Produto'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="md:col-span-2">
        <label class="block text-gray-300 mb-1">Estoque:</label>
        <input type="number" v-model="form.estoque" :placeholder="isEdit ? '' : 'Estoque do Produto'"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="md:col-span-2 flex justify-between mt-4">
        <router-link to="/produtos_oryon"
          class="px-4 py-2 border border-gray-400 text-gray-400 rounded hover:bg-gray-700">
          Voltar
        </router-link>

        <button type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          {{ isEdit ? 'Salvar' : 'Criar' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const form = ref({
  id: null,
  codigo: '',
  descricao: '',
  preco: '',
  categoria: '',
  fornecedor: '',
  codigo_fornecedor: '',
  peso: '',
  preco_compra: '',
  estoque: ''
})

const isEdit = ref(false)

onMounted(() => {
  const id = route.params.id
  if (id) {
    isEdit.value = true
    loadProduto(id)
  }
})

async function loadProduto(id) {
  try {
    await axios.get('/sanctum/csrf-cookie')
    const response = await axios.get(`/api/produtos_oryon/${id}`)
    form.value = { ...response.data }
  } catch (error) {
    console.error('Erro ao carregar produto:', error)
    alert('Erro ao carregar produto.')
    router.push('/produtos_oryon')
  }
}

async function submitForm() {
  try {
    await axios.get('/sanctum/csrf-cookie')
    if (isEdit.value) {
      await axios.put(`/api/produtos_oryon/${form.value.id}`, form.value)
      alert('Produto atualizado com sucesso!')
    } else {
      await axios.post('/api/produtos_oryon', form.value)
      alert('Produto criado com sucesso!')
    }
    router.push('/produtos_oryon')
  } catch (error) {
    console.error('Erro ao salvar produto:', error)
    alert('Erro ao salvar produto.')
  }
}
</script>