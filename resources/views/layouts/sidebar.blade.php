<div class="h-screen flex flex-row fixed">
    <div class="flex flex-col w-56 bg-gray-50 rounded-r-lg overflow-hidden shadow-lg pt-4">
        <div class="flex items-center px-4 pb-4 h-20">
            <x-application-logo />
        </div>
        <div class="border-t mx-3"></div>
        <div class="py-2 flex-col flex justify-between h-full">
            <ul class="flex flex-col">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                                class="fa-solid fa-objects-column"></i></span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengguna.index') }}"
                        class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                                class="fa-solid fa-users"></i></span>
                        <span class="text-sm font-medium">Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('karyawan.index') }}"
                        class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                                class="fa-solid fa-user-tie"></i></span>
                        <span class="text-sm font-medium">Karyawan</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                                class="fa-solid fa-clipboard-user"></i></span>
                        <span class="text-sm font-medium">Absensi</span>
                    </a>
                </li>
            </ul>
            <ul class="flex flex-col">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800 w-full">
                            <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400">
                                <i class="fa-solid fa-right-from-bracket"></i></span>
                            <span class="text-sm font-medium">Logout</span>
                        </button>
                    </form>
                </li>

            </ul>

        </div>
    </div>
</div>
