<x-guest-layout>


    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

        <table>
            <tbody>
                <tr>
                    <td class="break-words border-collapse" style="vertical-align: top;">
                        <div class="mx-auto min-w-min max-w-screen-md break-words bg-gray-400">
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

                            <table class="font-sans mt-6" role="presentation" cellpadding="0" cellspacing="0"
                                width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td class="p-0 text-left">
                                            <div class="text-base leading-5 text-white text-center">
                                                <p class="mb-3">
                                                    <span class="text-lg leading-tight" style="color: #ffffff;">Por favor indícanos su correo electrónico.</span>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="mx-auto min-w-min max-w-screen-md break-words bg-white">
                            <table class="font-sans" role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                border="0">
                                <tbody>
                                    <tr>
                                        <td class="p-10 text-left">
                                            <div class="text-base leading-6">

                                                <p class="mb-6">
                                                    ¿Olvidaste tu contraseña? Ningún problema. Simplemente háganos saber
                                                    su dirección de correo electrónico y le enviaremos un enlace para
                                                    restablecer su contraseña que le permitirá elegir una nueva.
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
                                                        <x-text-input id="email" class="block mt-1 w-full"
                                                            type="email" name="email" :value="old('email')" required
                                                            autofocus />
                                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                    </div>

                                                    <div class="w-full relative h-32 flex flex-row items-center justify-center">
                                                        <a href="{{route('login')}}" class="absolute left-6 py-2 mt-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                class="w-10 h-10 mb-2 mt-auto hover:scale-110">
                                                                <path
                                                                    d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zm352-160l-160 160c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L301.3 256 438.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0z" />
                                                            </svg>
                                                        </a>


                                                        <div class="flex flex-col items-center">
                                                            <x-primary-button>
                                                                {{ __('Enviar') }}
                                                            </x-primary-button>
                                                        </div>

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
    </div>
</x-guest-layout>
