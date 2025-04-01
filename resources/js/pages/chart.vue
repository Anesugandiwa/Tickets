<template>
  <div>
    <apexchart 
      width="500" 
      type="line" 
      :options="lineChartOptions" 
      :series="lineChartSeries"
    ></apexchart>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, defineProps} from "vue";

const props = defineProps({
  labels:  Array,
  dataset: Array,
})


// Chart options
const lineChartOptions = computed( () =>({
  chart: {
    id: "monthly-events-chart",
  },
  xaxis: {
    categories:  props.labels,
  },
}));

// Chart data
const lineChartSeries = computed( () =>([
  {
    name: "Events Created",
    data: props.dataset,
  },
]));
</script>
