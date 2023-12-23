document.addEventListener('DOMContentLoaded', function() {
    // Se obtienen referencias a los campos de correo electrónico y contraseña
    var emailInput = document.getElementById('email');

    // Se agrega un event listener al formulario para el evento de envío
    document.getElementById('formPasswordRequest').addEventListener('submit', function(event) {
        // Si la validación del formulario no pasa, se evita que se envíe el formulario
        if (!validaterequestpassword()) {
            event.preventDefault();
        }
    });

    // Función que realiza la validación del formulario
    function validaterequestpassword() {
        var email = emailInput.value;

        clearErrorMessages();

        var errors = [];

        // Se llama a la función de validación para el correo electrónico
        validateEmail(email, errors);

        // Se muestran los mensajes de error, si los hay
        displayErrors(errors);

        // El formulario es válido si no hay errores
        return errors.length === 0;
    }

    // Función que valida el campo de correo electrónico
    function validateEmail(email, errors) {
        if (email.trim() === '') {
            errors.push('Por favor, ingresa tu correo electrónico.');
        } else {
            // Expresión regular para validar el formato del correo electrónico
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                errors.push('Por favor, ingresa un correo electrónico válido.');
            }
        }
    }

    // Función que muestra los mensajes de error.
    function displayErrors(errors) {
        for (var i = 0; i < errors.length; i++) {
            var errorContainerId = 'emailError'; // Contenedor predeterminado

            // Se verifica si el mensaje de error incluye la palabra "email"
            if (errors[i].toLowerCase().includes('email')) {
                errorContainerId = 'emailError';
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
        document.getElementById('emailError').textContent = '';

    }
});

