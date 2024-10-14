<x-app-layout>
    <x-slot name="header">Pengaturan</x-slot>
    <form action="{{ route('pengaturan.store') }}" method="POST" class="mt-4">
        @csrf
        @method('POST')
        <div class="space-y-4">
            <fieldset class="space-y-4 border rounded-lg p-4">
                <legend class="font-semibold">Jam Kerja</legend>
                <div class="!mt-0">
                    <x-input-label for="jam_masuk" :value="__('Jam Masuk')" />
                    <x-text-input id="jam_masuk" class="block mt-1 w-full text-sm" type="time" name="jam_masuk"
                        required step="any" autofocus :value="$pengaturan->jam_masuk" />
                </div>
                <div class="">
                    <x-input-label for="jam_keluar" :value="__('Jam Keluar')" />
                    <x-text-input id="jam_keluar" class="block mt-1 w-full text-sm" type="time" name="jam_keluar"
                        required step="any" autofocus :value="$pengaturan->jam_keluar" />
                </div>
                <div class="">
                    <x-input-label for="batas_waktu" :value="__('Batas Waktu')" />
                    <x-text-input id="batas_waktu" class="block mt-1 w-full text-sm" type="time" name="batas_waktu"
                        required step="any" autofocus :value="$pengaturan->batas_waktu" />
                </div>
            </fieldset>
            <fieldset class="space-y-4 border rounded-lg p-4">
                <legend class="font-semibold">Lokasi Absensi</legend>
                <div id="map" class="h-40 w-full"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ $pengaturan->latitude }}">
                <input type="hidden" name="longitude" id="longitude"value="{{ $pengaturan->longitude }}">
                <div class="!mt-0">
                    <x-input-label for="radius" :value="__('Radius (Meter)')" />
                    <x-text-input id="radius" class="block mt-1 w-full text-sm" type="number" name="radius"
                        required step="any" autofocus :value="$pengaturan->radius" />
                </div>
                <button type="button" id="locateButton" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">
                    Pindah ke Lokasi Sekarang
                </button>
            </fieldset>
            <div class="flex justify-end">
                <button type="submit"
                    class="px-5 py-2 bg-mineral-green-500 rounded-lg shadow-lg text-white hover:bg-opacity-90">Simpan</button>
            </div>
        </div>
    </form>
</x-app-layout>
<script>
    const initialLat = {{ $pengaturan->latitude }};
    const initialLng = {{ $pengaturan->longitude }};
    const radiusInput = document.getElementById('radius');

    let currentPositionMarker;
    const customIcon = L.icon({
        iconUrl: `{{ asset('assets/images/people.png') }}`,
        iconSize: [41, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });
    const map = L.map('map').setView([initialLat, initialLng], 16);
    let marker = L.marker([initialLat, initialLng]).addTo(map);
    let circle = L.circle([initialLat, initialLng], {
        color: 'blue',
        fillColor: '#30f',
        fillOpacity: 0.5,
        radius: radiusInput.value
    }).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    radiusInput.addEventListener('input', () => {
        if (circle) {
            circle.setRadius(radiusInput.value);
        }
    });

    map.on('click', (e) => {
        const {
            lat,
            lng
        } = e.latlng;

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        marker.setLatLng(e.latlng);

        circle.setLatLng(e.latlng);
        circle.setRadius(radiusInput.value);
    });
    document.getElementById('locateButton').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                if (currentPositionMarker) {
                    currentPositionMarker.setLatLng([lat, lng])
                } else {
                    currentPositionMarker = L.marker([lat, lng], {
                        icon: customIcon
                    }).addTo(map);
                }

                map.setView([lat, lng], 16);
            }, () => {
                alert("Gagal mendapatkan lokasi Anda.");
            });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }
    });
</script>
