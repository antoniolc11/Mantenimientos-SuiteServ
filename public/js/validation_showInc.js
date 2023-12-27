
        // Validación del formulario de alta de incidencias.
        document.addEventListener('DOMContentLoaded', function() {
            // Se obtienen referencias a los campos del formulario
            var descripcionInput = document.getElementById('descripcion');
            // Se agrega un event listener al formulario para el evento de envío

            document.getElementById('finIncidencia').addEventListener('submit', function(event) {
                // Si la validación del formulario no pasa, se evita que se envíe el formulario
                if (!validateForm()) {
                    event.preventDefault();
                }
            });

            // Función que realiza la validación del formulario
            function validateForm() {
                var descripcion = descripcionInput.value.trim();

                // Se limpian los mensajes de error existentes
                clearErrorMessages();

                var errors = [];

                // Validación del campo "descripción"
                validateDescripcion(descripcion, errors);

                // Se muestran los mensajes de error, si los hay
                displayErrors(errors);

                // El formulario es válido si no hay errores
                return errors.length === 0;
            }

            // Función que valida el campo de desc
            function validateDescripcion(descripcion, errors) {
                if (descripcion.trim() === '') {
                    errors.push('Por favor, describe el trabajo realizado en esta incidencia.');
                } else if (descripcion.length < 10) {
                    errors.push('La descripción debe tener al menos 30 caracteres.');
                }
            }


            // Función que muestra los mensajes de error en los contenedores correspondientes
            function displayErrors(errors) {
                for (var i = 0; i < errors.length; i++) {
                    var errorContainerId = 'descripcionError'; // Contenedor predeterminado

                    if (errors[i].toLowerCase().includes('descripción')) {
                        errorContainerId = 'descripcionError';
                    }

                    // Se obtiene el contenedor de error correspondiente y se crea un elemento de párrafo con el mensaje de error
                    var errorContainer = document.getElementById(errorContainerId);
                    var errorMessage = document.createElement('p');
                    errorMessage.textContent = errors[i];
                    errorContainer.appendChild(errorMessage);
                }
            }

            // Función para limpiar los mensajes de error existentes en los contenedores
            function clearErrorMessages() {
                document.getElementById('descripcionError').textContent = '';
            }
        });

