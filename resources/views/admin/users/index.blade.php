@extends('layouts.admin')
@section('title', 'User Management')

@section('content')

{{-- Header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;
            gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <div>
        <h1 class="text-2xl font-bold text-gray-900"
            style="font-family:'Manrope',sans-serif">
            User Management
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Manage portal accounts, link residents, and create staff accounts.
        </p>
    </div>
    <a href="{{ route('admin.users.create') }}"
       class="inline-flex items-center gap-2 bg-[#2D5A27] hover:bg-[#3d7a35]
              text-white text-sm font-semibold px-5 py-3 rounded-xl
              transition-colors flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4v16m8-8H4"/>
        </svg>
        Create Staff Account
    </a>
</div>

{{-- ── Section 1: Unlinked portal accounts ── --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6">

    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
        <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
        <h2 class="text-sm font-bold text-gray-700"
            style="font-family:'Manrope',sans-serif">
            Unlinked Portal Accounts
        </h2>
        <span class="text-xs font-semibold bg-yellow-100 text-yellow-700
                     px-2.5 py-1 rounded-full ml-auto">
            {{ $unlinked->count() }} pending
        </span>
    </div>

    @if($unlinked->isEmpty())
        <div class="px-6 py-16 text-center">
            <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none"
                 stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-gray-400">All accounts are linked. You're good!</p>
        </div>
    @else
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-xs font-semibold text-gray-400
                               uppercase tracking-wider px-6 py-3">
                        Account
                    </th>
                    <th class="text-left text-xs font-semibold text-gray-400
                               uppercase tracking-wider px-6 py-3">
                        Signed up
                    </th>
                    <th class="text-left text-xs font-semibold text-gray-400
                               uppercase tracking-wider px-6 py-3">
                        Link to resident profile
                    </th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($unlinked as $user)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50">

                    {{-- Account info --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-yellow-100
                                        flex items-center justify-center
                                        text-yellow-700 text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $user->name }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Date --}}
                    <td class="px-6 py-4 text-xs text-gray-400">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>

                    {{-- Link form --}}
                    <td class="px-6 py-4">
                        <form method="POST"
                              action="{{ route('admin.users.link', $user) }}"
                              class="flex items-center gap-2">
                            @csrf
                            <div class="relative flex-1 max-w-xs">
                                <select name="resident_id"
                                        class="w-full bg-gray-50 border border-gray-200
                                               rounded-xl px-3 py-2 text-sm text-gray-700
                                               appearance-none focus:outline-none
                                               focus:border-[#2D5A27] transition-all">
                                    <option value="">Select resident...</option>
                                    @foreach($residents as $resident)
                                        <option value="{{ $resident->id }}">
                                            {{ $resident->full_name }}
                                            ({{ $resident->resident_code }})
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute inset-y-0 right-3 flex items-center
                                             pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </div>
                            <button type="submit"
                                    class="bg-[#2D5A27] hover:bg-[#3d7a35] text-white
                                           text-xs font-semibold px-4 py-2 rounded-xl
                                           transition-colors whitespace-nowrap">
                                Link Account
                            </button>
                        </form>
                        @error('resident_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </td>

                    {{-- Deactivate --}}
                    <td class="px-6 py-4">
                        <form method="POST"
                              action="{{ route('admin.users.destroy', $user) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Remove this account?')"
                                    class="text-xs text-red-400 hover:text-red-600
                                           border border-red-100 hover:border-red-300
                                           px-3 py-2 rounded-xl transition-colors">
                                Remove
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- ── Section 2: Create staff account form ── --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
        <div class="w-2 h-2 rounded-full bg-[#2D5A27]"></div>
        <h2 class="text-sm font-bold text-gray-700"
            style="font-family:'Manrope',sans-serif">
            Staff & Captain Accounts
        </h2>
    </div>

    {{-- Existing staff list --}}
    @php
        $staffAccounts = \App\Models\User::whereIn('role', ['admin','staff','captain'])
                            ->orderBy('role')->get();
    @endphp

    @if($staffAccounts->isNotEmpty())
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-3">Name</th>
                <th class="text-left text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-3">Email</th>
                <th class="text-left text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-3">Role</th>
                <th class="text-left text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-3">Status</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffAccounts as $staff)
            @php
                $roleColors = [
                    'admin'   => 'bg-purple-100 text-purple-700',
                    'staff'   => 'bg-blue-100 text-blue-700',
                    'captain' => 'bg-[#E8F5E3] text-[#2D5A27]',
                ];
            @endphp
            <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-[#E8F5E3]
                                    flex items-center justify-center
                                    text-[#2D5A27] text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr($staff->name, 0, 2)) }}
                        </div>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $staff->name }}
                        </p>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $staff->email }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                 capitalize {{ $roleColors[$staff->role] ?? 'bg-gray-100 text-gray-500' }}">
                        {{ ucfirst($staff->role) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                 {{ $staff->is_active
                                     ? 'bg-green-100 text-green-700'
                                     : 'bg-gray-100 text-gray-400' }}">
                        {{ $staff->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    @if($staff->id !== auth()->id())
                    <form method="POST"
                          action="{{ route('admin.users.destroy', $staff) }}"
                          class="inline">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Deactivate {{ $staff->name }}?')"
                                class="text-xs text-red-400 hover:text-red-600
                                       border border-red-100 hover:border-red-300
                                       px-3 py-2 rounded-xl transition-colors">
                            Deactivate
                        </button>
                    </form>
                    @else
                    <span class="text-xs text-gray-300">You</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</div>

@endsection