<template>
  <div>
    <!-- Tab switcher -->
    <div class="flex bg-gray-100 rounded-xl p-1 mb-7">
      <button
        type="button"
        @click="tab = 'login'"
        class="flex-1 text-sm font-semibold py-2 rounded-lg transition-all duration-200"
        :class="tab === 'login'
          ? 'bg-white text-[#2D5A27] shadow-sm'
          : 'text-gray-400 hover:text-gray-600'"
      >
        Sign In
      </button>
      <button
        type="button"
        @click="tab = 'register'"
        class="flex-1 text-sm font-semibold py-2 rounded-lg transition-all duration-200"
        :class="tab === 'register'
          ? 'bg-white text-[#2D5A27] shadow-sm'
          : 'text-gray-400 hover:text-gray-600'"
      >
        Register
      </button>
    </div>

    <!-- ── Sign In form ── -->
    <form
      v-if="tab === 'login'"
      method="POST"
      :action="loginAction"
      @submit="handleSubmit('login')"
      novalidate
    >
      <input type="hidden" name="_token" :value="csrf"/>

      <!-- Email -->
      <div class="mb-5">
        <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
          Email or Username
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </span>
          <input
            v-model="login.email"
            type="email"
            name="email"
            placeholder="e.g. juan.delacruz@email.com"
            autocomplete="email"
            class="w-full bg-gray-100 border border-transparent rounded-xl pl-10 pr-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            :class="{ 'border-red-400 bg-red-50': serverErrors.email }"
          />
        </div>
        <p v-if="serverErrors.email" class="mt-1.5 text-xs text-red-500">
          {{ serverErrors.email[0] }}
        </p>
      </div>

      <!-- Password -->
      <div class="mb-6">
        <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
          Password
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
          </span>
          <input
            v-model="login.password"
            :type="showLoginPassword ? 'text' : 'password'"
            name="password"
            placeholder="••••••••"
            autocomplete="current-password"
            class="w-full bg-gray-100 border border-transparent rounded-xl pl-10 pr-12 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            :class="{ 'border-red-400 bg-red-50': serverErrors.password }"
          />
          <button type="button" @click="showLoginPassword = !showLoginPassword"
            class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
            <svg v-if="!showLoginPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>
          </button>
        </div>
        <p v-if="serverErrors.password" class="mt-1.5 text-xs text-red-500">
          {{ serverErrors.password[0] }}
        </p>
      </div>

      <!-- Security notice -->
      <div class="flex items-start gap-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 mb-6">
        <svg class="w-4 h-4 text-[#2D5A27] mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/>
        </svg>
        <p class="text-xs text-gray-500 leading-relaxed">
          Secure encryption active. Only authorized residents may proceed.
        </p>
      </div>

      <button type="submit" :disabled="loading"
        class="w-full bg-[#2D5A27] hover:bg-[#3d7a35] disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold text-sm py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
        <svg v-if="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
        <span>{{ loading ? 'Signing in...' : 'Sign In to Portal' }}</span>
        <svg v-if="!loading" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
      </button>
    </form>

    <!-- ── Register form ── -->
    <form
      v-if="tab === 'register'"
      method="POST"
      :action="registerAction"
      @submit="handleSubmit('register')"
      novalidate
    >
      <input type="hidden" name="_token" :value="csrf"/>

      <!-- Full name -->
      <div class="mb-4">
        <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
          Full Name
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </span>
          <input
            v-model="register.name"
            type="text"
            name="name"
            placeholder="Juan Dela Cruz"
            autocomplete="name"
            class="w-full bg-gray-100 border border-transparent rounded-xl pl-10 pr-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            :class="{ 'border-red-400 bg-red-50': regErrors.name }"
          />
        </div>
        <p v-if="regErrors.name" class="mt-1.5 text-xs text-red-500">{{ regErrors.name[0] }}</p>
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
          Email Address
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
          </span>
          <input
            v-model="register.email"
            type="email"
            name="email"
            placeholder="juan@email.com"
            autocomplete="email"
            class="w-full bg-gray-100 border border-transparent rounded-xl pl-10 pr-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            :class="{ 'border-red-400 bg-red-50': regErrors.email }"
          />
        </div>
        <p v-if="regErrors.email" class="mt-1.5 text-xs text-red-500">{{ regErrors.email[0] }}</p>
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
          Password
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
          </span>
          <input
            v-model="register.password"
            :type="showRegPassword ? 'text' : 'password'"
            name="password"
            placeholder="Min. 8 characters"
            autocomplete="new-password"
            class="w-full bg-gray-100 border border-transparent rounded-xl pl-10 pr-12 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            :class="{ 'border-red-400 bg-red-50': regErrors.password }"
          />
          <button type="button" @click="showRegPassword = !showRegPassword"
            class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
            <svg v-if="!showRegPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>
          </button>
        </div>
        <p v-if="regErrors.password" class="mt-1.5 text-xs text-red-500">{{ regErrors.password[0] }}</p>
      </div>

      <!-- Confirm password -->
      <div class="mb-6">
        <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
          Confirm Password
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
          </span>
          <input
            v-model="register.password_confirmation"
            :type="showRegPassword ? 'text' : 'password'"
            name="password_confirmation"
            placeholder="Re-enter your password"
            autocomplete="new-password"
            class="w-full bg-gray-100 border border-transparent rounded-xl pl-10 pr-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            :class="{ 'border-red-400 bg-red-50': passwordMismatch }"
          />
        </div>
        <p v-if="passwordMismatch" class="mt-1.5 text-xs text-red-500">Passwords do not match.</p>
      </div>

      <!-- Info notice -->
      <div class="flex items-start gap-3 bg-[#E8F5E3] border border-[#b8ddb4] rounded-xl px-4 py-3 mb-6">
        <svg class="w-4 h-4 text-[#2D5A27] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-xs text-[#2D5A27] leading-relaxed">
          After registering, barangay staff will link your account to your resident profile. You can start requesting documents right away.
        </p>
      </div>

      <button type="submit" :disabled="loading || passwordMismatch"
        class="w-full bg-[#2D5A27] hover:bg-[#3d7a35] disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold text-sm py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
        <svg v-if="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
        <span>{{ loading ? 'Creating account...' : 'Create Resident Account' }}</span>
      </button>

    </form>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  loginAction:    { type: String, required: true },
  registerAction: { type: String, required: true },
  csrf:           { type: String, required: true },
  serverErrors:   { type: Object, default: () => ({}) },
  regErrors:      { type: Object, default: () => ({}) },
  defaultTab:     { type: String, default: 'login' },
  old:            { type: Object, default: () => ({}) },
})

const tab             = ref(props.defaultTab)
const loading         = ref(false)
const showLoginPassword = ref(false)
const showRegPassword   = ref(false)

const login = ref({
  email:    props.old.email ?? '',
  password: '',
})

const register = ref({
  name:                  props.old.name ?? '',
  email:                 props.old.reg_email ?? '',
  password:              '',
  password_confirmation: '',
})

const passwordMismatch = computed(() =>
  register.value.password_confirmation.length > 0 &&
  register.value.password !== register.value.password_confirmation
)

function handleSubmit(type) {
  if (type === 'register' && passwordMismatch.value) return
  loading.value = true
}
</script>