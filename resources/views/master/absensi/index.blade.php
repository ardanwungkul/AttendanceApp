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
                        <td class="!text-center">
                            <a href="{{ route('absensi.show', ['tahun' => $tahun, 'minggu' => $minggu]) }}"
                                class="text-blue-500 hover:underline">Lihat Detail</a>
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
    })
</script>
