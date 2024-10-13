<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 ">
        <main class="max-w-6xl bg-white mx-auto py-6 px-8 space-y-6">
            <div class="border-b pb-3 border-mineral-green-200 mb-4">
                <p class="text-xl font-semibold tracking-wide">Detail Pembayaran Minggu Ke-{{ $minggu }}</p>
            </div>
            <section class="grid grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                    <p class="text-lg">{{ $karyawan->nama_lengkap }}</p>
                </div>
                <div>
                    <x-input-label for="jenis_kelamin" :value="__('NIP')" />
                    <p class="text-lg">{{ $karyawan->nip }}</p>
                </div>
                <div>
                    <x-input-label for="tempat_lahir" :value="__('Divisi')" />
                    <p class="text-lg">{{ $karyawan->divisi->nama_divisi }}</p>
                </div>
                <div>
                    <x-input-label for="tempat_lahir" :value="__('Status')" />
                    <p class="text-lg">Sudah Dibayar</p>
                </div>
                <div>
                    <x-input-label for="tanggal_lahir" :value="__('Periode Awal')" />
                    <p class="text-lg">{{ $gaji->periode_awal }}</p>
                </div>
                <div>
                    <x-input-label for="no_hp" :value="__('Periode Akhir')" />
                    <p class="text-lg">{{ $gaji->periode_akhir }}</p>
                </div>
            </section>
            <table class="w-full border rounded-lg overflow-hidden" id="datatable">
                <thead class="bg-mineral-green-200 font-bold">
                    <tr>
                        <td class="!text-center">No</td>
                        <td class="!text-center">Tanggal Kerja</td>
                        <td class="!text-center">Jam Masuk</td>
                        <td class="!text-center">Jam Keluar</td>
                        <td class="!text-center">Status</td>
                        <td class="!text-center">Keterangan</td>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($absensi as $item)
                        <tr>
                            <td class="!text-center">{{ $no++ }}</td>
                            <td class="!text-center">{{ $item->tanggal_kerja }}</td>
                            <td class="!text-center">{{ $item->jam_masuk }}</td>
                            <td class="!text-center">{{ $item->jam_keluar }}</td>
                            <td class="!text-center">
                                <p
                                    class="py-1 px-2 rounded-full capitalize font-semibold {{ $item->status === 'hadir' ? 'bg-green-300 text-green-700' : 'bg-red-300 text-red-700' }}">
                                    {{ $item->status }}</p>
                            </td>
                            <td class="!text-center">{{ $item->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <section>
                <div class="flex flex-col items-end justify-center">
                    <h3>Total : Rp.<span>{{ number_format($gaji->total_gaji, 0, ',', '.') }}</span></h3>
                    <div class="mt-3 text-center">
                        <h3>Tertanda</h3>
                        <br />
                        <br />
                        <h3>Taufik Yahya</h3>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js">
    </script>
    <script src="{{ asset('assets/js/font-awesome.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                info: false,
                lengthChange: false,
                searching: false,
                paging: false,
                language: {
                    'search': '',
                    'searchPlaceholder': 'Search for items'
                },
            });
        })
    </script>
</body>

</html>
