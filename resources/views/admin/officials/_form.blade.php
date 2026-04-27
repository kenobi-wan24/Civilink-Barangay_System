<div class="bg-white rounded-2xl border border-gray-100 p-6 max-w-xl space-y-4">

    <div>
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">
            Full Name <span class="text-red-400">*</span>
        </label>
        <input type="text" name="name"
               value="{{ old('name', $official->name ?? '') }}"
               placeholder="e.g. Hon. Juan Dela Cruz"
               class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                      text-gray-700 focus:outline-none focus:border-[#2D5A27]
                      focus:bg-white transition-all
                      {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }}"/>
        @error('name')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">
            Position <span class="text-red-400">*</span>
        </label>
        <input type="text" name="position"
               value="{{ old('position', $official->position ?? '') }}"
               placeholder="e.g. Barangay Captain, Kagawad"
               class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                      text-gray-700 focus:outline-none focus:border-[#2D5A27]
                      focus:bg-white transition-all
                      {{ $errors->has('position') ? 'border-red-400' : 'border-gray-200' }}"/>
        @error('position')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">
            Sort Order
        </label>
        <input type="number" name="sort_order" min="1"
               value="{{ old('sort_order', $official->sort_order ?? '') }}"
               placeholder="1 = first (Captain), 2, 3..."
               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4
                      py-2.5 text-sm text-gray-700 focus:outline-none
                      focus:border-[#2D5A27] focus:bg-white transition-all"/>
        <p class="text-xs text-gray-400 mt-1">
            Lower number appears first. Captain should be 1.
        </p>
    </div>

    <div>
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">
            Photo
        </label>
        <div class="flex items-center gap-4">
            <div id="photo-preview"
                 class="w-16 h-16 rounded-full bg-gray-100 overflow-hidden
                        flex items-center justify-center flex-shrink-0">
                @if(isset($official) && $official->photo)
                    <img src="{{ asset('storage/'.$official->photo) }}"
                         class="w-full h-full object-cover"/>
                @else
                    <svg class="w-6 h-6 text-gray-300" fill="none"
                         stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0
                                 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                @endif
            </div>
            <div>
                <input type="file" name="photo" id="photo" accept="image/*"
                       class="hidden" onchange="previewPhoto(this)"/>
                <label for="photo"
                       class="inline-block cursor-pointer border border-gray-200
                              text-sm font-semibold text-gray-600 px-4 py-2
                              rounded-xl hover:border-[#2D5A27] hover:text-[#2D5A27]
                              transition-colors">
                    Choose Photo
                </label>
                <p class="text-xs text-gray-400 mt-1">JPG, PNG · Max 2MB</p>
            </div>
        </div>
    </div>

</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader()
        reader.onload = e => {
            document.getElementById('photo-preview').innerHTML =
                `<img src="${e.target.result}" class="w-full h-full object-cover"/>`
        }
        reader.readAsDataURL(input.files[0])
    }
}
</script>