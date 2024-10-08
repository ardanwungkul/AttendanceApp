<x-app-layout>
    <x-slot name="header">Daftar Pengguna</x-slot>
    <div class="pb-4 relative pt-5">
        <div class="pb-5">
            <a href="{{ route('pengguna.create') }}"
                class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Tambah
                Pengguna</a>
        </div>
        <table class="w-full border rounded-lg overflow-hidden" id="datatable">
            <thead class="bg-mineral-green-200 font-bold">
                <tr>
                    <td class="!text-center w-10">No</td>
                    <td>Username</td>
                    <td>Role</td>
                    <td class="!text-center !w-48">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengguna as $item)
                    <tr>
                        <td class="text-center">{{ $loop->index + 1 }}</td>
                        <td>{{ $item->username }}</td>
                        <td class="capitalize">{{ $item->role }}</td>
                        <td class="flex justify-center items-end gap-3 text-xs">
                            <a href="{{ route('pengguna.edit', $item->id) }}"
                                class="bg-blue-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90">
                                <i class="fa-solid fa-pen"></i>
                                <span> Edit
                                </span>
                            </a>
                            <form action="{{ route('pengguna.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
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
