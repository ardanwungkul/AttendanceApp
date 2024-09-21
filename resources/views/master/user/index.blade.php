<x-app-layout>
    <x-slot name="header">Daftar Pengguna</x-slot>
    <div class="pb-4 relative pt-16">
        <table class="w-full border rounded-lg overflow-hidden" id="datatable">
            <thead class="bg-mineral-green-200 font-bold">
                <tr>
                    <td class="!text-center w-10">No</td>
                    <td>Username</td>
                    <td class="!text-center !w-48">Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $item)
                    <tr>
                        <td class="text-center">{{ $loop->index + 1 }}</td>
                        <td>{{ $item->username }}</td>
                        <td class="flex justify-center items-end gap-3 text-xs">
                            <a href=""
                                class="bg-blue-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90">
                                <i class="fa-solid fa-pen"></i>
                                <span> Edit
                                </span>
                            </a>
                            <button
                                class="bg-red-500 px-3 py-1 rounded-lg text-white flex gap-2 items-center hover:bg-opacity-90">
                                <i class="fa-solid fa-trash"></i>
                                <span> Delete
                                </span>
                            </button>
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
