<template>
  <div class="max-w-4xl mx-auto p-6 bg-gray-800 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-2 text-white">
      {{ isEdit ? 'Informações do Produto -> ' + form.id : 'Novo Produto' }}
    </h2>
    <p class="mb-6 text-gray-400">
      {{ isEdit ? 'Atualize abaixo as informações do produto' : 'Informe os dados do produto' }}
    </p>

    <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <!-- Código -->
      <div>
        <label class="block text-gray-300 mb-1">Código:</label>
        <input v-model="form.codigo" placeholder="Código do Produto"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.codigo" class="text-red-400 text-sm mt-1">{{ errors.codigo[0] }}</p>
      </div>

      <!-- Preço -->
      <div>
        <label class="block text-gray-300 mb-1">Preço:</label>
        <input type="number" v-model="form.preco" placeholder="Preço do Produto"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.preco" class="text-red-400 text-sm mt-1">{{ errors.preco[0] }}</p>
      </div>

      <!-- Descrição -->
      <div class="md:col-span-2">
        <label class="block text-gray-300 mb-1">Descrição:</label>
        <input v-model="form.descricao" placeholder="Descrição do Produto"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.descricao" class="text-red-400 text-sm mt-1">{{ errors.descricao[0] }}</p>
      </div>

      <!-- Categoria -->
      <div>
        <label class="block text-gray-300 mb-1">Categoria:</label>
        <input v-model="form.categoria" placeholder="Categoria do Produto"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.categoria" class="text-red-400 text-sm mt-1">{{ errors.categoria[0] }}</p>
      </div>

      <!-- Fornecedor -->
      <div>
        <label class="block text-gray-300 mb-1">Fornecedor:</label>
        <input v-model="form.fornecedor" placeholder="Fornecedor do Produto"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.fornecedor" class="text-red-400 text-sm mt-1">{{ errors.fornecedor[0] }}</p>
      </div>

      <!-- Código do Fornecedor -->
      <div>
        <label class="block text-gray-300 mb-1">Código do Fornecedor:</label>
        <input v-model="form.codigo_fornecedor" placeholder="Código do Fornecedor"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.codigo_fornecedor" class="text-red-400 text-sm mt-1">{{ errors.codigo_fornecedor[0] }}</p>
      </div>

      <!-- Peso -->
      <div>
        <label class="block text-gray-300 mb-1">Peso:</label>
        <input type="number" v-model="form.peso" placeholder="Peso do Produto"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.peso" class="text-red-400 text-sm mt-1">{{ errors.peso[0] }}</p>
      </div>

      <!-- Preço de Compra -->
      <div>
        <label class="block text-gray-300 mb-1">Preço de Compra:</label>
        <input type="number" v-model="form.preco_compra" placeholder="Preço de Compra do Produto"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.preco_compra" class="text-red-400 text-sm mt-1">{{ errors.preco_compra[0] }}</p>
      </div>

      <!-- Estoque -->
      <div>
        <label class="block text-gray-300 mb-1">Estoque:</label>
        <input type="number" v-model="form.estoque" placeholder="Estoque do Produto"
          class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p v-if="errors.estoque" class="text-red-400 text-sm mt-1">{{ errors.estoque[0] }}</p>
      </div>

      <!-- Botões -->
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

const errors = ref({})
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

function validateForm() {
  errors.value = {} // limpa todos os erros do frontend

  if (!form.value.codigo || form.value.codigo.length > 25)
    errors.value.codigo = ['Código é obrigatório e deve ter no máximo 25 caracteres.']

  if (!form.value.descricao || form.value.descricao.length > 128)
    errors.value.descricao = ['Descrição é obrigatória e deve ter no máximo 128 caracteres.']

  if (form.value.preco === '' || isNaN(form.value.preco) || form.value.preco < 0 || form.value.preco > 99999999.99)
    errors.value.preco = ['Preço é obrigatório, deve ser numérico e entre 0 e 99999999.99.']

  if (!form.value.categoria || form.value.categoria.length > 64)
    errors.value.categoria = ['Categoria é obrigatória e deve ter no máximo 64 caracteres.']

  if (!form.value.fornecedor || form.value.fornecedor.length > 64)
    errors.value.fornecedor = ['Fornecedor é obrigatório e deve ter no máximo 64 caracteres.']

  if (form.value.codigo_fornecedor && form.value.codigo_fornecedor.length > 64)
    errors.value.codigo_fornecedor = ['Código do fornecedor deve ter no máximo 64 caracteres.']

  if (form.value.peso !== '' && (isNaN(form.value.peso) || form.value.peso < 0 || form.value.peso > 999999.99))
    errors.value.peso = ['Peso deve ser um número entre 0 e 999999.99.']

  if (form.value.preco_compra !== '' && (isNaN(form.value.preco_compra) || form.value.preco_compra < 0 || form.value.preco_compra > 99999999.99))
    errors.value.preco_compra = ['Preço de compra deve ser um número entre 0 e 99999999.99.']

  if (form.value.estoque !== '' && (isNaN(form.value.estoque) || form.value.estoque < 0 || form.value.estoque > 99999999.99))
    errors.value.estoque = ['Estoque deve ser um número entre 0 e 99999999.99.']

  return Object.keys(errors.value).length === 0
}

async function submitForm() {
  if (!validateForm()) return

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
  if (error.response?.status === 422) {
    errors.value = error.response.data.errors
  } else {
    console.error('Erro inesperado ao salvar produto:', error)
    alert('Erro inesperado ao salvar o produto. Tente novamente mais tarde.')
  }
}
}
</script>