<div
    class="cookie-notice-container bg-black text-white p-4 fixed bottom-0 left-0 w-full h-auto
     hidden opacity-80 transition-opacity duration-500 ease-in-out">
    <span id="cn-notice-text" class="cn-text-container block mb-4 ">
        <p class="leading-relaxed">
            En Mantenimientos SuiteServ Solutions, nos tomamos en serio tu privacidad y queremos asegurarte que tu
            experiencia en nuestro proceso de selección sea transparente y segura.
            Al hacer clic en "Más información", podrás acceder a detalles adicionales sobre nuestra política de
            privacidad para candidatos. Este documento aborda cómo manejamos tus datos, la información que recopilamos
            durante el proceso de selección y cómo la utilizamos.
            Entendemos la importancia de proteger tus datos personales y estamos comprometidos a garantizar que tengas
            toda la información necesaria para tomar decisiones informadas durante tu participación en nuestro proceso
            de selección.
            Gracias por confiar en nosotros. Si tienes alguna pregunta o inquietud, no dudes en ponerte en contacto con
            nuestro equipo de recursos humanos.
        </p>
        <a id="masInfo" class="text-blue-200 underline cursor-help">Más información</a>
    </span>
    <span id="cn-notice-buttons" class="cn-buttons-container mr-4">
        <a href="#" id="cn-accept-cookie" data-cookie-set="accept"
            class="cn-set-cookie cn-button bg-white hover:bg-gray-400 text-black font-bold w-auto  rounded px-4 py-2 transition duration-200 ease-in-out"
            aria-label="Aceptar">
            Aceptar
        </a>
    </span>
    <span id="cn-close-notice" data-cookie-set="accept"
        class="bg-white hover:bg-gray-400 text-black font-bold w-auto  rounded px-4 py-2 transition duration-200 ease-in-out cursor-pointer"
        title="No">rechazar</span>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var cookieAccepted = getCookie('cookieAccepted');
        var cookieNoticeContainer = document.querySelector('.cookie-notice-container');
        var form = document.getElementById('aspiranteRegistro');

        if (!cookieAccepted && cookieNoticeContainer) {
            // Mostrar el aviso de cookies solo si la cookie no ha sido aceptada
            cookieNoticeContainer.classList.remove('hidden');
            cookieNoticeContainer.classList.add('block');
            form.classList.add('pointer-events-none');

            var acceptButton = document.getElementById('cn-accept-cookie');
            var closeButton = document.getElementById('cn-close-notice');


            if (acceptButton) {
                acceptButton.addEventListener('click', function() {
                    // Lógica para aceptar cookies
                    // Obtener la fecha actual
                    var currentDate = new Date();

                    // Calcular la fecha de expiración sumando 6 meses
                    var expirationDate = new Date(currentDate);
                    expirationDate.setMonth(currentDate.getMonth() + 6);

                    // Formatear la fecha de expiración en el formato necesario para la cookie
                    var formattedExpirationDate = expirationDate.toUTCString();

                    // Establecer la cookie con la fecha de expiración calculada
                    document.cookie = "cookieAccepted=true; expires=" + formattedExpirationDate +
                        "; path=/";
                    cookieNoticeContainer.classList.remove('block');
                    cookieNoticeContainer.classList.add('hidden');
                    form.classList.remove('pointer-events-none');


                });
            }

            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    // Lógica para manejar el cierre del aviso de cookies sin aceptar
                    // Por ejemplo, puedes redirigir al usuario a una página específica o mostrar un mensaje de advertencia
                    alert('Por favor, acepta las cookies para poder registrarte como candidato.');
                });
            }

            // Prevenir el envío del formulario por defecto
            if (form) {
                form.addEventListener('submit', function(event) {
                    // Verificar si las cookies han sido aceptadas
                    if (getCookie('cookieAccepted')) {
                        // Cookies aceptadas, permitir el envío del formulario
                        form.submit();
                    } else {
                        // Cookies no aceptadas, mostrar mensaje de advertencia
                        alert('Por favor, acepta las cookies para poder registrarte como candidato.');
                        event.preventDefault(); // Evitar el envío del formulario
                    }
                });
            }
        }


        // Función para obtener el valor de una cookie por su nombre
        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }

        document.getElementById('masInfo').addEventListener('click', function() {
            // Obtiene el ancho y el alto de la pantalla
            // Tamaño de la ventana
            var windowWidth = 750;
            var windowHeight = 550;

            // Tamaño de la pantalla
            var screenWidth = window.screen.width;
            var screenHeight = window.screen.height;

            // Calcular la posición para centrar la ventana
            var leftPosition = (screenWidth - windowWidth) / 2;
            var topPosition = (screenHeight - windowHeight) / 2;

            // Abrir la ventana con el tamaño y posición calculados
            window.open("{{ route('politica.privacidad') }}", "Política de Privacidad", "width=" +
                windowWidth + ",height=" + windowHeight + ",left=" + leftPosition + ",top=" +
                topPosition);

        });
    });
</script>

