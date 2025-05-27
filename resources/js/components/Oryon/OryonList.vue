<template>
  <div class="pb-12 pt-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Campo de busca -->
      <input v-model="search" type="text" name="search" id="search"
        placeholder="Pesquisar produtos por descrição ou código"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" />
      <br />

      <!-- Tabela -->
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-none md:table-fixed">
              <thead class="bg-gray-300 dark:bg-gray-700">
                <tr>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Código</th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Descrição</th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Preço</th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Categoria</th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Estoque</th>
                  <th v-if="hasRole('administradores')"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Ações</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-600 divide-y divide-gray-200 dark:divide-gray-500">
                <tr v-for="(produto, index) in produtosPaginados" :key="produto.id" :class="{
                  'bg-white dark:bg-gray-800': index % 2 === 0,
                  'bg-gray-200 dark:bg-gray-700': index % 2 !== 0,
                }">
                  <td class="px-6 py-4 whitespace-normal">{{ produto.codigo }}</td>
                  <td class="px-6 py-4 whitespace-normal">{{ produto.descricao }}</td>
                  <td class="px-6 py-4 whitespace-normal">R$ {{ formatPreco(produto.preco) }}</td>
                  <td class="px-6 py-4 whitespace-normal">{{ produto.categoria }}</td>
                  <td class="px-6 py-4 whitespace-normal">{{ formatEstoque(produto.estoque) }}</td>
                  <td v-if="hasRole('administradores')"
                    class="px-6 py-4 whitespace-normal inline-flex items-center justify-start space-x-2">
                    <!-- Visualizar -->
                    <details title="Detalhes">
                      <summary class="list-none appearance-none cursor-pointer">👁️</summary>
                      <div
                        class="absolute z-10 mt-1 bg-white dark:bg-gray-800 border rounded shadow text-sm p-2 space-y-1 w-56">
                        <p><strong>Custo:</strong> R$ {{ formatPreco(produto.preco_compra) }}</p>
                        <p><strong>Peso:</strong> {{ produto.peso }}Kg</p>
                        <p><strong>Fornecedor:</strong> {{ produto.fornecedor }}</p>
                        <p><strong>Cód. Fornecedor:</strong> {{ produto.codigo_fornecedor }}</p>
                      </div>
                    </details>
                    <router-link :to="`/produtos_oryon/${produto.id}/edit`" title="Editar">
                      ✏️
                    </router-link>
                    <button @click="excluirProduto(produto)" title="Excluir">
                      🗑️
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="flex justify-between items-center mt-6">
            <div class="flex justify-between items-center mt-4">
              <div class="flex items-center space-x-2">
                <span>Exibindo {{ exibindoDe }} até {{ exibindoAte }} de {{ total }} produtos</span>
                <div class="relative inline-block">
                  <select v-model="perPage" class="appearance-none border rounded p-1 pr-8 bg-gray-900 text-gray-300">
                    <option :value="30">30</option>
                    <option :value="50">50</option>
                    <option :value="100">100</option>
                    <option :value="200">200</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-300">
                  </div>
                </div>
              </div>
            </div>
            <div class="flex space-x-2">
              <router-link :to="'/produtos_oryon/new'"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 flex items-center">
                ➕ Novo Produto
              </router-link>
              <button @click="importarProdutos"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 flex items-center">
                ⬇️ Atualizar Produtos
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'
import axios from 'axios'
import { useRole } from '../../composables/useRole'

const { fetchRoles, hasRole } = useRole()

const produtos = ref([])
const search = ref('')
const perPage = ref(30)
const currentPage = ref(1)

const total = computed(() => produtosFiltradosOrdenados.value.length)

const produtosFiltradosOrdenados = computed(() => {
  const palavras = search.value.toLowerCase().split(/\s+/)
  return produtos.value
    .filter(produto => {
      const texto = `${produto.codigo} ${produto.descricao}`.toLowerCase()
      return palavras.every(palavra => texto.includes(palavra))
    })
    .sort((a, b) => a.descricao.localeCompare(b.descricao))
})

const produtosPaginados = computed(() => {
  const start = (currentPage.value - 1) * perPage.value
  const end = start + perPage.value
  return produtosFiltradosOrdenados.value.slice(start, end)
})

const exibindoDe = computed(() => {
  return total.value === 0 ? 0 : (currentPage.value - 1) * perPage.value + 1
})

const exibindoAte = computed(() => {
  return Math.min(currentPage.value * perPage.value, total.value)
})

async function loadProdutos() {
  try {
    await axios.get('/sanctum/csrf-cookie')
    const response = await axios.get('/api/produtos_oryon')
    produtos.value = response.data
  } catch (error) {
    console.error('Erro ao buscar produtos:', error)
  }
}

const formatPreco = (preco) => {
  return parseFloat(preco).toFixed(2).replace('.', ',')
}

const formatEstoque = (valor) => {
  return parseInt(valor).toLocaleString('pt-BR')
}

async function excluirProduto(produto) {
  if (!confirm(`Deseja excluir o produto "${produto.descricao} | Código: ${produto.codigo}"?`)) return

  try {
    const res = await axios.delete(`/api/produtos_oryon/${produto.id}`)
    alert(res.data.message)
    produtos.value = produtos.value.filter(p => p.id !== produto.id)
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao excluir produto')
  }
}

async function importarProdutos() {
  if (!confirm('Tem certeza que deseja atualizar os produtos?')) return

  try {
    const res = await axios.post('/api/produtos_oryon/importar')
    alert(res.data.message)
    loadProdutos()
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao importar produtos')
  }
}

onMounted(() => {
  fetchRoles()
  loadProdutos()
})
</script>