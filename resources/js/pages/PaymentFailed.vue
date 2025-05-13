<script setup></script>
<template>
    <v-container>
        <div class="glass pa-3">
            <v-card variant="flat" class="text-center max-auto" max-width="500" color="error">

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="50px"
                    height="50px"
                    viewBox="0 0 24 24"
               ><g fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M12 8v4"/><circle cx="12" cy="15" r="1" fill="currentColor"/><path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M3 10.417c0-3.198 0-4.797.378-5.335c.377-.537 1.88-1.052 4.887-2.081l.573-.196C10.405 2.268 11.188 2 12 2s1.595.268 3.162.805l.573.196c3.007 1.029 4.51 1.544 4.887 2.081C21 5.62 21 7.22 21 10.417v1.574c0 2.505-.837 4.437-2 5.913M3.193 14c.857 4.298 4.383 6.513 6.706 7.527c.721.315 1.082.473 2.101.473c1.02 0 1.38-.158 2.101-.473c.579-.252 1.231-.58 1.899-.994"/></g></svg>

               <v-card-title class="text-center">
                Payment Failed
               </v-card-title>
               <v-card-text>
                Please try again

               </v-card-text>
               <v-card-actions>
                   <InertiaLink :href="route('cart')" class="InertiaLink">
                       <v-btn block variant="outlined" size="large" color="white"  >
                           Go to Cart
                       </v-btn>
                   </InertiaLink>
                </v-card-actions>

            </v-card>

        </div>
    </v-container>
</template>