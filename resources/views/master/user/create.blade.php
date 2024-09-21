<x-app-layout>
    <x-slot name="header">Tambah Pengguna</x-slot>
    <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="pt-4 space-y-4">
            <div class="">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" class="block mt-1 w-full text-sm" type="text" name="username" required
                    autofocus autocomplete="old-username" placeholder="Masukkan Username" />
            </div>
            <div class="">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full text-sm" type="text" name="password" required
                    autofocus autocomplete="old-password" placeholder="Masukkan Password" />
            </div>
            <div class="">
                <x-input-label for="role" :value="__('Role')" />
                <select name="role" id="role" required
                    class="block mt-1 w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-mineral-green-500 dark:focus:border-mineral-green-600 focus:ring-mineral-green-500 dark:focus:ring-mineral-green-600 rounded-md shadow-sm">
                    <option value="" selected disabled>Pilih Role Pengguna</option>
                    <option value="admin">Admin</option>
                    <option value="karyawan">Karyawan</option>
                </select>
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
<script>
    $(document).ready(function() {
        $('#role').on('change', function() {
            value = $('#role').val();
            if (value == 'karyawan') {
                $('#formKaryawan').removeClass('hidden')
            } else {
                $('#formKaryawan').addClass('hidden')
            }

        })
    })
</script>
