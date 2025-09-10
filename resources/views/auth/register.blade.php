<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Nombre completo')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password"
                              name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label :value="__('¿Qué eres?')" />
                <div class="mt-2 flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="role" value="estudiante" required {{ old('role') == 'estudiante' ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Estudiante') }}</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="role" value="docente" required {{ old('role') == 'docente' ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Docente') }}</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta?') }}
                </a>

                <x-primary-button class="ml-3">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>