<x-app-layout>
    <x-slot name="header">Riwayat Absensi</x-slot>
    <div class="pb-4 relative pt-8">
        <table class="w-full border rounded-lg overflow-hidden shadow-lg" id="datatable">
            <thead class="bg-mineral-green-200 font-bold">
                <tr>
                    <th class="!text-center text-xs sm:text-base">No</th>
                    <th class="!text-center text-xs sm:text-base">Tahun</th>
                    <th class="!text-center text-xs sm:text-base">Minggu</th>
                    <th class="!text-center text-xs sm:text-base">Rentang Tanggal</th>
                    <th class="!text-center text-xs sm:text-base">Status Gaji</th>
                    <th class="!text-center text-xs sm:text-base">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($groupedAbsensi as $key => $items)
                    @php
                        [$tahun, $minggu] = explode('-Minggu-', $key);
                    @endphp
                    <tr>
                        <td class="!text-center text-xs sm:text-base">{{ $no++ }}</td>
                        <td class="!text-center text-xs sm:text-base">{{ $tahun }}</td>
                        <td class="!text-center text-xs sm:text-base">Minggu ke-{{ $minggu }}</td>
                        <td class="!text-center text-xs sm:text-base">{{ $rentangTanggal[$key] }}</td>
                        <td
                            class="!text-center text-xs sm:text-base {{ $groupedAbsensi[$key]->statusGaji ? 'text-green-500' : 'text-red-500' }}">
                            {{ $groupedAbsensi[$key]->statusGaji ? 'Sudah dibayar' : 'Belum dibayar' }}</td>
                        <td class="!text-center text-xs sm:text-base">
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
            responsive: {
                details: {
                    renderer: function(api, rowIdx, columns) {
                        let data = columns.map((col) => {
                            return col.hidden ?
                                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' +
                                col.columnIndex + '">' +
                                '<td class="text-xs sm:text-base">' + col.title + ':</td>' +
                                '<td class="text-xs sm:text-base">' + col.data + '</td>' +
                                '</tr>' :
                                '';
                        }).join('');

                        return data ? $('<table/>').append(data) : false;
                    }
                }
            },
        });
    });
</script>
