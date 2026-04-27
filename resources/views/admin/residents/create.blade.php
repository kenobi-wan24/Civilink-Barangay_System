@extends('layouts.admin')
@section('title', 'Add Resident')

@section('content')

<nav class="flex items-center gap-2 text-xs text-gray-400 mb-4">
    <a href="{{ route('admin.residents.index') }}" class="hover:text-gray-600">
        Residents
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">Add Resident</span>
</nav>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
    <h1 class="text-2xl font-bold text-gray-900"
        style="font-family:'Manrope',sans-serif">
        Add New Resident
    </h1>
</div>

<div class="max-w-9xl mx-auto"> 

<form method="POST" action="{{ route('admin.residents.store') }}"
      enctype="multipart/form-data">
    @csrf

    @include('admin.residents._form')

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.residents.index') }}"
           class="text-sm font-semibold text-gray-500 border border-gray-200
                  px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
            Cancel
        </a>
        <button type="submit"
                class="bg-[#2D5A27] hover:bg-[#3d7a35] text-white text-sm
                       font-semibold px-6 py-2.5 rounded-xl transition-colors">
            Save Resident
        </button>
    </div>
</form>

</div>

@endsection