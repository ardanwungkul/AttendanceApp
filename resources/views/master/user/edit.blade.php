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
            @if ($pengguna->role == 'karyawan')
                <div id="formKaryawan">
                    <fieldset class="border p-5 rounded-lg">
                        <legend>Data Karyawan</legend>
                        <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                            <div>
                                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama_lengkap" class="block mt-1 w-full text-sm" type="text"
                                    name="nama_lengkap" :value="$pengguna->karyawan->nama_lengkap" required autofocus autocomplete="nama_lengkap"
                                    placeholder="Masukkan Nama Lengkap" />
                                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select
                                    class="w-full border-gray-300 focus:border-mineral-green-500 focus:ring-mineral-green-500 rounded-md shadow-sm block mt-1 text-sm"
                                    id="jenis_kelamin" name="jenis_kelamin"required>
                                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                    <option {{ $pengguna->karyawan->jenis_kelamin == 'Laki Laki' ? 'selected' : '' }}
                                        value="Laki Laki">Laki Laki</option>
                                    <option {{ $pengguna->karyawan->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}
                                        value="Perempuan">Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full text-sm" type="text"
                                    name="tempat_lahir" :value="$pengguna->karyawan->tempat_lahir" required autofocus autocomplete="tempat_lahir"
                                    placeholder="Masukkan Tempat Lahir" />
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full text-sm" type="date"
                                    name="tanggal_lahir" :value="$pengguna->karyawan->tanggal_lahir" required autofocus
                                    autocomplete="tanggal_lahir" />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="divisi_id" :value="__('Divisi')" />
                                <select
                                    class="w-full border-gray-300 focus:border-mineral-green-500 focus:ring-mineral-green-500 rounded-md shadow-sm block mt-1 text-sm"
                                    id="divisi_id" name="divisi_id" required>
                                    <option value="" selected disabled>Pilih Divisi</option>
                                    @foreach ($divisi as $item)
                                        <option {{ $pengguna->karyawan->divisi_id == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->nama_divisi }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('divisi_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="no_hp" :value="__('No HP')" />
                                <x-text-input id="no_hp" class="block mt-1 w-full text-sm" type="text"
                                    name="no_hp" :value="$pengguna->karyawan->no_hp" required autofocus autocomplete="no_hp"
                                    placeholder="Masukkan No HP" />
                                <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="no_rekening" :value="__('No Rekening')" />
                            <x-text-input id="no_rekening" class="block mt-1 w-full" type="text" name="no_rekening"
                                :value="old('no_rekening')" autofocus autocomplete="no_rekening"
                                placeholder="Masukkan No Rekening" />
                            <p class="text-sm text-gray-500 mt-2">Contoh: 1234239 (BCA)</p>
                            <x-input-error :messages="$errors->get('no_rekening')" class="mt-2" />
                        </div>
                    </fieldset>
                </div>
            @endif
            <div class="flex justify-end">
                <button type="submit"
                    class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Simpan</button>
            </div>
        </div>
    </form>
</x-app-layout>
