<x-app-layout>
    <div class="flex flex-col items-center gap-3">
        <input type="time" id="time-input" class="border rounded-lg py-1 px-3 text-gray-800" />
    </div>
    {{-- @if (\Carbon\Carbon::now()->isWeekday()) --}}
    <div class="space-y-3">
        <div>
            <p
                class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight border-b w-min whitespace-nowrap pb-1 pr-3">
                {{ \Carbon\Carbon::now()->format('d M Y') }}
            </p>
        </div>
        <div class="flex justify-between">
            <div class="text-center bg-mineral-green-500 text-white rounded-lg py-2 px-3 shadow-lg">
                <p class="text-sm">Jam Masuk</p>
                <p class="text-sm">{{ $absensi ? $absensi->jam_masuk : '-' }}</p>
            </div>
            <div class="text-center bg-mineral-green-500 text-white rounded-lg py-2 px-3 shadow-lg">
                <p class="text-sm">Jam Keluar</p>
                <p class="text-sm">{{ $absensi && $absensi->jam_keluar ? $absensi->jam_keluar : '-' }}</p>
            </div>
        </div>
        <div>
            <div
                class="rounded-full border border-gray-700 aspect-square flex items-center justify-center max-w-40 mx-auto shadow-lg bg-white">
                <span class="text-xl font-bold" id="clock"></span>
            </div>
        </div>
        @if (!$absensi)
            <div class="flex flex-col items-center gap-3" id="check-in" style="display: none;">
                <form action="{{ route('absensi.store') }}" method="post" class="w-full max-w-40">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="nip" value="{{ Auth::user()->karyawan->nip }}">
                    <input type="hidden" name="status" value="hadir">
                    <input type="hidden" name="tipe" value="check_in">
                    <button type="submit"
                        class="text-center border rounded-lg w-full py-1 px-3 bg-green-500 text-white shadow-lg hover:bg-opacity-80 text-sm">Hadir</button>
                </form>
                <button
                    class="text-center max-w-40 border rounded-lg w-full py-1 px-3 bg-red-500 text-white shadow-lg hover:bg-opacity-80 text-sm">Absen</button>
            </div>
        @else
            @if (!$absensi->jam_keluar)
                <div class="flex flex-col items-center gap-3" id="check-out">
                    <form action="{{ route('absensi.store') }}" method="post" class="w-full max-w-40">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="absensi_id" value="{{ $absensi->id }}">
                        <input type="hidden" name="tipe" value="check_out">
                        <button type="submit"
                            class="text-center border rounded-lg w-full py-1 px-3 bg-green-500 text-white shadow-lg hover:bg-opacity-80 text-sm">Pulang</button>
                    </form>
                </div>
            @endif
        @endif
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
    let currentHour, currentMinute;
    let timeOffset = 0;

    function updateClock() {
        var now = new Date();

        // simulasi
        if (currentHour !== undefined && currentMinute !== undefined) {
            now.setHours(currentHour);
            now.setMinutes(currentMinute);
            now.setSeconds(now.getSeconds() + timeOffset);
        } else {
            now = new Date();
        }

        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');
        var seconds = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('clock').innerHTML = hours + ':' + minutes + ':' + seconds;

        if (hours < 12) {
            document.getElementById('check-in').style.display = 'flex';
        } else {
            document.getElementById('check-in').style.display = 'none';
        }
    }
    document.getElementById('time-input').addEventListener('change', function() {
        const timeValue = this.value;
        const [hour, minute] = timeValue.split(':');
        currentHour = parseInt(hour, 10); // Set jam
        currentMinute = parseInt(minute, 10); // Set menit
        timeOffset = 0; // Reset offset saat waktu diubah
    });
    // setInterval(updateClock, 1000);
    // updateClock();
    setInterval(() => {
        timeOffset++;
        updateClock();
    }, 1000);
</script>
