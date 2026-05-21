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


    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <!-- ── Register form (multi-step) ──────────────────────────────────────── -->
    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <form
      v-if="tab === 'register'"
      method="POST"
      :action="registerAction"
      enctype="multipart/form-data"
      @submit="handleSubmit('register')"
      novalidate
    >
      <input type="hidden" name="_token" :value="csrf"/>

      <!-- Step indicator -->
      <div class="flex items-center justify-between mb-7">
        <template v-for="(label, idx) in stepLabels" :key="idx">
          <!-- Step bubble -->
          <div class="flex flex-col items-center gap-1">
            <div
              class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200"
              :class="registerStep > idx + 1
                ? 'bg-[#2D5A27] text-white'
                : registerStep === idx + 1
                  ? 'bg-[#2D5A27] text-white ring-4 ring-[#2D5A27]/20'
                  : 'bg-gray-200 text-gray-400'"
            >
              <!-- Checkmark for completed steps -->
              <svg v-if="registerStep > idx + 1" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
              <span v-else>{{ idx + 1 }}</span>
            </div>
            <span class="text-[10px] font-medium text-center leading-tight"
              :class="registerStep === idx + 1 ? 'text-[#2D5A27]' : 'text-gray-400'"
            >{{ label }}</span>
          </div>
          <!-- Connector line (not after last step) -->
          <div v-if="idx < stepLabels.length - 1"
            class="flex-1 h-0.5 mx-2 mb-4 rounded transition-all duration-300"
            :class="registerStep > idx + 1 ? 'bg-[#2D5A27]' : 'bg-gray-200'"
          ></div>
        </template>
      </div>

      <!-- Server-side validation errors (shown at the top of step 1 on return) -->
      <div v-if="hasRegErrors && registerStep === 1" class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
        <p class="text-xs font-semibold text-red-600 mb-1">Please fix the following:</p>
        <ul class="text-xs text-red-500 list-disc list-inside space-y-0.5">
          <li v-for="(msgs, field) in regErrors" :key="field">{{ msgs[0] }}</li>
        </ul>
      </div>


      <!-- ── STEP 1: Account credentials ────────────────────────────────────── -->
      <div v-show="registerStep === 1">
        <p class="text-xs text-gray-400 mb-5">This will be used to log in to the resident portal.</p>

        <!-- Email -->
        <div class="mb-4">
          <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
            Email Address <span class="text-red-400">*</span>
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
              :class="{ 'border-red-400 bg-red-50': stepErrors.email || regErrors.email }"
            />
          </div>
          <p v-if="stepErrors.email" class="mt-1.5 text-xs text-red-500">{{ stepErrors.email }}</p>
          <p v-else-if="regErrors.email" class="mt-1.5 text-xs text-red-500">{{ regErrors.email[0] }}</p>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
            Password <span class="text-red-400">*</span>
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
              :class="{ 'border-red-400 bg-red-50': stepErrors.password || regErrors.password }"
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
          <p v-if="stepErrors.password" class="mt-1.5 text-xs text-red-500">{{ stepErrors.password }}</p>
          <p v-else-if="regErrors.password" class="mt-1.5 text-xs text-red-500">{{ regErrors.password[0] }}</p>
        </div>

        <!-- Confirm password -->
        <div class="mb-6">
          <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
            Confirm Password <span class="text-red-400">*</span>
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
              :class="{ 'border-red-400 bg-red-50': stepErrors.password_confirmation || passwordMismatch }"
            />
          </div>
          <p v-if="stepErrors.password_confirmation" class="mt-1.5 text-xs text-red-500">{{ stepErrors.password_confirmation }}</p>
          <p v-else-if="passwordMismatch" class="mt-1.5 text-xs text-red-500">Passwords do not match.</p>
        </div>

        <button type="button" @click="nextStep"
          class="w-full bg-[#2D5A27] hover:bg-[#3d7a35] text-white font-semibold text-sm py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
          Continue
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </button>
      </div>


      <!-- ── STEP 2: Personal information ───────────────────────────────────── -->
      <div v-show="registerStep === 2">
        <p class="text-xs text-gray-400 mb-5">Your personal details for the barangay record.</p>

        <!-- First + Middle name row -->
        <div class="grid grid-cols-2 gap-3 mb-4">
          <div>
            <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
              First Name <span class="text-red-400">*</span>
            </label>
            <input
              v-model="register.first_name"
              type="text"
              name="first_name"
              placeholder="Juan"
              class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
              :class="{ 'border-red-400 bg-red-50': stepErrors.first_name }"
            />
            <p v-if="stepErrors.first_name" class="mt-1.5 text-xs text-red-500">{{ stepErrors.first_name }}</p>
          </div>
          <div>
            <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
              Middle Name
            </label>
            <input
              v-model="register.middle_name"
              type="text"
              name="middle_name"
              placeholder="Santos"
              class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            />
          </div>
        </div>

        <!-- Last name + Suffix row -->
        <div class="grid grid-cols-3 gap-3 mb-4">
          <div class="col-span-2">
            <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
              Last Name <span class="text-red-400">*</span>
            </label>
            <input
              v-model="register.last_name"
              type="text"
              name="last_name"
              placeholder="Dela Cruz"
              class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
              :class="{ 'border-red-400 bg-red-50': stepErrors.last_name }"
            />
            <p v-if="stepErrors.last_name" class="mt-1.5 text-xs text-red-500">{{ stepErrors.last_name }}</p>
          </div>
          <div>
            <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
              Suffix
            </label>
            <select
              v-model="register.suffix"
              name="suffix"
              class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all appearance-none"
            >
              <option value="">None</option>
              <option>Jr.</option>
              <option>Sr.</option>
              <option>II</option>
              <option>III</option>
              <option>IV</option>
            </select>
          </div>
        </div>

        <!-- Date of Birth + Gender -->
        <div class="grid grid-cols-2 gap-3 mb-4">
          <div>
            <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
              Date of Birth <span class="text-red-400">*</span>
            </label>
            <input
              v-model="register.birthdate"
              type="date"
              name="birthdate"
              class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
              :class="{ 'border-red-400 bg-red-50': stepErrors.birthdate }"
            />
            <p v-if="stepErrors.birthdate" class="mt-1.5 text-xs text-red-500">{{ stepErrors.birthdate }}</p>
          </div>
          <div>
            <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
              Gender <span class="text-red-400">*</span>
            </label>
            <select
              v-model="register.reg_gender"
              name="reg_gender"
              class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all appearance-none"
              :class="{ 'border-red-400 bg-red-50': stepErrors.reg_gender }"
            >
              <option value="" disabled>Select</option>
              <option>Male</option>
              <option>Female</option>
            </select>
            <p v-if="stepErrors.reg_gender" class="mt-1.5 text-xs text-red-500">{{ stepErrors.reg_gender }}</p>
          </div>
        </div>

        <!-- Civil Status + Contact -->
        <div class="grid grid-cols-2 gap-3 mb-6">
          <div>
            <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
              Civil Status <span class="text-red-400">*</span>
            </label>
            <select
              v-model="register.reg_civil_status"
              name="reg_civil_status"
              class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all appearance-none"
              :class="{ 'border-red-400 bg-red-50': stepErrors.reg_civil_status }"
            >
              <option value="" disabled>Select</option>
              <option>Single</option>
              <option>Married</option>
              <option>Widowed</option>
              <option>Separated</option>
              <option>Annulled</option>
            </select>
            <p v-if="stepErrors.reg_civil_status" class="mt-1.5 text-xs text-red-500">{{ stepErrors.reg_civil_status }}</p>
          </div>
          <div>
            <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
              Contact Number
            </label>
            <input
              v-model="register.reg_contact"
              type="tel"
              name="reg_contact"
              placeholder="+63 9XX XXX XXXX"
              class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            />
          </div>
        </div>

        <!-- Navigation -->
        <div class="flex gap-3">
          <button type="button" @click="registerStep = 1"
            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm py-3.5 rounded-xl transition-all">
            Back
          </button>
          <button type="button" @click="nextStep"
            class="flex-1 bg-[#2D5A27] hover:bg-[#3d7a35] text-white font-semibold text-sm py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
            Continue
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </button>
        </div>
      </div>


      <!-- ── STEP 3: Address + ID upload ────────────────────────────────────── -->
      <div v-show="registerStep === 3">
        <p class="text-xs text-gray-400 mb-5">Your location and supporting document for verification.</p>

        <!-- Purok / Zone -->
        <div class="mb-4">
          <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
            Purok / Zone <span class="text-red-400">*</span>
          </label>
          <input
            v-model="register.reg_purok_zone"
            type="text"
            name="reg_purok_zone"
            placeholder="e.g. Purok 3 – Mabini"
            class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all"
            :class="{ 'border-red-400 bg-red-50': stepErrors.reg_purok_zone }"
          />
          <p v-if="stepErrors.reg_purok_zone" class="mt-1.5 text-xs text-red-500">{{ stepErrors.reg_purok_zone }}</p>
        </div>

        <!-- Full Address -->
        <div class="mb-4">
          <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
            Full Address <span class="text-red-400">*</span>
          </label>
          <textarea
            v-model="register.reg_address"
            name="reg_address"
            rows="3"
            placeholder="House No., Street, Barangay"
            class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition-all resize-none"
            :class="{ 'border-red-400 bg-red-50': stepErrors.reg_address }"
          ></textarea>
          <p v-if="stepErrors.reg_address" class="mt-1.5 text-xs text-red-500">{{ stepErrors.reg_address }}</p>
        </div>

        <!-- Valid ID Upload (optional) -->
        <div class="mb-5">
          <label class="block text-xs font-semibold tracking-widest text-gray-500 uppercase mb-2">
            Valid Government ID
            <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(optional)</span>
          </label>
          <div
            class="relative border-2 border-dashed border-gray-200 rounded-xl px-4 py-4 text-center cursor-pointer hover:border-[#2D5A27] transition-colors"
            :class="{ 'border-[#2D5A27] bg-[#E8F5E3]': validIdFile }"
            @click="$refs.validIdInput.click()"
          >
            <input
              ref="validIdInput"
              type="file"
              name="valid_id"
              accept=".pdf,.jpg,.jpeg,.png"
              class="hidden"
              @change="handleFileChange"
            />
            <div v-if="!validIdFile" class="flex flex-col items-center gap-1.5">
              <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
              </svg>
              <p class="text-xs text-gray-400">Click to upload — PDF, JPG, PNG · max 5MB</p>
            </div>
            <div v-else class="flex items-center justify-center gap-2">
              <svg class="w-4 h-4 text-[#2D5A27]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
              <p class="text-xs font-medium text-[#2D5A27]">{{ validIdFile }}</p>
              <button type="button" @click.stop="clearFile"
                class="text-gray-400 hover:text-red-400 transition-colors ml-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Requirements reminder -->
        <div class="bg-[#E8F5E3] border border-[#b8ddb4] rounded-xl px-4 py-3 mb-6">
          <p class="text-xs font-semibold text-[#2D5A27] mb-1.5">Bring originals to the barangay hall:</p>
          <ul class="text-xs text-[#2D5A27] space-y-0.5">
            <li>✓ Valid Government ID (PhilSys, Passport, Voter's ID, Driver's License, UMID, SSS)</li>
            <li>✓ Proof of Residence (Utility Bill or Barangay Certification)</li>
            <li>✓ Cedula / Community Tax Certificate</li>
          </ul>
        </div>

        <!-- Navigation -->
        <div class="flex gap-3">
          <button type="button" @click="registerStep = 2"
            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm py-3.5 rounded-xl transition-all">
            Back
          </button>
          <button type="submit" :disabled="loading"
            class="flex-1 bg-[#2D5A27] hover:bg-[#3d7a35] disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold text-sm py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
            <svg v-if="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span>{{ loading ? 'Submitting...' : 'Submit Registration' }}</span>
          </button>
        </div>
      </div>

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

// ── General state ──────────────────────────────────────────────────────────────
const tab               = ref(props.defaultTab)
const loading           = ref(false)
const showLoginPassword = ref(false)
const showRegPassword   = ref(false)
const registerStep      = ref(1)
const validIdFile       = ref('')     // display name of the chosen file
const validIdInput      = ref(null)   // template ref for the file input

// Step labels for the progress indicator
const stepLabels = ['Account', 'Personal Info', 'Address & ID']

// ── Per-step client-side errors ────────────────────────────────────────────────
const stepErrors = ref({})

// ── Login form data ────────────────────────────────────────────────────────────
const login = ref({
  email:    props.old.email ?? '',
  password: '',
})

// ── Register form data ─────────────────────────────────────────────────────────
const register = ref({
  // Step 1
  email:                 props.old.reg_email ?? '',
  password:              '',
  password_confirmation: '',
  // Step 2
  first_name:       props.old.first_name ?? '',
  middle_name:      props.old.middle_name ?? '',
  last_name:        props.old.last_name ?? '',
  suffix:           props.old.suffix ?? '',
  birthdate:        props.old.birthdate ?? '',
  reg_gender:       props.old.reg_gender ?? '',
  reg_civil_status: props.old.reg_civil_status ?? '',
  reg_contact:      props.old.reg_contact ?? '',
  // Step 3
  reg_purok_zone: props.old.reg_purok_zone ?? '',
  reg_address:    props.old.reg_address ?? '',
})

// ── Computed ───────────────────────────────────────────────────────────────────
const passwordMismatch = computed(() =>
  register.value.password_confirmation.length > 0 &&
  register.value.password !== register.value.password_confirmation
)

const hasRegErrors = computed(() => Object.keys(props.regErrors).length > 0)

// ── Step validation ────────────────────────────────────────────────────────────
function validateStep(step) {
  const errors = {}

  if (step === 1) {
    if (!register.value.email)
      errors.email = 'Email address is required.'
    if (!register.value.password)
      errors.password = 'Password is required.'
    else if (register.value.password.length < 8)
      errors.password = 'Password must be at least 8 characters.'
    if (!register.value.password_confirmation)
      errors.password_confirmation = 'Please confirm your password.'
    else if (register.value.password !== register.value.password_confirmation)
      errors.password_confirmation = 'Passwords do not match.'
  }

  if (step === 2) {
    if (!register.value.first_name)
      errors.first_name = 'First name is required.'
    if (!register.value.last_name)
      errors.last_name = 'Last name is required.'
    if (!register.value.birthdate)
      errors.birthdate = 'Date of birth is required.'
    if (!register.value.reg_gender)
      errors.reg_gender = 'Gender is required.'
    if (!register.value.reg_civil_status)
      errors.reg_civil_status = 'Civil status is required.'
  }

  if (step === 3) {
    if (!register.value.reg_purok_zone)
      errors.reg_purok_zone = 'Purok / Zone is required.'
    if (!register.value.reg_address)
      errors.reg_address = 'Full address is required.'
  }

  return errors
}

function nextStep() {
  const errors = validateStep(registerStep.value)
  stepErrors.value = errors
  if (Object.keys(errors).length === 0) {
    registerStep.value++
  }
}

// ── File handling ──────────────────────────────────────────────────────────────
function handleFileChange(event) {
  const file = event.target.files[0]
  validIdFile.value = file ? file.name : ''
}

function clearFile() {
  validIdFile.value = ''
  if (validIdInput.value) validIdInput.value.value = ''
}

// ── Form submit ────────────────────────────────────────────────────────────────
function handleSubmit(type) {
  if (type === 'register') {
    // Validate the final step before allowing submit
    const errors = validateStep(3)
    stepErrors.value = errors
    if (Object.keys(errors).length > 0) return
  }
  loading.value = true
}
</script>