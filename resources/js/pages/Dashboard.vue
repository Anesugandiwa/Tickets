
<script setup>
    import AdminLayout from '@/layouts/AdminLayout.vue';
    import {ref, onMounted} from 'vue';
    import axios from 'axios';
    import { Head } from '@inertiajs/vue3';
    


// Access the props directly from the component
const props = defineProps({
    organisers: {
        type: [Array, Number], // Accepts both array and number
        default: () => []
    },
    events: {
        type: [Array, Number],
        default: () => []
    }
});

// Helper function to get the count regardless of whether it's an array or direct number
const getCount = (value) => {
    return typeof value === 'number' ? value : value.length;
}

</script>

<template>
    <AdminLayout>
        <Head title="Dashboard" />
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="6" lg="4" sm="3" >
                    <v-card class="pa-4 mb-4" height="100%">
                        <v-card-title class="text-h6">
                            Total number of Organisers
                        </v-card-title>
                        <v-card-text class="text-h4 font-weight-bold">
                            {{ getCount(organisers) }}
                        </v-card-text>
                    </v-card>

                </v-col>
                
                <v-col cols="12" md="6" lg="4" sm="3">
                    <v-card class="pa-4 mb-4" height="100%">
                        <v-card-title class="text-h6">
                            Total events
                        </v-card-title>
                        <v-card-text class="text-h4 font-weight-bold">
                            {{ getCount(events) }}
                        </v-card-text>
                    </v-card>


                </v-col>
            </v-row>

        </v-container>

        

        
    </AdminLayout>
</template>
