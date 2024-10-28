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
                            <button data-modal-target="{{ 'user-modal' . $item->id }}"
                                data-modal-toggle="{{ 'user-modal' . $item->id }}"
                                class="bg-red-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90">
                                <i class="fa-solid fa-trash"></i>
                                <span> Delete
                                </span>
                            </button>
                            <div id="{{ 'user-modal' . $item->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <form action="{{ route('pengguna.destroy', $item->id) }}" method="POST"
                                        class="relative bg-white rounded-lg shadow dark:bg-gray-700 py-3 px-6">
                                        @csrf
                                        @method('DELETE')
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                            Hapus Pengguna ini?
                                        </h3>
                                        <p class="text-base text-gray-600 mb-3">
                                            Apakah kamu yakin untuk menghapus {{ $item->username }} ?
                                        </p>
                                        <div class="w-full flex items-center justify-end gap-x-3">
                                            <button type="submit"
                                                class="bg-red-500 px-6 py-2 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90 text-base">
                                                Hapus
                                            </button>
                                            <div data-modal-hide="{{ 'user-modal' . $item->id }}"
                                                class="bg-gray-200 px-6 py-2 rounded-lg text-gray-800 flex gap-2 items-center hover:bg-opacity-90 text-base cursor-pointer">
                                                Tidak
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
            language: {
                'search': '',
                'searchPlaceholder': 'Search for items'
            },
        });
    })
</script>
