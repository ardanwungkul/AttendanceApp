<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-2 md:grid-cols-4 my-6 gap-x-6 gap-y-3">
        @if (Auth::user()->role == 'super_admin')
            <a href="{{ route('pengguna.index') }}" class="group">
                <div
                    class="rounded-lg border border-gray-300 shadow flex flex-col items-center py-6 space-y-3 group-hover:bg-gray-100">
                    <i class="text-4xl fa-solid fa-users text-mineral-green-400"></i></span>
                    Pengguna
                </div>
            </a>
        @endif
        <a href="{{ route('divisi.index') }}" class="group">
            <div
                class="rounded-lg border border-gray-300 shadow flex flex-col items-center py-6 space-y-3 group-hover:bg-gray-100">
                <i class="text-4xl fa-solid fa-layer-group text-mineral-green-400"></i></span>
                Divisi
            </div>
        </a>
        <a href="{{ route('karyawan.index') }}" class="group">
            <div
                class="rounded-lg border border-gray-300 shadow flex flex-col items-center py-6 space-y-3 group-hover:bg-gray-100">
                <i class="text-4xl fa-solid fa-user-tie text-mineral-green-400"></i></span>
                Karyawan
            </div>
        </a>
        <a href="{{ route('gaji.index') }}" class="group">
            <div
                class="rounded-lg border border-gray-300 shadow flex flex-col items-center py-6 space-y-3 group-hover:bg-gray-100">
                <i class="text-4xl fa-solid fa-file-invoice-dollar text-mineral-green-400"></i></span>
                Laporan Gaji
            </div>
        </a>
    </div>
</x-app-layout>
