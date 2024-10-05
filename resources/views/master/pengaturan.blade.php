<x-app-layout>
    <x-slot name="header">Pengaturan</x-slot>
    <form action="{{ route('pengaturan.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="pt-4 space-y-4">
            <div class="">
                <x-input-label for="jam_masuk" :value="__('Jam Masuk')" />
                <x-text-input id="jam_masuk" class="block mt-1 w-full text-sm" type="time" name="jam_masuk" required
                    step="any" autofocus :value="$pengaturan->jam_masuk" />
            </div>
            <div class="">
                <x-input-label for="jam_keluar" :value="__('Jam Keluar')" />
                <x-text-input id="jam_keluar" class="block mt-1 w-full text-sm" type="time" name="jam_keluar"
                    required step="any" autofocus :value="$pengaturan->jam_keluar" />
            </div>
            <div class="">
                <x-input-label for="batas_waktu" :value="__('Batas Waktu')" />
                <x-text-input id="batas_waktu" class="block mt-1 w-full text-sm" type="time" name="batas_waktu"
                    required step="any" autofocus :value="$pengaturan->batas_waktu" />
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Simpan</button>
            </div>
        </div>
    </form>
</x-app-layout>
