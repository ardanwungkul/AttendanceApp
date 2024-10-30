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
                <button type="submit" data-modal-target="gaji-modal" data-modal-toggle="gaji-modal"
                    class="px-5 py-2 bg-blue-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Bayar
                    Gaji</button>
                <div id="gaji-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <form action="{{ route('gaji.store') }}" method="post"
                            class="relative bg-white rounded-lg shadow dark:bg-gray-700 py-3 px-6">
                            @csrf
                            @method('POST')
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                                Pilih Tipe Pembayaran Gaji
                            </h3>
                            <div class="mb-3">
                                <x-input-label for="tipe_pembayaran" :value="__('Tipe Pembayaran')" />
                                <select id="tipe_pembayaran" name="tipe_pembayaran" required
                                    class="w-full border-gray-300 focus:border-mineral-green-500 focus:ring-mineral-green-500 rounded-md shadow-sm">
                                    <option value="tunai">Tunai</option>
                                    <option value="transfer">Transfer</option>
                                </select>

                                <!-- Display account number if it exists -->
                                @if ($karyawan->no_rekening)
                                    <p id="rekeningInfo" class="text-gray-600 mt-2">No Rekening:
                                        {{ $karyawan->no_rekening }}</p>
                                @else
                                    <p id="rekeningWarning" class="text-red-500 hidden mt-2">* No Rekening tidak
                                        tersedia untuk transfer.</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <x-input-label for="total_gaji" :value="__('Total Pembayaran Gaji ')" />
                                <input readonly type="number" name="total_gaji" id="total_gaji"
                                    class="block mt-1 w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-mineral-green-500 dark:focus:border-mineral-green-600 focus:ring-mineral-green-500 dark:focus:ring-mineral-green-600 rounded-md shadow-sm">
                            </div>

                            <!-- Hidden Inputs -->
                            <input hidden type="text" name="nip" value="{{ $karyawan->nip }}">
                            <input hidden type="date" name="periode_awal" value="{{ $startDate->format('Y-m-d') }}">
                            <input hidden type="date" name="periode_akhir" value="{{ $endDate->format('Y-m-d') }}">
                            <div class="w-full flex justify-end">
                                <button id="submitButton" type="submit"
                                    class="px-5 py-2 bg-blue-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Bayar
                                    Gaji</button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($gaji)
                <a href="{{ route('gaji.show', ['tahun' => $tahun, 'minggu' => $minggu, 'gaji' => $gaji->id]) }}"
                    class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Lihat
                    Detail Pembayaran</a>
            @endif

        </div>
    </div>
</x-app-layout>

<script>
    const noRekening = JSON.parse('{!! json_encode($karyawan->no_rekening) !!}');

    document.getElementById('tipe_pembayaran').addEventListener('change', function() {
        const submitButton = document.getElementById('submitButton');
        const rekeningWarning = document.getElementById('rekeningWarning');

        if (this.value === 'transfer' && !noRekening) {
            submitButton.disabled = true;
            rekeningWarning.classList.remove('hidden');
        } else {
            submitButton.disabled = false;
            rekeningWarning && rekeningWarning.classList.add('hidden');
        }
    });
</script>

<script>
    let totalGaji = document.getElementById('total_gaji')
    const absensi = JSON.parse('{!! json_encode($absensi) !!}')
    const upah = JSON.parse('{!! json_encode($karyawan->divisi->upah_per_hari) !!}')
    const getTotalKerja = (absen) => {
        let total = 0;
        for (let i = 0; i < absen.length; i++) {
            if (absen[i].status == 'hadir') {
                total++
            }
        }
        totalGaji.value = total * upah;
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
