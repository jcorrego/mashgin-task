<template>
    <div class="bg-white">
        <!-- Background color split screen for large screens -->
        <div class="hidden lg:block fixed top-0 left-0 w-2/3 h-full bg-white" aria-hidden="true"/>
        <div class="hidden lg:block fixed top-0 right-0 w-1/3 h-full bg-indigo-900" aria-hidden="true"/>

        <div class="relative grid grid-cols-1 gap-x-16 mx-auto lg:px-8 lg:grid-cols-3 lg:pt-16">
            <section aria-labelledby="summary-cart" class="bg-indigo-900 text-indigo-300 py-12 md:px-10 lg:max-w-lg lg:w-full lg:mx-auto lg:px-0 lg:pt-0 lg:pb-24 lg:bg-transparent lg:row-start-1 lg:col-start-3">
                <div class="max-w-2xl mx-auto px-4 lg:max-w-none lg:px-0">
                    <dl>
                        <dt class="text-sm font-medium">Amount due</dt>
                        <dd class="mt-1 text-3xl font-extrabold text-white">${{ cart_total.toFixed(2) }}</dd>
                    </dl>

                    <ul role="list" class="text-sm font-medium divide-y divide-white divide-opacity-10">
                        <li v-for="item in cart" :key="item.id" class="flex items-start py-6 space-x-4">
                            <img :src="item.image" :alt="item.name"
                                 class="flex-none w-20 h-20 rounded-md object-center object-cover"/>
                            <div class="flex-auto space-y-1">
                                <h3 class="text-white">{{ item.name }}</h3>
                                <p>${{ item.price.toFixed(2) }} x {{ item.quantity }}</p>
                            </div>
                            <p class="flex-none text-base font-medium text-white">
                                ${{ (item.price * item.quantity).toFixed(2) }}</p>
                        </li>
                    </ul>

                    <dl class="text-sm font-medium space-y-6 border-t border-white border-opacity-10 pt-6">
                        <div class="flex items-center justify-between">
                            <dt>Subtotal</dt>
                            <dd>${{ cart_subtotal.toFixed(2) }}</dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt>Tips (10%)</dt>
                            <dd>${{ cart_tips.toFixed(2) }}</dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt>Taxes (8%)</dt>
                            <dd>${{ cart_taxes.toFixed(2) }}</dd>
                        </div>

                        <div
                            class="flex items-center justify-between border-t border-white border-opacity-10 text-white pt-6">
                            <dt class="text-base">Total</dt>
                            <dd class="text-base">${{ cart_total.toFixed(2) }}</dd>
                        </div>
                        <div class="mt-10 flex justify-end pt-6 border-t border-gray-200">
                            <button @click="checkout = true" v-if="cart_subtotal > 0" type="submit"
                                    class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
                                Go to payment
                            </button>
                        </div>
                    </dl>
                </div>
            </section>
            <section v-if="checkout" aria-labelledby="payment-and-summary" class="py-16 lg:max-w-lg lg:w-full lg:mx-auto lg:pt-0 lg:pb-24 lg:row-start-1 lg:col-start-1 lg:col-span-2">
                <form @submit.prevent="pay">
                    <div v-if="cart_errors" class="rounded-md bg-red-50 p-4">
                        <div class="flex">

                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    There were some errors with your submission
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul role="list" class="list-disc pl-5 space-y-1">
                                        <li v-for="error in cart_errors">
                                            {{ error[0] }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-2xl mx-auto px-4 lg:max-w-none lg:px-0">
                        <div>
                            <h3 id="contact-info-heading" class="text-lg font-medium text-gray-900">Contact
                                information</h3>
                            <div class="mt-6">
                                <label for="email-address" class="block text-sm font-medium text-gray-700">Email
                                    address</label>
                                <div class="mt-1">
                                    <input v-model="form.email" type="email" id="email-address" name="email-address"
                                           autocomplete="email"
                                           class="block w-full rounded-md shadow-sm  sm:text-sm"
                                           :class="cart_errors && cart_errors.email ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'"/>
                                    <p v-if="cart_errors && cart_errors.email" class="mt-2 text-sm text-red-600"
                                       id="email-error">{{ cart_errors.email[0] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-lg font-medium text-gray-900">Payment details</h3>

                            <div class="mt-6 grid grid-cols-3 sm:grid-cols-4 gap-y-6 gap-x-4">
                                <div class="col-span-3 sm:col-span-4">
                                    <label for="card-number" class="block text-sm font-medium text-gray-700">Card
                                        number</label>
                                    <div class="mt-1">
                                        <input v-model="form.cc_number" type="text" id="card-number" name="card-number"
                                               autocomplete="cc-number"
                                               class="block w-full rounded-md shadow-sm sm:text-sm"
                                               :class="cart_errors && cart_errors.cc_number ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'"/>
                                        <p v-if="cart_errors && cart_errors.cc_number" class="mt-2 text-sm text-red-600"
                                           id="card-number-error">{{ cart_errors.cc_number[0] }}</p>
                                    </div>
                                </div>

                                <div class="col-span-2 sm:col-span-3">
                                    <label for="expiration-date" class="block text-sm font-medium text-gray-700">Expiration
                                        date (MM/YY)</label>
                                    <div class="mt-1">
                                        <input v-model="form.cc_date" type="text" name="expiration-date"
                                               id="expiration-date" autocomplete="cc-exp"
                                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               :class="cart_errors && cart_errors.cc_date ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'"/>
                                        <p v-if="cart_errors && cart_errors.cc_date" class="mt-2 text-sm text-red-600"
                                           id="expiration-date-error">{{ cart_errors.cc_date[0] }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                                    <div class="mt-1">
                                        <input v-model="form.cc_cvc" type="text" name="cvc" id="cvc" autocomplete="csc"
                                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               :class="cart_errors && cart_errors.cc_cvc ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'"/>
                                        <p v-if="cart_errors && cart_errors.cc_cvc" class="mt-2 text-sm text-red-600"
                                           id="cvc-error">{{ cart_errors.cc_cvc[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-lg font-medium text-gray-900">Billing information</h3>

                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                                <div class="sm:col-span-3">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <div class="mt-1">
                                        <input v-model="form.address" type="text" id="address" name="address"
                                               autocomplete="street-address"
                                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               :class="cart_errors && cart_errors.address ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'"/>
                                        <p v-if="cart_errors && cart_errors.address" class="mt-2 text-sm text-red-600"
                                           id="address-error">{{ cart_errors.address[0] }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <div class="mt-1">
                                        <input v-model="form.city" type="text" id="city" name="city"
                                               autocomplete="address-level2"
                                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               :class="cart_errors && cart_errors.city ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'"/>
                                        <p v-if="cart_errors && cart_errors.city" class="mt-2 text-sm text-red-600"
                                           id="city-error">{{ cart_errors.city[0] }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="region" class="block text-sm font-medium text-gray-700">State /
                                        Province</label>
                                    <div class="mt-1">
                                        <input v-model="form.state" type="text" id="region" name="region"
                                               autocomplete="address-level1"
                                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               :class="cart_errors && cart_errors.state ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'"/>
                                        <p v-if="cart_errors && cart_errors.state" class="mt-2 text-sm text-red-600"
                                           id="state-error">{{ cart_errors.state[0] }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal
                                        code</label>
                                    <div class="mt-1">
                                        <input v-model="form.postal" type="text" id="postal-code" name="postal-code"
                                               autocomplete="postal-code"
                                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               :class="cart_errors && cart_errors.postal ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'"/>
                                        <p v-if="cart_errors && cart_errors.postal" class="mt-2 text-sm text-red-600"
                                           id="postal-error">{{ cart_errors.postal[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end pt-6 border-t border-gray-200">
                            <button @click="checkout = false" type="button"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
                                Pay now
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <section v-else-if="cart_order" aria-labelledby="confirmation" class="py-16 lg:w-full lg:mx-auto lg:pt-0 lg:pb-24 lg:row-start-1 lg:col-start-1 lg:col-span-2">
                <div class="max-w-2xl mx-auto py-16 px-4 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8 lg:py-32">
                    <div class="">
                        <h1 class="text-sm font-medium text-indigo-600">Payment successful</h1>
                        <p class="mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Thanks for
                            ordering</p>
                        <p class="mt-2 text-base text-gray-500">We appreciate your order, we’re currently processing it.
                            So hang tight and we’ll send you confirmation very soon!</p>

                        <dl class="mt-16 text-sm font-medium">
                            <dt class="text-gray-900">Tracking number</dt>
                            <dd class="mt-2 text-indigo-600">Order # {{ cart_order.id }}-{{ cart_order.uuid }}</dd>
                        </dl>
                    </div>
                    <div class="mt-10 flex justify-start pt-6 border-t border-gray-200">
                        <button @click="newOrder" type="button"
                                class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
                            New order
                        </button>
                    </div>
                </div>
            </section>
            <section v-else aria-labelledby="categories-and-products" class="py-16 lg:w-full lg:mx-auto lg:pt-0 lg:pb-24 lg:row-start-1 lg:col-start-1 lg:col-span-2">
                <div>
                    <hr class="my-4">
                    <h2 class="mb-4">Select a category</h2>
                    <div class="grid grid-cols-3 gap-x-2 sm:grid-cols-4 sm:gap-x-6">
                        <div v-for="(category, index) in menu" :key="category.id"
                             class="group aspect-w-2 aspect-h-1 rounded-lg overflow-hidden sm:relative  sm:aspect-w-1"
                             :class="index == 1 ? 'sm:aspect-h-1 sm:col-span-2' : 'sm:aspect-h-2' "
                             @click="selectedCategory = index">
                            <img :src="category.image" :alt="category.name"
                                 class="object-center object-cover group-hover:opacity-75"/>
                            <div aria-hidden="true" class="bg-gradient-to-b to-black"
                                 :class="selectedCategory == index ? 'from-black opacity-75' : 'from-transparent opacity-50'"/>
                            <div class="p-2 sm:p-6 flex items-end">
                                <div>
                                    <h3 class="text-white"
                                        :class="selectedCategory == index ? 'font-bold' : 'font-semibold'">
                                        <a href="#"><span class="absolute inset-0"/>
                                            {{ category.name }}
                                        </a>
                                    </h3>
                                    <p aria-hidden="true" class="mt-1 text-sm text-white">
                                        {{ category.items.length }} Items
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="selectedCategory >= 0" class="py-6">
                        <hr class="my-4">
                        <h2 class="mb-4">Products in the <strong>{{ menu[selectedCategory].name }}</strong> category</h2>

                        <div class="grid grid-cols-3 gap-y-10 gap-x-2 sm:grid-cols-4 sm:gap-x-6">
                            <div v-for="item in menu[selectedCategory].items" :key="item.id"
                                 class="group cursor-pointer">
                                <div
                                    class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
                                    <img @click="addItem(item)" :src="item.image" :alt="item.name"
                                         class="w-full h-full object-center object-cover group-hover:opacity-75"/>
                                </div>
                                <div class="mt-4 mb-2 flex items-center justify-between">
                                    <h3 class=" text-sm text-gray-700 py-0.5">
                                        {{ item.name }}
                                    </h3>
                                    <span v-if="cart[item.id]"
                                          class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-indigo-100 text-indigo-800">
                                            x
                                            {{ cart[item.id].quantity }}
                                        </span>
                                </div>

                                <div class="flex flex-col items-start sm:flex-row sm:justify-between sm:items-center">
                                    <p class="mt-1 text-lg font-medium text-gray-900">
                                        ${{ item.price }}
                                    </p>
                                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                            <button @click="removeItem(item)" type="button"
                                                    class="relative inline-flex items-center px-2 py-1 rounded-l-md border border-gray-300 bg-white text-sm font-bold text-red-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                              -
                                            </button>
                                            <button @click="addItem(item)" type="button"
                                                    class="-ml-px relative inline-flex items-center px-2 py-1 rounded-r-md border border-gray-300 bg-white text-sm font-bold text-green-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                              +
                                            </button>
                                          </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import {computed, onMounted, reactive, ref} from 'vue';

import useMenu from '../composables/menu'

const {menu, getMenu} = useMenu()
onMounted(getMenu)
const selectedCategory = ref(-1)
const checkout = ref(false)

import useCart from '../composables/cart'

const {
    addItem,
    removeItem,
    sendPayment,
    cart,
    cart_subtotal,
    cart_tips,
    cart_taxes,
    cart_total,
    cart_errors,
    cart_order,
} = useCart()

const form = reactive({
    email: '',
    cc_number: '',
    cc_date: '',
    cc_cvc: '',
    address: '',
    city: '',
    state: '',
    postal: '',
})

const pay = async () => {
    await sendPayment({
        total: cart_total.value,
        cart: cart.value,
        ...form
    })
    if (!cart_errors.value && cart_order.value) checkout.value = false
}

const newOrder = () => {
    cart.value = {}
    checkout.value = false
    cart_order.value = null
}

</script>
