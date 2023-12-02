<x-guest-layout>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">

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
                                                    <span class="text-lg leading-tight" style="color: #ffffff;">
                                                        Mantenimientos SuiteServ Solutions.</span>
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
                                                    Estimado/a
                                                    {{ $aspirante->nombre . ' ' . $aspirante->primer_apellido . ' ' . $aspirante->segundo_apellido }}
                                                </p>

                                                <p class="mb-6">

                                                    ¡Gracias por expresar tu interés en unirte a nuestro equipo! Estamos
                                                    emocionados de conocer más sobre ti. Para completar tu registro y
                                                    considerar tu aplicación, por favor, adjunta tu currículum vitae
                                                    (CV) en el siguiente formulario. Tu CV nos proporcionará información
                                                    valiosa sobre tu experiencia y habilidades, permitiéndonos evaluar
                                                    cómo puedes contribuir a nuestro equipo.

                                                </p>
                                                <p class="mb-6">

                                                    Por favor, asegúrate de incluir todos los detalles relevantes en tu
                                                    CV, como tu experiencia laboral, educación, habilidades clave y
                                                    cualquier otro elemento que consideres importante para destacar.
                                                    Estamos ansiosos por conocerte mejor y descubrir cómo tu perfil
                                                    encaja con nuestras oportunidades laborales.

                                                </p>
                                                <p class="mb-6">
                                                    ¡Gracias de nuevo por tu interés en trabajar con nosotros! Estamos
                                                    ansiosos por revisar tu aplicación y explorar la posibilidad de
                                                    tenerte como parte de nuestro equipo.
                                                </p>

                                                <p>
                                                    Un Cordial saludo, SuiteServ Solutions.
                                                </p>
                                            </div>

                                            <div class="mt-10">
                                                <form action="{{ route('upload.curriculum') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" name="aspirante_id"
                                                        value="{{ $aspirante->id }}">

                                                    <!-- Email Address -->
                                                    <div>
                                                        <x-input-label for="curriculum" :value="__('Adjunta tu CV')" />
                                                        <x-text-input id="curriculum" class="block mt-1 w-full"
                                                            type="file" name="curriculum" :value="old('curriculum')" required
                                                            autofocus />
                                                        <x-input-error :messages="$errors->get('curriculum')" class="mt-2" />
                                                    </div>


                                                    <div
                                                        class="w-full relative h-32 flex flex-row items-center justify-center">
                                                        <a href="{{ route('login') }}"
                                                            class="absolute left-6 py-2 mt-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 512 512"
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
