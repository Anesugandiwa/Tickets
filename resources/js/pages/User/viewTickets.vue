<template>
    <UserLayout>
      <v-container>
        <!-- Event Header Section -->
        <v-col cols="4" class="text-right">
                <v-btn icon :to="route('')" class="ma-2">
                    <v-badge :content="cartCount" color="red" overlap>
                        <v-icon size="32">mdi-cart</v-icon>
                    </v-badge>
                </v-btn>
            </v-col>

  
        <!-- Tickets Grid -->
        <v-card class="pa-6 mb-6">
          <h2 class="text-h4 mb-4">Available Tickets</h2>
          
          <v-row v-if="tickets.length > 0">
            <v-col
              v-for="ticket in tickets"
              :key="ticket.id"
              cols="12"
              md="6"
              lg="4"
            >
              <v-card variant="outlined" class="h-100">
                <v-img
                  :src="ticket.image"
                  height="150"
                  cover
                ></v-img>
                
                <v-card-text>
                  <h3 class="text-h6 mb-2">{{ ticket.name }}</h3>
                  <div class="text-subtitle-1 mb-2">
                    Price: {{ formatCurrency(ticket.price) }}
                  </div>
                  <div class="text-caption">
                    Available: {{ ticket.total_available }} remaining
                  </div>
                </v-card-text>
                
                <v-card-actions>
                  <v-btn
                    color="primary"
                    variant="flat"
                    block
                    @click="addTicketToCart(ticket)"
                    :disabled="ticket.total_available <= 0"
                  >
                    Add to Cart
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
          
          <v-alert
            v-else
            type="info"
            variant="tonal"
          >
            No tickets available for this event at the moment.
          </v-alert>
        </v-card>
      </v-container>
    </UserLayout>
  </template>
  
  <script setup>
  import UserLayout from '@/layouts/UserLayout.vue';
  import { router } from '@inertiajs/vue3';
  
  const props = defineProps({
    event: Object,
    tickets: Array,
  });
  
  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
    }).format(amount);
  };
  
  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    });
  };
  
  const addTicketToCart = (ticket) => {
    router.post(route('cart.add'), {
      ticket_id: ticket.id,
      // event_id: props.event.id,
      quantity: 1, // Default quantity
    }, {
      preserveScroll: true,
      onSuccess: () => {
        // Show success notification
        console.log('Ticket added to cart!');
      }
    });
  };
  </script>
  
  <style scoped>
  .v-card {
    transition: transform 0.3s ease;
  }
  
  .v-card:hover {
    transform: translateY(-5px);
  }
  </style>