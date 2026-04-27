@extends('layouts.admin')
@section('title', 'Create Staff Account')

@section('content')

<nav class="flex items-center gap-2 text-xs text-gray-400 mb-4">
    <a href="{{ route('admin.users.index') }}" class="hover:text-gray-600">
        User Management
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">Create Account</span>
</nav>

<div class="max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6"
        style="font-family:'Manrope',sans-serif">
        Create Staff Account
    </h1>

    <form method="POST" action="{{ route('admin.users.store') }}"
          class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Full Name <span class="text-red-400">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}"
                   placeholder="e.g. Maria Santos"
                   class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                          text-gray-700 focus:outline-none focus:border-[#2D5A27]
                          focus:bg-white transition-all
                          {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Email Address <span class="text-red-400">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}"
                   placeholder="staff@civilink.gov.ph"
                   class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                          text-gray-700 focus:outline-none focus:border-[#2D5A27]
                          focus:bg-white transition-all
                          {{ $errors->has('email') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Role <span class="text-red-400">*</span>
            </label>
            <div class="relative">
                <select name="role"
                        class="w-full bg-gray-50 border rounded-xl px-4 py-2.5
                               text-sm text-gray-700 appearance-none focus:outline-none
                               focus:border-[#2D5A27] focus:bg-white transition-all
                               {{ $errors->has('role') ? 'border-red-400' : 'border-gray-200' }}">
                    <option value="">Select role...</option>
                    <option value="staff"   {{ old('role') === 'staff'   ? 'selected' : '' }}>
                        Staff
                    </option>
                    <option value="captain" {{ old('role') === 'captain' ? 'selected' : '' }}>
                        Captain
                    </option>
                    <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>
                <span class="absolute inset-y-0 right-3 flex items-center
                             pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </div>
            @error('role')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Password <span class="text-red-400">*</span>
            </label>
            <input type="password" name="password"
                   placeholder="Min. 8 characters"
                   class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                          text-gray-700 focus:outline-none focus:border-[#2D5A27]
                          focus:bg-white transition-all
                          {{ $errors->has('password') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Confirm Password <span class="text-red-400">*</span>
            </label>
            <input type="password" name="password_confirmation"
                   placeholder="Re-enter password"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl
                          px-4 py-2.5 text-sm text-gray-700 focus:outline-none
                          focus:border-[#2D5A27] focus:bg-white transition-all"/>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.users.index') }}"
               class="text-sm font-semibold text-gray-500 border border-gray-200
                      px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="bg-[#2D5A27] hover:bg-[#3d7a35] text-white text-sm
                           font-semibold px-6 py-2.5 rounded-xl transition-colors">
                Create Account
            </button>
        </div>

    </form>
</div>

@endsection