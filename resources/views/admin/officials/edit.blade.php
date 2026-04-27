@extends('layouts.admin')
@section('title', 'Edit Official')

@section('content')

<nav class="flex items-center gap-2 text-xs text-gray-400 mb-4">
    <a href="{{ route('admin.officials.index') }}" class="hover:text-gray-600">
        Officials
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">Edit</span>
</nav>

<h1 class="text-2xl font-bold text-gray-900 mb-6"
    style="font-family:'Manrope',sans-serif">
    Edit Official
</h1>

<div class="max-w-lg mx-auto">
    <form method="POST" action="{{ route('admin.officials.update', $official) }}"
          enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.officials._form')
        <div class="flex items-center justify-between mt-5 max-w-xl">
            <form method="POST"
                  action="{{ route('admin.officials.destroy', $official) }}">
                @csrf @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Remove {{ $official->name }}?')"
                        class="text-sm font-semibold text-red-500 border border-red-200
                               px-5 py-2.5 rounded-xl hover:bg-red-50 transition-colors">
                    Remove
                </button>
            </form>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.officials.index') }}"
                   class="text-sm font-semibold text-gray-500 border border-gray-200
                          px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-[#2D5A27] hover:bg-[#3d7a35] text-white text-sm
                               font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

@endsection