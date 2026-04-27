<template>
  <form method="POST" :action="action" @submit="handleSubmit" novalidate>
    <input type="hidden" name="_token" :value="csrf"/>

    <!-- Name + Email row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
          Full Name
        </label>
        <input
          v-model="form.name"
          type="text"
          name="name"
          placeholder="Juan Dela Cruz"
          class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3
                 text-sm text-gray-700 placeholder-gray-400 focus:outline-none
                 focus:border-[#2D5A27] focus:bg-white transition-all"
          :class="{ 'border-red-400 bg-red-50': errors.name }"
        />
        <p v-if="errors.name" class="mt-1 text-xs text-red-500">
          {{ errors.name[0] }}
        </p>
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
          Email Address
        </label>
        <input
          v-model="form.email"
          type="email"
          name="email"
          placeholder="juan@example.com"
          class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3
                 text-sm text-gray-700 placeholder-gray-400 focus:outline-none
                 focus:border-[#2D5A27] focus:bg-white transition-all"
          :class="{ 'border-red-400 bg-red-50': errors.email }"
        />
        <p v-if="errors.email" class="mt-1 text-xs text-red-500">
          {{ errors.email[0] }}
        </p>
      </div>
    </div>

    <!-- Purpose dropdown -->
    <div class="mb-4">
      <label class="block text-xs font-semibold text-gray-600 mb-1.5">
        Purpose of Inquiry
      </label>
      <div class="relative">
        <select
          v-model="form.purpose"
          name="purpose"
          class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3
                 text-sm text-gray-700 appearance-none focus:outline-none
                 focus:border-[#2D5A27] focus:bg-white transition-all"
        >
          <option value="">General Inquiry</option>
          <option value="Document Request">Document Request</option>
          <option value="Complaint">Complaint or Concern</option>
          <option value="Suggestion">Suggestion</option>
          <option value="Emergency">Emergency Report</option>
          <option value="Other">Other</option>
        </select>
        <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
               stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </span>
      </div>
    </div>

    <!-- Message -->
    <div class="mb-6">
      <label class="block text-xs font-semibold text-gray-600 mb-1.5">
        Message
      </label>
      <textarea
        v-model="form.message"
        name="message"
        rows="5"
        placeholder="How can we assist you today?"
        class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3
               text-sm text-gray-700 placeholder-gray-400 focus:outline-none
               focus:border-[#2D5A27] focus:bg-white transition-all resize-none"
        :class="{ 'border-red-400 bg-red-50': errors.message }"
      ></textarea>
      <div class="flex items-center justify-between mt-1">
        <p v-if="errors.message" class="text-xs text-red-500">
          {{ errors.message[0] }}
        </p>
        <span class="text-xs text-gray-400 ml-auto">
          {{ form.message.length }} / 2000
        </span>
      </div>
    </div>

    <!-- Submit -->
    <button
      type="submit"
      :disabled="loading"
      class="w-full bg-[#2D5A27] hover:bg-[#3d7a35] disabled:opacity-60
             disabled:cursor-not-allowed text-white font-semibold text-sm
             py-3.5 rounded-xl transition-all flex items-center justify-center gap-2"
    >
      <svg v-if="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10"
                stroke="currentColor" stroke-width="4"/>
        <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
      </svg>
      <span>{{ loading ? 'Sending...' : 'Send Message' }}</span>
    </button>

  </form>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  action: { type: String, required: true },
  csrf:   { type: String, required: true },
  errors: { type: Object, default: () => ({}) },
  old:    { type: Object, default: () => ({}) },
})

const loading = ref(false)

const form = ref({
  name:    props.old.name    ?? '',
  email:   props.old.email   ?? '',
  purpose: props.old.purpose ?? '',
  message: props.old.message ?? '',
})

function handleSubmit() {
  loading.value = true
}
</script>