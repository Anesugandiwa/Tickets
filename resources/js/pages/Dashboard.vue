<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

// Access the props directly from the component
const props = defineProps({
    organisers: {
        type: [Array, Number], // Accepts both array and number
        default: () => [],
    },
    events: {
        type: [Array, Number],
        default: () => [],
    },

    labels: Array,
    dataset: Array,

    organiserLabels: Array,
    organiserDataset: Array,

    organiserLabels:{
        type: Array,
        default: ()=>[],
    },

    organiserDataset: {
        type: Array,
        default: () =>[],
    },
});


// Helper function to get the count regardless of whether it's an array or direct number
const getCount = (value) => {
    return typeof value === 'number' ? value : value.length;
};

const options = {
    chart: {
        id: 'events-chat',
    },
    xaxis: {
        categories: props.labels,
    },
    stroke: {
        curve: 'smooth', // Set curve to 'smooth' for a smooth line chart
        width: 2,
    },
    dataLabels: {
        enabled: false,
    },
};

const series = [
    {
        name: 'Events',
        data: props.dataset,
    },
];

const organiserOptions ={
    chart: {
        id: 'organiser-bar',
        toolbar: {
            show:false,
        }
    },

    xaxis : {
        categories: props.organiserLabels,
    },
    plotOptions: {
        bar: {
            borderRadius: 5,
            horizontal: false,
        },
    },


};
const organiserSeries = [
    {
        name: 'organiser',
        data:props.organiserDataset,
    }
]

</script>

<template>
    <AdminLayout>
        <Head title="Dashboard" />
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="6" lg="4" sm="3">
                    <v-card class="pa-4 mb-4" height="100%" color="blue" dark>
                        <v-card-title class="text-h6"> Total number of Organisers </v-card-title>
                        <v-card-text class="text-h4 font-weight-bold">
                            {{ getCount(organisers) }}
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="4" sm="3">
                    <v-card class="pa-4 mb-4" height="100%" color="blue" dark>
                        <v-card-title class="text-h6"> Total events </v-card-title>
                        <v-card-text class="text-h4 font-weight-bold">
                            {{ getCount(events) }}
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col>
                    <apexchart width="500" type="area" :options="options" :series="series"></apexchart>
                </v-col>
                <v-col>
                    <apexchart width="500" type="bar" :options="organiserOptions" :series="organiserSeries"></apexchart>
                </v-col>


            </v-row>
        </v-container>
    </AdminLayout>
</template>
