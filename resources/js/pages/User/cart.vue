<script setup>
import UserLayout from '@/layouts/UserLayout.vue';
import { router, usePage } from '@inertiajs/vue3';

const props = defineProps({
  cartItems: {
    type: Object,
    default: () => ({})
  },
  cartCount: Number,
  total: Number
});

const removeFromCart = (id) => {
  router.post(route('cart.remove', id), {}, { preserveScroll: true });
};
</script>

<template>
  <UserLayout>
    <v-container class="py-4">
      <v-row>
        <v-col cols="12">
          <v-card>
            <v-card-title class="text-h5">Your Cart</v-card-title>

            <v-card-text>
              <v-alert v-if="Object.keys(cartItems).length === 0" type="info" variant="tonal">
                Your cart is currently empty.
              </v-alert>

              <v-table v-else>
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Event</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, id) in cartItems" :key="id">
                    <td>
                      <v-img
                        v-if="item.attributes.image"
                        :src="'/storage/' + item.attributes.image"
                        height="60"
                        width="80"
                        contain
                      ></v-img>
                    </td>
                    <td>{{ item.name }}</td>
                    <td>${{ item.price }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>${{ item.price * item.quantity }}</td>
                    <td>
                      <v-btn icon color="red" @click="removeFromCart(id)">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </td>
                  </tr>
                </tbody>
              </v-table>
            </v-card-text>

            <v-card-actions v-if="Object.keys(cartItems).length > 0">
              <v-spacer />
              <v-btn color="green" class="ma-2" @click="router.visit('/checkout')">
                Proceed to Checkout
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </UserLayout>
</template>
