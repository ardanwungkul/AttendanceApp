<x-app-layout>
    {{-- @if (\Carbon\Carbon::now()->isWeekday()) --}}
    <div class="space-y-3">
        <div>
            <p
                class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight border-b w-min whitespace-nowrap pb-1 pr-3">
                {{ \Carbon\Carbon::now()->format('d M Y') }}
            </p>
        </div>
        <div class="flex justify-between ">
            <div class="text-center bg-mineral-green-500 text-white rounded-lg py-2 px-3 shadow-lg">
                <p class="text-sm">Jam Masuk</p>
                <p class="text-sm">-</p>
            </div>
            <div class="text-center bg-mineral-green-500 text-white rounded-lg py-2 px-3 shadow-lg">
                <p class="text-sm">Jam Pulang</p>
                <p class="text-sm">-</p>
            </div>
        </div>
        <div>
            <div
                class="rounded-full border border-gray-700 aspect-square flex items-center justify-center max-w-40 mx-auto shadow-lg bg-white">
                <span class="text-xl font-bold" id="clock"></span>
            </div>
        </div>
        <div class="flex flex-col items-center gap-3">
            <button
                class="text-center max-w-40 border rounded-lg w-full py-1 px-3 bg-green-500 text-white shadow-lg hover:bg-opacity-80 text-sm">Hadir</button>
            <button
                class="text-center max-w-40 border rounded-lg w-full py-1 px-3 bg-red-500 text-white shadow-lg hover:bg-opacity-80 text-sm">Absen</button>
        </div>
    </div>
    {{-- @else --}}
    {{-- <div class="flex h-[calc(100vh-96px)] items-center">
        <div class="bg-mineral-green-100 rounded-lg p-3 shadow-lg">
            <p>Absensi tidak dapat dilakukan karena hari ini adalah hari libur. Silakan melakukan absensi pada
                hari kerja berikutnya.</p>
        </div>
    </div> --}}
    {{-- @endif --}}
</x-app-layout>
<script>
    function updateClock() {
        var now = new Date();
        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');
        var seconds = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('clock').innerHTML = hours + ':' + minutes + ':' + seconds;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
