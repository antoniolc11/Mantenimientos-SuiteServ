document.addEventListener('DOMContentLoaded', function () {
    // Se obtienen referencias a los campos de correo electrónico y contraseña
    var passwordInput = document.getElementById('password');
    var passwordRepet = document.getElementById('password_confirmation');

    // Se agrega un event listener al formulario para el evento de envío
    document.getElementById('resetForm').addEventListener('submit', function (event) {
        // Si la validación del formulario no pasa, se evita que se envíe el formulario
        if (!validateLoginForm()) {
            event.preventDefault();
        }
    });

    // Función que realiza la validación del formulario
    function validateLoginForm() {
        var password = passwordInput.value;
        var passwordconfirm = passwordRepet.value;

        clearErrorMessages();

        var errors = [];

        // Se llama a la función de validación para la contraseña
        if (validatePassword(password, errors)) {
            validatePasswordConfirmation(passwordconfirm, password, errors);
        }


        // Se muestran los mensajes de error, si los hay
        displayErrors(errors);

        // El formulario es válido si no hay errores
        return errors.length === 0;
    }

    // Función que valida el campo de contraseña
    function validatePassword(password, errors) {
        // Verifica la longitud de la contraseña.
        if (password.length < 8) {
            errors.push("La contraseña debe tener almenos 8 caracteres.");
            return false;
        }

        // Verifica la presencia de al menos un número.
        if (!/\d/.test(password)) {
            errors.push("La contraseña debe contener al menos un número.");
            return false;
        }

        // Verifica la presencia de al menos una letra.
        if (!/[a-zA-Z]/.test(password)) {
            errors.push("La contraseña debe contener al menos una letra.");
            return false;
        }

        // Verifica la presencia de al menos una letra mayuscula.
        if (!/[A-Z]/.test(password)) {
            errors.push("La contraseña debe contener al menos una letra mayuscula.");
            return false;
        }

        // Si cumple con todos los requisitos, la contraseña es válida.
        return true;
    }

    // Valida la coincidencia de las contraseñas.
    function validatePasswordConfirmation(passwordConfirmation, password, errors) {
        if (passwordConfirmation === "") {
            errors.push("Vuelva a escribir su contraseña.");
            return false;
        }
        if (passwordConfirmation !== password) {
            errors.push("Las contraseñas no coinciden.");
            return false;
        }
        return true;
    }

    // Función que muestra los mensajes de error en los contenedores correspondientes
    function displayErrors(errors) {
        for (var i = 0; i < errors.length; i++) {
            var errorContainerId = 'emailError'; // Contenedor predeterminado

            // Se verifica si el mensaje de error incluye la palabra "contraseña"
            if (errors[i].toLowerCase().includes('contraseña')) {
                errorContainerId = 'passwordError';
            }

            // Se verifica si el mensaje de error incluye la palabra "contraseña"
            if (errors[i].toLowerCase().includes('contraseñas')) {
                errorContainerId = 'passwordConfirm';
            }

            // Se verifica si el mensaje de error incluye la palabra "contraseña"
            if (errors[i].toLowerCase().includes('vuelva a escribir su contraseña')) {
                errorContainerId = 'passwordConfirm';
            }


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
        document.getElementById('passwordConfirm').textContent = '';
        document.getElementById('passwordError').textContent = '';
    }
});
