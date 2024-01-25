document.addEventListener('DOMContentLoaded', function() {
    // Se obtienen referencias a los campos del formulario
    var nombreInput = document.getElementById('nombre');
    var primerApellidoInput = document.getElementById('primer_apellido');
    var segundoApellidoInput = document.getElementById('segundo_apellido');
    var nifInput = document.getElementById('nif');
    var telefonoInput = document.getElementById('telefono');
    var emailInput = document.getElementById('email');
    // Se agrega un event listener al formulario para el evento de envío
    document.getElementById('aspiranteRegistro').addEventListener('submit', function(event) {
        // Si la validación del formulario no pasa, se evita que se envíe el formulario
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    // Función que realiza la validación del formulario
    function validateForm() {
        var nombre = nombreInput.value;
        var primerApellido = primerApellidoInput.value;
        var segundoApellido = segundoApellidoInput.value;
        var nif = nifInput.value;
        var telefono = telefonoInput.value;
        var email = emailInput.value;

        // Se limpian los mensajes de error existentes
        clearErrorMessages();

        var errors = [];

        // Validación del campo "nombre"
        validateName(nombre, errors);

        // Validación del campo "primer_apellido"
        validateAp1(primerApellido, errors);

        // Validación del campo "nif"
        validateNif(nif, errors);

        // Validación del campo "telefono"
        validateTel(telefono, errors);

        // Validación del campo "email"
        validateEmail(email, errors);

        // Se muestran los mensajes de error, si los hay
        displayErrors(errors);

        // El formulario es válido si no hay errores
        return errors.length === 0;
    }


    // Función que valida el campo de nombre
    function validateName(nombre, errors) {
        if (nombre.trim() === '') {
            errors.push('Por favor, ingresa tu nombre.');
        }
    }

    // Función que valida el campo de primer apellido
    function validateAp1(primerApellido, errors) {
        if (primerApellido.trim() === '') {
            errors.push('Por favor, ingresa tu primer apellido.');
        }
    }

    // Función que valida el campo del nif
    function validateNif(nif, errors) {
        if (nif.trim() === '') {
            errors.push('Por favor, ingresa tu nif.');
        } else {
            // Expresión regular para validar el formato del nif en España (8 dígitos y una letra)
            var dniRegex = /^[0-9]{8}[a-zA-Z]$/;

            // Validar que el nif cumpla con el formato esperado
            if (!dniRegex.test(nif)) {
                errors.push('Por favor, ingresa un nif válido (8 dígitos seguidos de una letra).');
            } else {
                // Validar la letra del nif
                var letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
                var letraDNI = nif.charAt(nif.length - 1).toUpperCase();
                var digitosDNI = parseInt(nif.substring(0, nif.length - 1), 10);

                if (letras.charAt(digitosDNI % 23) !== letraDNI) {
                    errors.push('La letra del nif no es válida.');
                }
            }
        }
    }

    // Función que valida el campo de número de teléfono en España
    function validateTel(telefono, errors) {
        if (telefono.trim() === '') {
            errors.push('Por favor, ingresa tu número de teléfono.');
        } else {
            // Expresión regular para validar el número de teléfono en España
            var phoneRegex = /^(\+34|0034|34)?[6789]\d{8}$/;

            // Validar que el teléfono cumpla con el patrón de España
            if (!phoneRegex.test(telefono)) {
                errors.push('Por favor, ingresa un número de teléfono válido en España.');
            }
        }
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

    // Función que muestra los mensajes de error en los contenedores correspondientes
    function displayErrors(errors) {
        for (var i = 0; i < errors.length; i++) {
            var errorContainerId = 'emailError'; // Contenedor predeterminado

            // Se verifica si el mensaje de error incluye la palabra "email"
            if (errors[i].toLowerCase().includes('email')) {
                errorContainerId = 'emailError';
            }

            if (errors[i].toLowerCase().includes('nombre')) {
                errorContainerId = 'nombreError';
            }

            if (errors[i].toLowerCase().includes('primer apellido')) {
                errorContainerId = 'ap1Error';
            }

            if (errors[i].toLowerCase().includes('nif')) {
                errorContainerId = 'nifError';
            }

            if (errors[i].toLowerCase().includes('teléfono')) {
                errorContainerId = 'telefonoError';
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
        document.getElementById('nombreError').textContent = '';
        document.getElementById('ap1Error').textContent = '';
        document.getElementById('nifError').textContent = '';
        document.getElementById('telefonoError').textContent = '';
        document.getElementById('emailError').textContent = '';
    }
});

