<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue';



</script>

<template>
  <DefaultLayout>
    <v-container 
        fluid 
        class="fill-height"
        :style="{ backgroundImage: 'url(/images/login.avif)', backgroundSize: 'cover', backgroundPosition: 'center' }"
    >
      <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="6" lg="4">
          <v-card class="pa-4 text-center" elevation="6">
            <!-- Image at the top of the card -->
            <v-img
              src="/images/logo.jpg"
              alt="Omni Tickets Logo"
              containa
              height="150"
              class="mb-4"
            ></v-img>
            
            <v-card-title class="text-h5 font-weight-bold justify-center">
              Welcome to Omni Tickets
            </v-card-title>
            
            <v-card-subtitle class="text-subtitle-1 py-2">
              Host your events with us
            </v-card-subtitle>
            
            <v-card-text class="px-4 pb-4">
              <p class="text-body-1 mb-4">
                The easiest way to create, manage and sell tickets for your events
              </p>
              
              <!-- Get Started Button -->
               <InertiaLink :href="route('login')">
                <v-btn
                    color="success"
                    size="large"
                    
                    class="mt-2"
                    >
                        Get Started
                    <v-icon end>mdi-arrow-right</v-icon>
                </v-btn>
                </InertiaLink>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </DefaultLayout>
</template>

