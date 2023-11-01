<x-guest-layout>


    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <table class="">
        <tbody>
            <tr>
                <td class="break-words border-collapse" style="vertical-align: top;">
                    <div class="mx-auto min-w-min max-w-screen-md break-words bg-gray-300">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="p-0 text-center">
                                    {{-- Logo empresa --}}
                                    <img src="{{ asset('imagenes/logo.png') }}" alt="Logo SuiteServ" title="Image"
                                        class="outline-none text-decoration-none m-auto block border-none max-w-10 h-auto w-40 mt-6"
                                        width="58" />
                                </td>
                            </tr>
                        </table>

                        <table class="font-sans mt-6" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                            <tbody>
                                <tr>
                                    <td class="p-0 text-left">
                                        <div class="text-base leading-5 text-white text-center">
                                            <p class="mb-3">
                                                <span class="text-lg leading-tight" style="color: #ffffff;">Por favor Por favor indícanos su correo electrónico.</span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="mx-auto min-w-min max-w-screen-md break-words bg-white">
                        <table class="font-sans" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                            <tbody>
                                <tr>
                                    <td class="p-10 text-left">
                                        <div class="text-base leading-6">
                                            <p class="mb-6">
                                                Hola,
                                            </p>
                                            <p class="mb-6">
                                                ¿Olvidaste tu contraseña? Ningún problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace para restablecer su contraseña que le permitirá elegir una nueva.
                                            </p>
                                            <p>
                                                Para restablecer su contraseña, introduzca su Email.
                                            </p>
                                        </div>

                                        <div class="mt-10">
                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf

                                                <!-- Email Address -->
                                                <div>
                                                    <x-input-label for="email" :value="__('Email')" />
                                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                                        required autofocus />
                                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                </div>

                                                <div class="flex items-center justify-center mt-7">
                                                    <x-primary-button>
                                                        {{ __('Restablece tu contraseña') }}
                                                    </x-primary-button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</x-guest-layout>
