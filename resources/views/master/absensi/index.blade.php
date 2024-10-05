<x-app-layout>
    <x-slot name="header">Riwayat Absensi</x-slot>
    <div class="pb-4 relative pt-16">
        <table class="w-full border rounded-lg overflow-hidden" id="datatable">
            <thead class="bg-mineral-green-200 font-bold">
                <tr>
                    <td class="!text-center w-10">No</td>
                    <td class="!text-center w-48">Bulan</td>
                    <td>Periode</td>
                    <td class="!text-center !w-48">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($groupedAbsensi as $key => $items)
                    @php
                        // Ekstrak tahun, bulan, dan minggu dari key yang sudah dikelompokkan
                        $explodedKey = explode('-', $key);
                        $tahun = $explodedKey[0];
                        $bulan = $explodedKey[1];
                        $minggu = $explodedKey[3];
                    @endphp
                    <tr>
                        <td class="!text-center">{{ $no++ }}</td>
                        <td class="!text-center">{{ $bulan }} {{ $tahun }}</td>
                        <td>Minggu ke-{{ $minggu }}</td>
                        <td class="!text-center">
                            <a href="{{ route('absensi.show', ['tahun' => $tahun, 'bulan' => $bulan, 'minggu' => $minggu]) }}"
                                class="text-blue-500 hover:text-blue-700">Lihat Detail</a>
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
            language: {
                'search': '',
                'searchPlaceholder': 'Search for items'
            },
        });
    })
</script>
