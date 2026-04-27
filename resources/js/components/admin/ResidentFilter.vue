<template>
  <form :action="action" method="GET" ref="formRef"
        style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">

    <!-- Zone -->
    <div class="relative">
      <div class="bg-white border border-gray-200 rounded-xl px-4 py-3
                  flex items-center gap-8 cursor-pointer min-w-[180px]"
           @click="open = open === 'zone' ? null : 'zone'">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Zone / District
          </p>
          <p class="text-sm font-semibold text-gray-700 mt-0.5">
            {{ zoneLabel }}
          </p>
        </div>
        <svg class="w-4 h-4 text-gray-400 ml-auto flex-shrink-0"
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
      </div>
      <div v-if="open === 'zone'"
           class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                  rounded-xl shadow-lg z-30 py-1 min-w-full">
        <button v-for="opt in zoneOptions" :key="opt.value" type="button"
                @click="select('zone', opt.value); open = null"
                class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50
                       transition-colors"
                :class="zone === opt.value
                  ? 'text-[#2D5A27] font-semibold'
                  : 'text-gray-700'">
          {{ opt.label }}
        </button>
      </div>
      <input type="hidden" name="zone" :value="zone"/>
    </div>

    <!-- Gender -->
    <div class="relative">
      <div class="bg-white border border-gray-200 rounded-xl px-4 py-3
                  flex items-center gap-8 cursor-pointer min-w-[160px]"
           @click="open = open === 'gender' ? null : 'gender'">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Gender
          </p>
          <p class="text-sm font-semibold text-gray-700 mt-0.5">
            {{ genderLabel }}
          </p>
        </div>
        <svg class="w-4 h-4 text-gray-400 ml-auto flex-shrink-0"
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
      </div>
      <div v-if="open === 'gender'"
           class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                  rounded-xl shadow-lg z-30 py-1 min-w-full">
        <button v-for="opt in genderOptions" :key="opt.value" type="button"
                @click="select('gender', opt.value); open = null"
                class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50
                       transition-colors"
                :class="gender === opt.value
                  ? 'text-[#2D5A27] font-semibold'
                  : 'text-gray-700'">
          {{ opt.label }}
        </button>
      </div>
      <input type="hidden" name="gender" :value="gender"/>
    </div>

    <!-- Status -->
    <div class="relative">
      <div class="bg-white border border-gray-200 rounded-xl px-4 py-3
                  flex items-center gap-8 cursor-pointer min-w-[180px]"
           @click="open = open === 'status' ? null : 'status'">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Status Focus
          </p>
          <p class="text-sm font-semibold text-gray-700 mt-0.5">
            {{ statusLabel }}
          </p>
        </div>
        <svg class="w-4 h-4 text-gray-400 ml-auto flex-shrink-0"
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
      </div>
      <div v-if="open === 'status'"
           class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                  rounded-xl shadow-lg z-30 py-1 min-w-full">
        <button v-for="opt in statusOptions" :key="opt.value" type="button"
                @click="select('status', opt.value); open = null"
                class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50
                       transition-colors"
                :class="status === opt.value
                  ? 'text-[#2D5A27] font-semibold'
                  : 'text-gray-700'">
          {{ opt.label }}
        </button>
      </div>
      <input type="hidden" name="status" :value="status"/>
    </div>

    <!-- hidden search passthrough -->
    <input type="hidden" name="search" :value="search"/>

  </form>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'

const props = defineProps({
  action:      { type: String, required: true },
  initZone:    { type: String, default: '' },
  initGender:  { type: String, default: '' },
  initStatus:  { type: String, default: '' },
  initSearch:  { type: String, default: '' },
})

const open   = ref(null)
const zone   = ref(props.initZone)
const gender = ref(props.initGender)
const status = ref(props.initStatus)
const search = ref(props.initSearch)
const formRef = ref(null)

const zoneOptions = [
  { label: 'All Zones',   value: '' },
  { label: 'Purok 1',     value: 'Purok 1' },
  { label: 'Purok 2',     value: 'Purok 2' },
  { label: 'Purok 3',     value: 'Purok 3' },
  { label: 'Purok 4',     value: 'Purok 4' },
  { label: 'Zone 1',      value: 'Zone 1' },
  { label: 'Zone 2',      value: 'Zone 2' },
  { label: 'Zone 3',      value: 'Zone 3' },
]

const genderOptions = [
  { label: 'All Genders', value: '' },
  { label: 'Male',        value: 'male' },
  { label: 'Female',      value: 'female' },
  { label: 'Other',       value: 'other' },
]

const statusOptions = [
  { label: 'All Residents',    value: '' },
  { label: 'Voters',           value: 'voter' },
  { label: 'Senior Citizens',  value: 'senior' },
  { label: 'PWD',              value: 'pwd' },
  { label: 'Solo Parents',     value: 'solo_parent' },
  { label: 'Inactive',         value: 'inactive' },
]

const zoneLabel   = computed(() => zoneOptions.find(o => o.value === zone.value)?.label   ?? 'All Zones')
const genderLabel = computed(() => genderOptions.find(o => o.value === gender.value)?.label ?? 'All Genders')
const statusLabel = computed(() => statusOptions.find(o => o.value === status.value)?.label ?? 'All Residents')

async function select(field, value) {
  if (field === 'zone')   zone.value   = value
  if (field === 'gender') gender.value = value
  if (field === 'status') status.value = value
  await nextTick()
  formRef.value?.submit()
}
</script>