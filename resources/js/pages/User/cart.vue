<script setup>
import UserLayout from '@/layouts/UserLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import {ref} from 'vue'
import axios from 'axios';

const dialog = ref(false);
const loading = ref(false);
const btnloading = ref(false);
const loadMessage = ref('');
const retries = ref(18);
let callbackHandler = null;

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
const page = usePage();

const paynowForm = useForm({
    customerPhoneNumber: '',
    amount: page.props.total,
    reason: 'Ticket Purchase',
});

const rules = {
  customerPhoneNumber: [
    v => !!v || 'phone is required',
    v => (v ? v.length === 10 : false) || 'Phone number must have 10 characters',
    v => /07[1,8,7]\d{7}/.test(v) || 'Please enter a valid Econet or OneMoney number',
  ],
};

// Function to open the payment dialog
const openPaymentDialog = () => {
  dialog.value = true;
};

const makePayment = async () => {
  if (!paynowForm.customerPhoneNumber) {
    Swal.fire({
      icon: 'warning',
      title: 'Missing Phone Number',
      text: 'Please enter your phone number to proceed.',
    });
    return;
  }

  btnloading.value = true;

  try {
    const response = (await axios.post(route('make-payment'), paynowForm)).data;

    if (response.status === 'failed') {
      Swal.fire({
        icon: 'error',
        title: 'Payment Error',
        text: response.message || 'Something went wrong.',
      });
      return;
    }

    loadMessage.value = response.message;
    loading.value = true;

    const poll = new FormData();
    poll.append('ref_num', response.ref_num);

    callbackHandler = setInterval(async () => {
      const pollResponse = (await axios.post(route('pese-return'), poll)).data;

      if (pollResponse.status === 'paid') {
        clearInterval(callbackHandler);
        markAsPaid(pollResponse.ref_num);
        return;
      }

      if (retries.value <= 1) {
        clearInterval(callbackHandler);
        markAsFailed();
        return;
      }

      retries.value--;
    }, 200);

  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Payment Error',
      text: 'Something went wrong. Please try again.',
    });
  } finally {
    btnloading.value = false;
    dialog.value = false; // Close dialog
  }
};

const markAsPaid = (refNum) => {
  Swal.fire('Success', 'Payment received!', 'success');
};

const markAsFailed = () => {
  Swal.fire('Error', 'Payment failed or timed out.', 'error');
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
              <v-btn color="green" class="ma-2" @click="openPaymentDialog">
                Proceed to Checkout
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- EcoCash Payment Dialog -->
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title class="text-h5">Enter Payment Details</v-card-title>
        
        <v-card-text>
          <v-form @submit.prevent="makePayment">
            <v-text-field
              v-model="paynowForm.customerPhoneNumber"
              label="EcoCash or OneMoney Phone Number"
              placeholder="07XXXXXXXX"
              :rules="rules.customerPhoneNumber"
              prepend-icon="mdi-phone"
              required
              hint="Enter your EcoCash or OneMoney number"
              persistent-hint
            ></v-text-field>
            
            <div class="text-subtitle-1 mt-4">
              Total Amount: ${{ total }}
            </div>
          </v-form>
          
          <!-- Loading Overlay -->
          <v-overlay 
            v-model="loading"
            contained
            class="align-center justify-center"
          >
            <v-progress-circular
              indeterminate
              color="primary"
              size="64"
            ></v-progress-circular>
            <div class="mt-4">{{ loadMessage }}</div>
          </v-overlay>
        </v-card-text>
        
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" @click="dialog = false">Cancel</v-btn>
          <v-btn 
            color="primary" 
            @click="makePayment" 
            :loading="btnloading"
            :disabled="!paynowForm.customerPhoneNumber || loading"
          >
            Pay Now
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </UserLayout>
</template>