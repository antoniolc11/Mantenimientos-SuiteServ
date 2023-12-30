// Imprime un mensaje en la consola al cargar el script
console.log("validation_users.js cargado...");

// Espera a que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', function () {

    // Obtención de referencias a los elementos del formulario
    var nombreInput = document.getElementById('nombre');
    var primerApellidoInput = document.getElementById('primer_apellido');
    var nifInput = document.getElementById('nif');
    var telefonoInput = document.getElementById('telefono');
    var emailInput = document.getElementById('email');
    var departamentoInput = document.getElementById('departamento');

    // Agrega un event listener al formulario para el evento de envío
    document.getElementById('usersRegistro').addEventListener('submit', function (event) {
        // Si la validación del formulario no pasa, se evita que se envíe el formulario
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    // Mapeo de mensajes de error a contenedores correspondientes
    var errorContainerMapping = {
        'email': 'emailError',
        'nombre': 'nombreError',
        'primer apellido': 'ap1Error',
        'nif': 'nifError',
        'teléfono': 'telefonoError',
        'departamento': 'departamentoError'
    };

    // Expresiones regulares para validaciones
    var dniRegex = /^[0-9]{8}[a-zA-Z]$/;
    var phoneRegex = /^\d{9}$/;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Función principal de validación del formulario
    function validateForm() {
        // Obtención de valores de los campos del formulario
        var nombre = nombreInput.value;
        var primerApellido = primerApellidoInput.value;
        var nif = nifInput.value;
        var telefono = telefonoInput.value;
        var email = emailInput.value;
        var departamento = departamentoInput.value;

        // Limpieza de mensajes de error existentes
        clearErrorMessages();

        // Array para almacenar mensajes de error
        var errors = [];

        // Llamadas a funciones de validación para cada campo
        validateName(nombre, errors);
        validateAp1(primerApellido, errors);
        validateNif(nif, errors);
        validateTel(telefono, errors);
        validateEmail(email, errors);
        validateDepartamento(departamento, errors);

        // Muestra los mensajes de error, si los hay
        displayErrors(errors);

        // El formulario es válido si no hay errores
        return errors.length === 0;
    }

    // Función de validación para el campo de nombre
    function validateName(nombre, errors) {
        if (nombre.trim() === '') {
            errors.push('Por favor, ingresa tu nombre.');
        }
    }

    // Función de validación para el campo de primer apellido
    function validateAp1(primerApellido, errors) {
        if (primerApellido.trim() === '') {
            errors.push('Por favor, ingresa tu primer apellido.');
        }
    }

    // Función de validación para el campo de NIF
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

    // Función de validación para el campo de correo electrónico
    function validateEmail(email, errors) {
        if (email.trim() === '') {
            errors.push('Por favor, ingresa tu correo electrónico.');
        } else if (!emailRegex.test(email)) {
            errors.push('Por favor, ingresa un correo electrónico válido.');
        }
    }

    // Función de validación para el campo de departamento
    function validateDepartamento(departamento, errors) {
        if (departamento.trim() === '') {
            errors.push('Por favor, selecciona al menos un departamento.');
        }
    }

    // Función para mostrar mensajes de error en los contenedores correspondientes
    function displayErrors(errors) {
        for (var i = 0; i < errors.length; i++) {
            var errorContainerId = 'emailError'; // Contenedor predeterminado

            // Busca el contenedor correspondiente en el mapeo
            Object.keys(errorContainerMapping).forEach(function (key) {
                if (errors[i].toLowerCase().includes(key)) {
                    errorContainerId = errorContainerMapping[key];
                }
            });

            // Obtiene el contenedor de error y crea un elemento de párrafo con el mensaje de error
            var errorContainer = document.getElementById(errorContainerId);
            var errorMessage = document.createElement('p');
            errorMessage.textContent = errors[i];
            errorContainer.appendChild(errorMessage);
        }
    }

    // Función para limpiar los mensajes de error existentes en los contenedores
    function clearErrorMessages() {
        Object.values(errorContainerMapping).forEach(function (containerId) {
            document.getElementById(containerId).textContent = '';
        });
    }
});
