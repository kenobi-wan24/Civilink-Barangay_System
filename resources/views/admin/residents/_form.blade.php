{{-- Personal info --}}
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-5">
    <h3 class="text-sm font-bold text-gray-700 mb-5"
        style="font-family:'Manrope',sans-serif">
        Personal Information
    </h3>

    {{-- Row 1: Name fields — First(2fr) Middle(1.5fr) Last(2fr) Suffix(80px) --}}
    <div style="display:grid;grid-template-columns:2fr 1.5fr 2fr 80px;gap:1rem;margin-bottom:1rem">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                First Name <span class="text-red-400">*</span>
            </label>
            <input type="text" name="first_name"
                   value="{{ old('first_name', $resident->first_name ?? '') }}"
                   class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                          text-gray-700 focus:outline-none focus:border-[#2D5A27]
                          focus:bg-white transition-all
                          {{ $errors->has('first_name') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('first_name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Middle Name
            </label>
            <input type="text" name="middle_name"
                   value="{{ old('middle_name', $resident->middle_name ?? '') }}"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4
                          py-2.5 text-sm text-gray-700 focus:outline-none
                          focus:border-[#2D5A27] focus:bg-white transition-all"/>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Last Name <span class="text-red-400">*</span>
            </label>
            <input type="text" name="last_name"
                   value="{{ old('last_name', $resident->last_name ?? '') }}"
                   class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                          text-gray-700 focus:outline-none focus:border-[#2D5A27]
                          focus:bg-white transition-all
                          {{ $errors->has('last_name') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('last_name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Suffix
            </label>
            <input type="text" name="suffix"
                   value="{{ old('suffix', $resident->suffix ?? '') }}"
                   placeholder="Jr."
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3
                          py-2.5 text-sm text-gray-700 focus:outline-none
                          focus:border-[#2D5A27] focus:bg-white transition-all"/>
        </div>
    </div>

    {{-- Row 2: DOB | Gender | Civil Status | Contact Number --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:1rem;margin-bottom:1rem">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Date of Birth <span class="text-red-400">*</span>
            </label>
            <input type="date" name="birthdate"
                   value="{{ old('birthdate', isset($resident) ? $resident->birthdate->format('Y-m-d') : '') }}"
                   class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                          text-gray-700 focus:outline-none focus:border-[#2D5A27]
                          focus:bg-white transition-all
                          {{ $errors->has('birthdate') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('birthdate')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Gender <span class="text-red-400">*</span>
            </label>
            <div class="relative">
                <select name="gender"
                        class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                               text-gray-700 appearance-none focus:outline-none
                               focus:border-[#2D5A27] focus:bg-white transition-all
                               {{ $errors->has('gender') ? 'border-red-400' : 'border-gray-200' }}">
                    <option value="">Select gender</option>
                    @foreach(['male'=>'Male','female'=>'Female','other'=>'Other'] as $val=>$label)
                        <option value="{{ $val }}"
                            {{ old('gender', $resident->gender ?? '') === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Civil Status <span class="text-red-400">*</span>
            </label>
            <div class="relative">
                <select name="civil_status"
                        class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                               text-gray-700 appearance-none focus:outline-none
                               focus:border-[#2D5A27] focus:bg-white transition-all
                               {{ $errors->has('civil_status') ? 'border-red-400' : 'border-gray-200' }}">
                    <option value="">Select status</option>
                    @foreach(['single'=>'Single','married'=>'Married','widowed'=>'Widowed','separated'=>'Separated'] as $val=>$label)
                        <option value="{{ $val }}"
                            {{ old('civil_status', $resident->civil_status ?? '') === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Contact Number
            </label>
            <input type="text" name="contact_number"
                   value="{{ old('contact_number', $resident->contact_number ?? '') }}"
                   placeholder="+63 9XX XXX XXXX"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4
                          py-2.5 text-sm text-gray-700 focus:outline-none
                          focus:border-[#2D5A27] focus:bg-white transition-all"/>
        </div>
    </div>

    {{-- Row 3: Purok/Zone | Email --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Purok / Zone <span class="text-red-400">*</span>
            </label>
            <input type="text" name="purok_zone"
                   value="{{ old('purok_zone', $resident->purok_zone ?? '') }}"
                   placeholder="e.g. Purok 3 – Mabini"
                   class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                          text-gray-700 focus:outline-none focus:border-[#2D5A27]
                          focus:bg-white transition-all
                          {{ $errors->has('purok_zone') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('purok_zone')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Email Address
            </label>
            <input type="email" name="email"
                   value="{{ old('email', $resident->email ?? '') }}"
                   placeholder="resident@email.com"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4
                          py-2.5 text-sm text-gray-700 focus:outline-none
                          focus:border-[#2D5A27] focus:bg-white transition-all"/>
        </div>
    </div>

    {{-- Row 4: Full Address --}}
    <div>
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">
            Full Address <span class="text-red-400">*</span>
        </label>
        <textarea name="address" rows="2"
                  class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                         text-gray-700 resize-none focus:outline-none
                         focus:border-[#2D5A27] focus:bg-white transition-all
                         {{ $errors->has('address') ? 'border-red-400' : 'border-gray-200' }}"
                  placeholder="House No., Street, Barangay">{{ old('address', $resident->address ?? '') }}</textarea>
        @error('address')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Classification tags --}}
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-5">
    <h3 class="text-sm font-bold text-gray-700 mb-4"
        style="font-family:'Manrope',sans-serif">
        Classification Tags
    </h3>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:1rem">
        @foreach([
            ['is_voter',          'Registered Voter',              'bg-[#E8F5E3] text-[#2D5A27]'],
            ['is_senior_citizen', 'Senior Citizen',                'bg-purple-50 text-purple-700'],
            ['is_pwd',            'Person with Disability (PWD)',  'bg-orange-50 text-orange-700'],
            ['is_solo_parent',    'Solo Parent',                   'bg-pink-50 text-pink-700'],
        ] as [$name, $label, $bg])
        <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-colors
                       {{ old($name, $resident->$name ?? 0) ? 'border-[#2D5A27] '.$bg : 'border-gray-200 bg-gray-50' }}"
               id="label-{{ $name }}">
            <input type="checkbox" name="{{ $name }}" value="1"
                   {{ old($name, $resident->$name ?? 0) ? 'checked' : '' }}
                   class="w-4 h-4 rounded accent-[#2D5A27]"
                   onchange="toggleLabel(this, '{{ $bg }}')"/>
            <span class="text-xs font-semibold text-gray-700">{{ $label }}</span>
        </label>
        @endforeach
    </div>
</div>

{{-- Profile picture --}}
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-5">
    <h3 class="text-sm font-bold text-gray-700 mb-4"
        style="font-family:'Manrope',sans-serif">
        Profile Picture
    </h3>
    <div class="flex items-center gap-5">
        <div id="photo-preview"
             class="w-20 h-20 rounded-full bg-gray-100 flex items-center
                    justify-center overflow-hidden flex-shrink-0">
            @if(isset($resident) && $resident->profile_picture)
                <img src="{{ asset('storage/'.$resident->profile_picture) }}"
                     class="w-full h-full object-cover"/>
            @else
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                     stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0
                             00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            @endif
        </div>
        <div>
            <input type="file" name="profile_picture" id="profile_picture"
                   accept="image/*" class="hidden"
                   onchange="previewPhoto(this)"/>
            <label for="profile_picture"
                   class="inline-block cursor-pointer border border-gray-200
                          text-sm font-semibold text-gray-600 px-4 py-2
                          rounded-xl hover:border-[#2D5A27] hover:text-[#2D5A27]
                          transition-colors">
                Choose Photo
            </label>
            <p class="text-xs text-gray-400 mt-1.5">JPG, PNG, WEBP · Max 2MB</p>
        </div>
    </div>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader()
        reader.onload = e => {
            const preview = document.getElementById('photo-preview')
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover"/>`
        }
        reader.readAsDataURL(input.files[0])
    }
}

function toggleLabel(checkbox, bg) {
    const label = checkbox.closest('label')
    if (checkbox.checked) {
        label.classList.remove('border-gray-200', 'bg-gray-50')
        label.classList.add('border-[#2D5A27]', ...bg.split(' '))
    } else {
        label.classList.add('border-gray-200', 'bg-gray-50')
        label.classList.remove('border-[#2D5A27]', ...bg.split(' '))
    }
}
</script>