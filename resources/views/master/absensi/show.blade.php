<x-app-layout>
    <x-slot name="header">Detail Absensi Minggu ke-{{ $minggu }} Tahun {{ $tahun }}</x-slot>
    <div class="pb-4 relative pt-8">
        <div class="pb-5 flex items-center justify-end">
            <a href="{{ route('absensi.index') }}"
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
                        <td class="!text-center">{{ $item->status }}</td>
                        <td class="!text-center">{{ $item->keterangan }}</td>
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
    })
</script>
