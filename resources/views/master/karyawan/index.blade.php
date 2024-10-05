<x-app-layout>
    <x-slot name="header">Daftar Karyawan</x-slot>
    <div class="pb-4 relative pt-5">
        <div class="pb-5">
            <a href="{{ route('karyawan.create') }}"
                class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Tambah
                Karyawan</a>
        </div>
        <table class="w-full border rounded-lg overflow-hidden" id="datatable">
            <thead class="bg-mineral-green-200 font-bold">
                <tr>
                    <td class="!text-center w-10">NIP</td>
                    <td>Nama Lengkap</td>
                    <td>Nama Pengguna</td>
                    <td>Jenis Kelamin</td>
                    <td>Divisi</td>
                    <td>No HP</td>
                    <td>Tempat Tanggal Lahir</td>
                    <td class="!text-center !w-48">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->index + 1 }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->user->username }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->divisi->nama_divisi }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->tempat_lahir }}, {{ $item->tanggal_lahir }}</td>
                        <td class="flex justify-center items-end gap-3 text-xs">
                            <a href="{{ route('karyawan.edit', $item->nip) }}"
                                class="bg-blue-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90">
                                <i class="fa-solid fa-pen"></i>
                                <span> Edit
                                </span>
                            </a>
                            <form action="{{ route('karyawan.destroy', $item->nip) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-red-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90">
                                    <i class="fa-solid fa-trash"></i>
                                    <span> Delete
                                    </span>
                                </button>
                            </form>
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
