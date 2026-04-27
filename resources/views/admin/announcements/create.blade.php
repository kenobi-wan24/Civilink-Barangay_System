@extends('layouts.admin')
@section('title', 'New Announcement')

@section('content')

<nav class="flex items-center gap-2 text-xs text-gray-400 mb-4">
    <a href="{{ route('admin.announcements.index') }}" class="hover:text-gray-600">
        Announcements
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">New Announcement</span>
</nav>

<h1 class="text-2xl font-bold text-gray-900 mb-6"
    style="font-family:'Manrope',sans-serif">
    New Announcement
</h1>

<form method="POST" action="{{ route('admin.announcements.store') }}"
      enctype="multipart/form-data">
    @csrf
    @include('admin.announcements._form')
    <div class="flex items-center justify-end gap-3 mt-5 max-w-2xl">
        <a href="{{ route('admin.announcements.index') }}"
           class="text-sm font-semibold text-gray-500 border border-gray-200
                  px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
            Cancel
        </a>
        <button type="submit"
                class="bg-[#2D5A27] hover:bg-[#3d7a35] text-white text-sm
                       font-semibold px-6 py-2.5 rounded-xl transition-colors">
            Save Announcement
        </button>
    </div>
</form>

@endsection