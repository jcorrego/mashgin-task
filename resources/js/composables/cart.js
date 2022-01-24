import {computed, ref} from 'vue'

export default function useCart() {
    const cart = ref({})
    const cart_errors = ref()
    const cart_order = ref()

    const addItem = (item) => {
        if (!(item.id in cart.value)) cart.value[item.id] = {
            'id': item.id,
            'name': item.name,
            'price': item.price,
            'image': item.image,
            'quantity': 0,
        }
        cart.value[item.id].quantity++
    }

    const removeItem = (item) => {
        if (item.id in cart.value && cart.value[item.id].quantity > 0) {
            cart.value[item.id].quantity--
            if (cart.value[item.id].quantity === 0) delete cart.value[item.id]
        }
    }

    const cart_subtotal = computed(() => {
        let total = 0
        for (const key in cart.value) {
            total += (cart.value[key].price * cart.value[key].quantity)
        }
        return total
    })

    const cart_tips = computed(() => {
        return cart_subtotal.value * 0.1
    })

    const cart_taxes = computed(() => {
        return (cart_subtotal.value + cart_tips.value) * 0.08
    })

    const cart_total = computed(() => {
        return cart_subtotal.value + cart_tips.value + cart_taxes.value
    })


    const sendPayment = async (data) => {
        cart_errors.value = {}
        try {
            let response = await axios.post('/api/orders', data)
            cart_order.value = response.data.data
            cart_errors.value = null
        } catch (e) {
            if (e.response.status === 422) {
                cart_errors.value = e.response.data.errors
            }
        }

    }

    return {
        cart,
        cart_subtotal,
        cart_tips,
        cart_taxes,
        cart_total,
        cart_errors,
        cart_order,
        addItem,
        removeItem,
        sendPayment,
    }
}
