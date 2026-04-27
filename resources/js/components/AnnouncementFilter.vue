<template>
  <div>
    <div class="relative mb-4">
      <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
             stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-4.35-4.35M17 11A6 6 0 111 11a6 6 0 0116 0z"/>
        </svg>
      </span>
      <input
        v-model="search"
        type="text"
        placeholder="Search news..."
        @keyup.enter="submit"
        class="w-full bg-white border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
               text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] transition-all"
      />
    </div>

    <div class="flex flex-wrap gap-2">
      <button
        v-for="cat in categories" :key="cat.value"
        type="button"
        @click="selectCategory(cat.value)"
        class="text-xs font-semibold px-4 py-1.5 rounded-full border transition-all"
        :class="active === cat.value
          ? 'bg-[#2D5A27] text-white border-[#2D5A27]'
          : 'bg-white text-gray-600 border-gray-200 hover:border-[#2D5A27] hover:text-[#2D5A27]'"
      >
        {{ cat.label }}
      </button>
    </div>

    <form :action="action" method="GET" ref="formRef" class="hidden">
      <input type="hidden" name="search"   :value="search"/>
      <input type="hidden" name="category" :value="active"/>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  initialSearch:   { type: String, default: '' },
  initialCategory: { type: String, default: 'all' },
  action:          { type: String, required: true },
})

const search   = ref(props.initialSearch)
const active   = ref(props.initialCategory || 'all')
const formRef  = ref(null)

const categories = [
  { label: 'All',        value: 'all' },
  { label: 'Events',     value: 'events' },
  { label: 'Advisories', value: 'advisories' },
  { label: 'Projects',   value: 'projects' },
]

function selectCategory(val) {
  active.value = val
  submit()
}

function submit() {
  formRef.value?.submit()
}
</script>