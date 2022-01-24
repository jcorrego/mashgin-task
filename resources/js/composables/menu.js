import { ref } from 'vue'

export default function useMenu() {
    const menu = ref([])

    const getMenu = async () => {
        let response = await axios.get('/api/menu')
        menu.value = response.data.data
    }

    return {
        menu,
        getMenu,
    }
}
