<x-app-layout>
    <x-slot name="header">Detail Absensi Minggu ke-{{ $minggu }} Tahun {{ $tahun }}</x-slot>
    <div class="pb-4 relative pt-6">
        <div class="pb-5 flex items-center justify-between">
            <h6 class="text-lg font-semibold">Status Pembayaran : <span
                    class="{{ $gaji ? 'text-green-500' : 'text-red-500' }}">{{ $gaji ? 'Sudah Dibayar' : 'Belum Dibayar' }}</span>
            </h6>
            <a href="{{ url()->previous() }}"
                class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Kembali</a>
        </div>
        <table class="w-full border rounded-lg overflow-hidden" id="datatable">
            <thead class="bg-mineral-green-200 font-bold">
                <tr>
                    <td class="!text-center">No</td>
                    <td class="!text-center">Tanggal Kerja</td>
                    <td class="!text-center">Jam Masuk</td>
                    <td class="!text-center">Jam Keluar</td>
                    <td class="!text-center">Status</td>
                    <td class="!text-center">Keterangan</td>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($absensi as $item)
                    <tr>
                        <td class="!text-center">{{ $no++ }}</td>
                        <td class="!text-center">{{ $item->tanggal_kerja }}</td>
                        <td class="!text-center">{{ $item->jam_masuk }}</td>
                        <td class="!text-center">{{ $item->jam_keluar }}</td>
                        <td class="!text-center">
                            <p
                                class="py-1 px-2 rounded-full capitalize font-semibold {{ $item->status === 'hadir' ? 'bg-green-300 text-green-700' : 'bg-red-300 text-red-700' }}">
                                {{ $item->status }}</p>
                        </td>
                        <td class="!text-center">{{ $item->keterangan }}</td>
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
                            <div class="mb-3 ">
                                <x-input-label for="tipe_pembayaran" :value="__('Tipe Pembayaran')" />
                                <select
                                    class="w-full border-gray-300 focus:border-mineral-green-500 focus:ring-mineral-green-500 rounded-md shadow-sm"
                                    id="tipe_pembayaran" name="tipe_pembayaran" class="block mt-1 w-full" required>
                                    <option value="tunai">Tunai</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                            <div class="mb-3 ">
                                <x-input-label for="total_gaji" :value="__('Total Pembayaran Gaji ')" />

                                <input readonly
                                    class="block mt-1 w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-mineral-green-500 dark:focus:border-mineral-green-600 focus:ring-mineral-green-500 dark:focus:ring-mineral-green-600 rounded-md shadow-sm"
                                    type="number" name="total_gaji" id="total_gaji">
                            </div>
                            <input hidden type="text" name="nip" value="{{ $karyawan->nip }}">
                            <input hidden type="date" name="periode_awal" value="{{ $startDate->format('Y-m-d') }}">
                            <input hidden type="date" name="periode_akhir" value="{{ $endDate->format('Y-m-d') }}">
                            <div class="w-full flex justify-end ">
                                <button type="submit"
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
        });
    })
</script>
