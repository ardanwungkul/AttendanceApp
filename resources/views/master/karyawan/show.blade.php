<x-app-layout>
    <x-slot name="header">Detail Karyawan</x-slot>
    <div class="py-4">
        <section class="grid grid-cols-2 gap-x-8 gap-y-6">
            <div>
                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                <p class="text-lg">{{ $karyawan->nama_lengkap }}</p>
            </div>
            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                <p class="text-lg">{{ $karyawan->jenis_kelamin }}</p>
            </div>
            <div>
                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                <p class="text-lg">{{ $karyawan->tempat_lahir }}</p>
            </div>
            <div>
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <p class="text-lg">{{ $karyawan->tanggal_lahir }}</p>
            </div>

            <div>
                <x-input-label for="no_hp" :value="__('No HP')" />
                <p class="text-lg">{{ $karyawan->no_hp }}</p>
            </div>
            <div>
                <x-input-label for="no_rekening" :value="__('No Rekening')" />
                <p class="text-lg">{{ $karyawan->no_rekening }}</p>
            </div>
        </section>
        <section class="py-4">
            <div class="border-b pb-3 border-mineral-green-200 mb-4">
                <p class="text-xl font-semibold tracking-wide">Daftar Absensi {{ $karyawan->nama_lengkap }}</p>
            </div>
            <table class="w-full border rounded-lg overflow-hidden" id="datatable">
                <thead class="bg-mineral-green-200 font-bold">
                    <tr>
                        <td class="!text-center w-10">No</td>
                        <td class="!text-center">Tahun</td>
                        <td class="!text-center">Minggu</td>
                        <td class="!text-center">Rentang Tanggal</td>
                        <td class="!text-center">Status Gaji</td>
                        <td class="!text-center !w-48">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($groupedAbsensi as $key => $items)
                        @php
                            [$tahun, $minggu] = explode('-Minggu-', $key);
                        @endphp
                        <tr>
                            <td class="!text-center">{{ $no++ }}</td>
                            <td class="!text-center">{{ $tahun }}</td>
                            <td class="!text-center">Minggu ke-{{ $minggu }}</td>
                            <td class="!text-center">{{ $rentangTanggal[$key] }}</td>
                            <td
                                class="!text-center {{ $groupedAbsensi[$key]->statusGaji ? 'text-green-500' : 'text-red-500' }}">
                                {{ $groupedAbsensi[$key]->statusGaji ? 'Sudah dibayar' : 'Belum dibayar' }}</td>
                            <td class="!flex !justify-center">
                                <a href="{{ route('absensi.show', ['nip' => $karyawan->nip, 'tahun' => $tahun, 'minggu' => $minggu]) }}"
                                    class="max-w-fit bg-green-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90 text-center">
                                    <i class="fa-solid fa-eye"></i>
                                    <span> Lihat Detail
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            info: false,
            lengthChange: false,
            searching: false,
            paging: false,
            language: {
                'search': '',
                'searchPlaceholder': 'Search for items'
            },
        });
    })
</script>
