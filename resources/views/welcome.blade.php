<x-app-layout>
    <div class="flex flex-col items-center gap-3">
        <input type="time" id="time-input" class="border rounded-lg py-1 px-3 text-gray-800" />
    </div>
    @if (\Carbon\Carbon::now()->isWeekday())
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
                            class="text-center border rounded-lg w-full py-1 px-3 bg-green-500 text-white shadow-lg hover:bg-opacity-80 text-sm"
                            onclick="getLocation(event)">Hadir</button>
                    </form>
                    <button data-modal-target="absen-modal" data-modal-toggle="absen-modal"
                        class="text-center max-w-40 border rounded-lg w-full py-1 px-3 bg-red-500 text-white shadow-lg hover:bg-opacity-80 text-sm">Absen</button>


                    <x-absen-modal></x-absen-modal>

                </div>
            @else
                @if (!$absensi->jam_keluar && $absensi->status == 'hadir    ')
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
    @else
        <div class="flex h-[calc(75vh)] items-center justify-center">
            <div class="bg-mineral-green-100 rounded-lg p-3 shadow-lg">
                <p>Absensi tidak dapat dilakukan karena hari ini adalah hari libur. Silakan melakukan absensi pada
                    hari kerja berikutnya.</p>
            </div>
        </div>
    @endif
</x-app-layout>
<script>
    let currentHour, currentMinute;
    let timeOffset = 0;
    const batas_waktu = JSON.parse('{!! json_encode($pengaturan->batas_waktu) !!}')


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


        var currentTime = now.getHours() * 3600 + now.getMinutes() * 60 + now
            .getSeconds();
        var batasWaktuParts = batas_waktu.split(':');
        var batasWaktuInSeconds = parseInt(batasWaktuParts[0]) * 3600 + parseInt(batasWaktuParts[1]) * 60 + parseInt(
            batasWaktuParts[2]);
        if (currentTime < batasWaktuInSeconds) {
            document.getElementById('check-in').style.display = 'flex';
        } else {
            document.getElementById('check-in').style.display = 'none';
        }
    }
    document.getElementById('time-input').addEventListener('change', function() {
        const timeValue = this.value;
        const [hour, minute] = timeValue.split(':');
        currentHour = parseInt(hour, 10);
        currentMinute = parseInt(minute, 10);
        timeOffset = 0;
    });
    // setInterval(updateClock, 1000);
    // updateClock();
    setInterval(() => {
        timeOffset++;
        updateClock();
    }, 1000);
</script>
<script>
    function getLocation(event) {
        event.preventDefault();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation tidak didukung oleh browser Anda.");
        }
    }

    function showPosition(position) {
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;
        console.log(latitude, longitude);


        // Kirim lokasi ke form menggunakan input hidden
        // let form = document.getElementById('absensiForm');
        // let latInput = document.createElement('input');
        // let lonInput = document.createElement('input');

        // latInput.type = 'hidden';
        // latInput.name = 'latitude';
        // latInput.value = latitude;

        // lonInput.type = 'hidden';
        // lonInput.name = 'longitude';
        // lonInput.value = longitude;

        // form.appendChild(latInput);
        // form.appendChild(lonInput);

        // Setelah lokasi ditambahkan ke form, submit form
        // form.submit();
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("Pengguna menolak permintaan Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Informasi lokasi tidak tersedia.");
                break;
            case error.TIMEOUT:
                alert("Permintaan untuk mendapatkan lokasi pengguna habis.");
                break;
            case error.UNKNOWN_ERROR:
                alert("Terjadi kesalahan yang tidak diketahui.");
                break;
        }
    }
</script>
