<x-app-layout>
    <x-slot name="header">Daftar Gaji</x-slot>
    <div class="pb-4 relative pt-5">
        <table class="w-full border rounded-lg overflow-hidden" id="datatable">
            <thead class="bg-mineral-green-200 font-bold">
                <tr>
                    <td class="!text-center w-10">No</td>
                    <td>Periode Gaji</td>
                    <td class="!text-center !w-48">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($gaji as $item)
                    <tr>
                        <td class="text-center">{{ $loop->index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->periode_awal)->format('F j, Y') }} s/d
                            {{ \Carbon\Carbon::parse($item->periode_akhir)->format('F j, Y') }}</td>
                        <td class="flex justify-center items-end gap-3 text-xs">
                            <a href="{{ route('gaji.list', [$item->periode_awal, $item->periode_akhir]) }}"
                                class="bg-green-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90">
                                <i class="fa-solid fa-eye"></i>
                                <span> Lihat detail
                                </span>
                            </a>

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
            language: {
                'search': '',
                'searchPlaceholder': 'Search for items'
            },
        });
    })
</script>
