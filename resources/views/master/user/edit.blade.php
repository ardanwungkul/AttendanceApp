<x-app-layout>
    <x-slot name="header">Edit Pengguna</x-slot>
    <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="pt-4 space-y-4">
            <div class="">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" class="block mt-1 w-full text-sm" type="text" name="username"
                    :value="$pengguna->username" required autofocus autocomplete="old-username" placeholder="Masukkan Username" />
            </div>
            <div class="">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full text-sm" type="text" name="password" autofocus
                    autocomplete="old-password" placeholder="Masukkan Password" />
            </div>
            <div id="formKaryawan" class="hidden">
                test
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Simpan</button>
            </div>
        </div>
    </form>
</x-app-layout>
