<x-app-layout>
    <x-slot name="header">Edit Karyawan</x-slot>
    <div class="py-4">
        <form action="{{ route('karyawan.update', $karyawan->nip) }}" class="grid grid-cols-2 gap-x-8 gap-y-6"
            method="POST">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap"
                    :value="old('nama_lengkap', $karyawan->nama_lengkap)" required autofocus autocomplete="nama_lengkap"
                    placeholder="Masukkan Nama Lengkap" />
                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                <select
                    class="w-full border-gray-300 focus:border-mineral-green-500 focus:ring-mineral-green-500 rounded-md shadow-sm"
                    id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full" required>
                    <option value="Laki Laki"
                        {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'Laki Laki' ? 'selected' : '' }}>Laki Laki
                    </option>
                    <option value="Perempuan"
                        {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir"
                    :value="old('tempat_lahir', $karyawan->tempat_lahir)" required autofocus autocomplete="tempat_lahir"
                    placeholder="Masukkan Tempat Lahir" />
                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
                    :value="old('tanggal_lahir', $karyawan->tanggal_lahir)" required autofocus autocomplete="tanggal_lahir" />
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="divisi_id" :value="__('Divisi')" />
                <select
                    class="w-full border-gray-300 focus:border-mineral-green-500 focus:ring-mineral-green-500 rounded-md shadow-sm"
                    id="divisi_id" name="divisi_id" class="block mt-1 w-full" required>
                    @foreach ($divisi as $item)
                        <option value="{{ $item->id }}"
                            {{ old('divisi_id', $karyawan->divisi_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_divisi }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('divisi_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="no_hp" :value="__('No HP')" />
                <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp', $karyawan->no_hp)"
                    required autofocus autocomplete="no_hp" placeholder="Masukkan No HP" />
                <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="no_rekening" :value="__('No Rekening')" />
                <x-text-input id="no_rekening" class="block mt-1 w-full" type="text" name="no_rekening"
                    :value="old('no_rekening', $karyawan->no_rekening)" autofocus autocomplete="no_rekening" placeholder="Masukkan No Rekening" />
                <p class="text-sm text-gray-500 mt-2">Contoh: 1234239 (BCA)</p>
                <x-input-error :messages="$errors->get('no_rekening')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end col-span-2">
                <x-primary-button type="submit" class="ms-3">
                    {{ __('Simpan Perubahan') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
