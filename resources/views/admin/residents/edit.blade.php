@extends('layouts.admin')
@section('title', 'Edit Resident')

@section('content')

<nav class="flex items-center gap-2 text-xs text-gray-400 mb-4">
    <a href="{{ route('admin.residents.index') }}" class="hover:text-gray-600">
        Residents
    </a>
    <span>›</span>
    <a href="{{ route('admin.residents.show', $resident) }}" class="hover:text-gray-600">
        {{ $resident->full_name }}
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">Edit</span>
</nav>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
    <h1 class="text-2xl font-bold text-gray-900"
        style="font-family:'Manrope',sans-serif">
        Edit Resident
    </h1>
    <span class="text-xs font-mono text-gray-400 bg-gray-100 px-3 py-1.5
                 rounded-full">
        {{ $resident->resident_code }}
    </span>
</div>

<form method="POST" action="{{ route('admin.residents.update', $resident) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.residents._form')

    <div class="flex items-center justify-between">      
            <button type="submit"
                    onclick="return confirm('Deactivate {{ $resident->full_name }}?')"
                    class="text-sm font-semibold text-red-500 border border-red-200
                           px-5 py-2.5 rounded-xl hover:bg-red-50 transition-colors">
                Deactivate Resident
            </button>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.residents.show', $resident) }}"
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

<form method="POST"
              action="{{ route('admin.residents.destroy', $resident) }}">
            @csrf @method('DELETE')
</form>

@endsection