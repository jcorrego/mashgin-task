import { ref } from 'vue'
import axios from 'axios'

export default function useMenu() {
    const item = ref([])
    const menu = ref([])

    const errors = ref('')

    const getMenu = async () => {
        let response = await axios.get('/api/menu')
        menu.value = response.data.data
    }

    const getItem = async (id) => {
        let response = await axios.get(`/api/items/${id}`)
        item.value = response.data.data
    }

    return {
        errors,
        item,
        menu,
        getItem,
        getMenu,
    }
}
