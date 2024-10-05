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
    <div class="fixed top-5 right-10 z-50">
        @if (count($errors) > 0)
            <div class="alertError flex items-start w-full max-w-xs px-4 py-2 mb-4 bg-white rounded-lg shadow gap-1 border border-red-500"
                role="alert">
                <div class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-1">
                            <div
                                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                </svg>
                                <span class="sr-only">Error icon</span>
                            </div>
                            <div class="ms-3 text-sm font-normal text-red-500 block">{{ $error }}</div>
                        </div>
                    @endforeach
                </div>
                <button type="button"
                    class="close-btn ms-auto -my-1.5 bg-white  text-red-500 hover:text-red-400 rounded-lg focus:ring-2  inline-flex items-center justify-center h-8 w-8"
                    data-dismiss-target="#toast-danger" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
    </div>
    @if (session('success'))
        <div class="fixed bottom-5 right-10 z-50">
            <div class="alertError flex items-center w-full max-w-xs px-4 py-2 mb-4 bg-white rounded-lg shadow gap-1 border border-green-500"
                role="alert">
                <div class="space-y-1">
                    <div class="flex items-center gap-1">
                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="sr-only">Check icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal text-green-500 block"> {{ session('success') }}</div>
                    </div>
                </div>
                <button type="button"
                    class="close-btn ms-auto -my-1.5 bg-white  text-green-500 hover:text-green-400 rounded-lg focus:ring-2  inline-flex items-center justify-center h-8 w-8"
                    data-dismiss-target="#toast-danger" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
    <div class="min-h-screen bg-gray-100 flex relative">
        @if (Auth::user()->role !== 'karyawan')
            @include('layouts.sidebar')
        @endif
        <main class=" {{ Auth::user()->role !== 'karyawan' ? 'pl-[254px]' : '' }} w-full p-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                @if (isset($header))
                    <div class="border-b pb-3 border-mineral-green-200">
                        <p class="text-xl font-semibold tracking-wide">{{ $header }}</p>
                    </div>
                @endif
                {{ $slot }}
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js">
    </script>
    <script src="{{ asset('assets/js/font-awesome.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.close-btn').click(function() {
                $(this).closest('.alertError').remove();
            });
        });
    </script>
</body>

</html>
