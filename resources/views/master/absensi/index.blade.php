<x-app-layout>
    <x-slot name="header">Riwayat Absensi</x-slot>
    <div class="pb-4 relative  pt-8">
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
                        <td class="!text-center">
                            <div class="flex justify-center">
                                <a href="{{ route('absensi.show', ['nip' => $groupedAbsensi[$key][0]->karyawan_nip, 'tahun' => $tahun, 'minggu' => $minggu]) }}"
                                    class="bg-green-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90 w-fit">
                                    <i class="fa-solid fa-eye"></i>
                                    <span> Lihat detail
                                    </span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

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
    });
</script>
