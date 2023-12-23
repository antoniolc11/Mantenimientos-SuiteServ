       <!-- Ventana modal que muestra el historial de la incidencia-->
       <div id="defaultModal" tabindex="-1" aria-hidden="true"
       class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
       <div class="relative w-full max-w-2xl max-h-full">
           <!-- Modal content -->
           <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
               <!-- Modal header -->
               <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">

                   <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                       Historial de la incidencia Nº: {{ $incidencia->numero }}
                   </h3>

                   <button type="button"
                       class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                       data-modal-hide="defaultModal">
                       <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                           viewBox="0 0 14 14">
                           <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                               stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                       </svg>
                       <span class="sr-only">Close modal</span>
                   </button>
               </div>

               <!-- Modal body -->
               <div class="p-6 space-y-6 overflow-y-auto max-h-[calc(100vh-200px)]">

                   @foreach ($historiales as $historial)
                       @if ($historial['estado_id'] == 1)
                           <h5 class="text-s font-semibold text-gray-900 dark:text-white">
                               Creación de la incidencia:
                           </h5>
                           <div
                               class="flex items-center space-x-2 border-b  border-gray-200 rounded-b dark:border-gray-600">

                               <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-6">
                                   Sé genera la incidencia con fecha:
                                   {{ \Carbon\Carbon::parse($historial->fecha)->format('d/m/Y') }} a las:
                                   {{ \Carbon\Carbon::parse($historial->hora_inicio)->format('H:i') }}.
                               </p>
                           </div>
                       @endif

                       @if ($historial['estado_id'] == 2)
                           <h5 class="text-s font-semibold text-gray-900 dark:text-white">
                               En curso.
                           </h5>
                           <div
                               class="flex items-center space-x-2 border-b border-gray-200 rounded-b dark:border-gray-600">

                               <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-6">
                                   Sé inicia la incidencia con fecha:
                                   {{ \Carbon\Carbon::parse($historial->fecha)->format('d/m/Y') }} Iniciada a las:
                                   {{ \Carbon\Carbon::parse($historial->hora_inicio)->format('H:i') }}.
                               </p>

                           </div>
                       @endif

                       @if ($historial['estado_id'] == 4)
                           <h5 class="text-s font-semibold text-gray-900 dark:text-white">
                               Reabierta.
                           </h5>
                           <div
                               class="flex items-center space-x-2 border-b border-gray-200 rounded-b dark:border-gray-600">


                               <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-6">
                                   La incidencia ha sido reabierta con fecha:
                                   {{ \Carbon\Carbon::parse($historial->fecha)->format('d/m/Y') }}, por tener
                                   tareas por completar a
                                   las:
                                   {{ \Carbon\Carbon::parse($historial->hora_inicio)->format('H:i') }}.
                               </p>
                           </div>
                       @endif

                       @if ($historial['estado_id'] == 3)
                           <h5 class="text-s font-semibold text-gray-900 dark:text-white">
                               Finalizada.
                           </h5>
                           <div
                               class="flex items-center space-x-2 border-b border-gray-200 rounded-b dark:border-gray-600">


                               <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-6">
                                   Sé finaliza la incidencia con fecha:
                                   {{ \Carbon\Carbon::parse($historial->fecha)->format('d/m/Y') }} Finalizada a
                                   las:
                                   {{ \Carbon\Carbon::parse($historial->hora_fin)->format('H:i') }}.
                               </p>
                           </div>
                       @endif
                   @endforeach
               </div>
               <!-- Modal footer -->
               <div
                   class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                   <button data-modal-hide="defaultModal" type="button"
                       class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Aceptar</button>


                   @if ($incidencia->estado_id == 3)
                       <button id="openParteTrabajo" type="button"
                           class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Parte
                           de trabajo</button>
                   @endif

                   <script>
                       // Agrega un evento de clic al botón "Parte de trabajo"
                       document.getElementById('openParteTrabajo').addEventListener('click', function() {
                           // Obtiene el ancho y el alto de la pantalla
                           var screenWidth = window.screen.width;
                           var screenHeight = window.screen.height;

                           // Abre una nueva ventana (pop-up) que ocupa el 100% de la pantalla
                           window.open("{{ route('generate-pdf', $incidencia) }}", "ParteDeTrabajo", "width=" + screenWidth +
                               ",height=" + screenHeight);
                       });
                   </script>

               </div>
           </div>
       </div>
   </div>
