<x-app-layout>
    <x-slot name="header">Tambah Divisi</x-slot>
    <form action="{{ route('divisi.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="pt-4 space-y-4">
            <div class="">
                <x-input-label for="nama_divisi" :value="__('Nama Divisi')" />
                <x-text-input id="nama_divisi" class="block mt-1 w-full text-sm" type="text" name="nama_divisi" required
                    autofocus placeholder="Masukkan Nama Divisi" />
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Simpan</button>
            </div>
        </div>
    </form>
</x-app-layout>
