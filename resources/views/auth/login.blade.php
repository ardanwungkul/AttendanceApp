<x-guest-layout>
    <div
        class="max-w-3xl mx-auto flex justify-between gap-x-6 px-8 py-6 bg-white dark:bg-gray-50 shadow-md overflow-hidden sm:rounded-lg max-h-[80vh]">
        <div class="w-1/2 relative rounded-xl overflow-hidden">
            <div class="absolute w-full h-full bg-mineral-green-500/30"></div>
            <img src="https://images.unsplash.com/photo-1617191562585-f6a64bf68df0?q=80&w=1527&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="catering-illustration">
        </div>
        <div class="w-1/2 flex flex-col justify-center">
            <div class="mb-3">
                <x-application-logo />
                <h3 class="text-gray-600 tracking-tight mt-1">Selamat Datang di CV Budi Abadi !
                </h3>

            </div>
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                        :value="old('username')" required autofocus autocomplete="username" placeholder="Masukkan Username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" placeholder="Masukkan Password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-mineral-green-600 shadow-sm focus:ring-mineral-green-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ __('Masuk') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

</x-guest-layout>
