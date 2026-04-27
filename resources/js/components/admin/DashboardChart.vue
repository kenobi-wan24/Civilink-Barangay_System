<template>
  <div style="position:relative;height:220px">
    <canvas ref="chartRef"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {
  Chart,
  BarElement,
  BarController,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend,
} from 'chart.js'

Chart.register(BarElement, BarController, CategoryScale, LinearScale, Tooltip, Legend)

const props = defineProps({
  labels: { type: Array, required: true },
  values: { type: Array, required: true },
})

const chartRef = ref(null)

onMounted(() => {
  new Chart(chartRef.value, {
    type: 'bar',
    data: {
      labels: props.labels,
      datasets: [{
        data:            props.values,
        backgroundColor: props.values.map((_, i) =>
          i === props.values.length - 1 ? '#2D5A27' : '#c8dfc5'
        ),
        borderRadius:    6,
        borderSkipped:   false,
      }],
    },
    options: {
      responsive:          true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => ` ${ctx.parsed.y} residents`,
          },
          backgroundColor: '#1a1a1a',
          padding:         10,
          cornerRadius:    8,
        },
      },
      scales: {
        x: {
          grid:  { display: false },
          ticks: { color: '#9ca3af', font: { size: 11 } },
          border: { display: false },
        },
        y: {
          grid:  { color: '#f3f4f6' },
          ticks: { color: '#9ca3af', font: { size: 11 } },
          border: { display: false },
          beginAtZero: true,
        },
      },
    },
  })
})
</script>