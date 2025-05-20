import { ref } from 'vue'
import axios from 'axios'

const roles = ref([])

const fetchRoles = async () => {
  try {
    const res = await axios.get('/api/user-role')
    roles.value = res.data.roles
  } catch (error) {
    console.error('Erro ao buscar roles:', error)
  }
}

const hasRole = (role) => roles.value.includes(role)

export function useRole() {
  return {
    roles,
    fetchRoles,
    hasRole
  }
}