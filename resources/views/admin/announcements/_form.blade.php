<div class="space-y-5 max-w-2xl">

    <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Title <span class="text-red-400">*</span>
            </label>
            <input type="text" name="title"
                   value="{{ old('title', $announcement->title ?? '') }}"
                   placeholder="Announcement title..."
                   class="w-full bg-gray-50 border rounded-xl px-4 py-2.5 text-sm
                          text-gray-700 focus:outline-none focus:border-[#2D5A27]
                          focus:bg-white transition-all
                          {{ $errors->has('title') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('title')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Category <span class="text-red-400">*</span>
            </label>
            <div class="relative">
                <select name="category"
                        class="w-full bg-gray-50 border rounded-xl px-4 py-2.5
                               text-sm text-gray-700 appearance-none focus:outline-none
                               focus:border-[#2D5A27] focus:bg-white transition-all
                               {{ $errors->has('category') ? 'border-red-400' : 'border-gray-200' }}">
                    <option value="">Select category...</option>
                    @foreach(['general'=>'General','events'=>'Events','advisories'=>'Advisories',
                              'projects'=>'Projects','meetings'=>'Meetings',
                              'environment'=>'Environment','education'=>'Education',
                              'livelihood'=>'Livelihood'] as $val=>$label)
                        <option value="{{ $val }}"
                            {{ old('category', $announcement->category ?? '') === $val
                                ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
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
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                Content <span class="text-red-400">*</span>
            </label>
            <textarea name="content" rows="8"
                      placeholder="Write the announcement content here..."
                      class="w-full bg-gray-50 border rounded-xl px-4 py-3 text-sm
                             text-gray-700 resize-none focus:outline-none
                             focus:border-[#2D5A27] focus:bg-white transition-all
                             {{ $errors->has('content') ? 'border-red-400' : 'border-gray-200' }}"
            >{{ old('content', $announcement->content ?? '') }}</textarea>
            @error('content')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Publish toggle --}}
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="is_published" value="1"
                   {{ old('is_published', $announcement->is_published ?? false)
                       ? 'checked' : '' }}
                   class="w-4 h-4 rounded accent-[#2D5A27]"/>
            <div>
                <p class="text-sm font-semibold text-gray-700">
                    Publish immediately
                </p>
                <p class="text-xs text-gray-400">
                    Unchecked = saved as draft, not visible on public site
                </p>
            </div>
        </label>

    </div>

    {{-- Image upload --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h3 class="text-sm font-bold text-gray-700 mb-4"
            style="font-family:'Manrope',sans-serif">
            Cover Image
        </h3>
        <div class="flex items-start gap-5">
            <div id="img-preview"
                 class="w-24 h-24 rounded-xl overflow-hidden bg-gray-100
                        flex items-center justify-center flex-shrink-0">
                @if(isset($announcement) && $announcement->image)
                    <img src="{{ asset('storage/'.$announcement->image) }}"
                         class="w-full h-full object-cover"/>
                @else
                    <svg class="w-8 h-8 text-gray-300" fill="none"
                         stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586
                                 -1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2
                                 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0
                                 002 2z"/>
                    </svg>
                @endif
            </div>
            <div>
                <input type="file" name="image" id="img-input" accept="image/*"
                       class="hidden" onchange="previewImg(this)"/>
                <label for="img-input"
                       class="inline-block cursor-pointer border border-gray-200
                              text-sm font-semibold text-gray-600 px-4 py-2
                              rounded-xl hover:border-[#2D5A27] hover:text-[#2D5A27]
                              transition-colors">
                    Choose Image
                </label>
                <p class="text-xs text-gray-400 mt-1.5">
                    JPG, PNG, WEBP · Max 3MB · Optional
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader()
        reader.onload = e => {
            document.getElementById('img-preview').innerHTML =
                `<img src="${e.target.result}" class="w-full h-full object-cover"/>`
        }
        reader.readAsDataURL(input.files[0])
    }
}
</script>