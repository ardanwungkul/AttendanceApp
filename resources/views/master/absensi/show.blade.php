<x-app-layout>
    <x-slot name="header">Detail Absensi Minggu ke-{{ $minggu }} Tahun {{ $tahun }}</x-slot>
    <div class="pb-4 relative pt-6">
        <div class="pb-5 flex sm:flex-row flex-col gap-3 sm:gap-0 sm:items-center items-start justify-between">
            <h6 class="sm:text-lg text-sm font-semibold">Status Pembayaran : <span
                    class="{{ $gaji ? 'text-green-500' : 'text-red-500' }}">{{ $gaji ? 'Sudah Dibayar' : 'Belum Dibayar' }}</span>
            </h6>
            <a href="{{ url()->previous() }}"
                class="px-5 py-2 text-sm sm:text-base bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Kembali</a>
        </div>
        <table class="w-full border rounded-lg overflow-hidden shadow-lg" id="datatable">
            <thead class="bg-mineral-green-200 font-bold">
                <tr>
                    <th class="!text-center text-xs sm:text-base">No</th>
                    <th class="!text-center text-xs sm:text-base">Tanggal Kerja</th>
                    <th class="!text-center text-xs sm:text-base">Jam Masuk</th>
                    <th class="!text-center text-xs sm:text-base">Jam Keluar</th>
                    <th class="!text-center text-xs sm:text-base">Status</th>
                    <th class="!text-center text-xs sm:text-base">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($absensi as $item)
                    <tr>
                        <td class="!text-center text-xs sm:text-base">{{ $no++ }}</td>
                        <td class="!text-center text-xs sm:text-base">{{ $item->tanggal_kerja }}</td>
                        <td class="!text-center text-xs sm:text-base">{{ $item->jam_masuk }}</td>
                        <td class="!text-center text-xs sm:text-base">{{ $item->jam_keluar }}</td>
                        <td class="!text-center text-xs sm:text-base ">
                            <div
                                class="w-full py-1 px-3 rounded-full flex gap-1 {{ $item->status === 'hadir' ? 'bg-green-300 text-green-700' : 'bg-red-300 text-red-700' }}">
                                <p class="capitalize font-semibold w-full">
                                    {{ $item->status }}
                                </p>
                                @if ($item->lampiran)
                                    <a target="_blank" href="{{ route('download.lampiran', $item->id) }}">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="!text-center text-xs sm:text-base">{{ $item->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="py-5 flex items-center justify-end">
            @if (Auth::user()->role !== 'karyawan' && !$gaji)
                <form action="{{ route('gaji.store') }}" method="post">
                    @csrf
                    @method('POST')
                    <input hidden type="text" name="nip" value="{{ $nip }}">
                    <input hidden type="number" name="total_kerja" id="total_kerja">
                    <input hidden type="date" name="periode_awal" value="{{ $startDate->format('Y-m-d') }}">
                    <input hidden type="date" name="periode_akhir" value="{{ $endDate->format('Y-m-d') }}">
                    <button type="submit"
                        class="px-5 py-2 bg-blue-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Bayar
                        Gaji</button>
                </form>
            @elseif ($gaji)
                <a href="{{ route('gaji.show', ['tahun' => $tahun, 'minggu' => $minggu, 'gaji' => $gaji->id]) }}"
                    class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Lihat
                    Detail Pembayaran</a>
            @endif

        </div>
    </div>
</x-app-layout>

<script>
    let totalKerjaInput = document.getElementById('total_kerja')
    const absensi = JSON.parse('{!! json_encode($absensi) !!}')
    const getTotalKerja = (absen) => {
        let total = 0;
        for (let i = 0; i < absen.length; i++) {
            if (absen[i].status == 'hadir') {
                total++
            }
        }
        totalKerjaInput.value = total
    }
    getTotalKerja(absensi)
</script>

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
    })
</script>
