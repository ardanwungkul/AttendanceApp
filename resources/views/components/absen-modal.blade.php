<div id="absen-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <form action="{{ route('absensi.store') }}" method="post" class="w-full" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="hidden" name="nip" value="{{ Auth::user()->karyawan->nip }}">
            <input type="hidden" name="status" value="tidak hadir">
            <input type="hidden" name="tipe" value="check_in">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Absen/Tidak Hadir
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="absen-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div class="space-y-1">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="4" class="w-full rounded-lg" required></textarea>
                    </div>
                    <div class="space-y-1">
                        <label for="lampiran">Lampiran</label>
                        <input type="file" name="lampiran" id="lampiran" class="w-full rounded-lg border text-sm"
                            required />
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="text-white bg-mineral-green-700 hover:bg-mineral-green-800 focus:ring-4 focus:outline-none focus:ring-mineral-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-mineral-green-600 dark:hover:bg-mineral-green-700 dark:focus:ring-mineral-green-800">Simpan</button>
                    <button data-modal-hide="absen-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-mineral-green-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
