console.log('validation_incidencia.js cargado...');

// Validación del formulario de alta de incidencias.
document.addEventListener('DOMContentLoaded', function() {
    // Se obtienen referencias a los campos del formulario
    var departamentoInput = document.getElementById('departamento');
    var usuarioInput = document.getElementById('usuario');
    var ubicacionInput = document.getElementById('ubicacion');
    var categoriaInput = document.getElementById('categoria');
    var descripcionInput = document.getElementById('descripcion');
    // Se agrega un event listener al formulario para el evento de envío

    document.getElementById('crearIncidencia').addEventListener('submit', function(event) {
        // Si la validación del formulario no pasa, se evita que se envíe el formulario
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    // Función que realiza la validación del formulario
    function validateForm() {
        var departamento = departamentoInput.value;
        var usuario = usuarioInput.value;
        var ubicacion = ubicacionInput.value;
        var categoria = categoriaInput.value;
        var descripcion = descripcionInput.value.trim();

        // Se limpian los mensajes de error existentes
        clearErrorMessages();

        var errors = [];

        // Validación del campo "departamento"
        validateDepartamento(departamento, errors);


        // Validación del campo "ubicación"
        validateUbicacion(ubicacion, errors);

        // Validación del campo "categoría"
        validateCategoria(categoria, errors);

        // Validación del campo "descripción"
        validateDescripcion(descripcion, errors);

        // Se muestran los mensajes de error, si los hay
        displayErrors(errors);

        // El formulario es válido si no hay errores
        return errors.length === 0;
    }

    // Función que valida el campo de departamento
    function validateDepartamento(departamento, errors) {
        if (departamento.trim() === '') {
            errors.push('Por favor, debes seleccionar un departamento.');
        }
    }


    // Función que valida el campo de ubicación.
    function validateUbicacion(ubicacion, errors) {
        if (ubicacion.trim() === '') {
            errors.push('Por favor, debes seleccionar una ubicación.');
        }
    }


    // Función que valida el campo de categoría.
    function validateCategoria(categoria, errors) {
        if (categoria.trim() === '') {
            errors.push('Por favor, debes seleccionar una categoría.');
        }
    }

    // Función que valida el campo de desc
    function validateDescripcion(descripcion, errors) {
        if (descripcion.trim() === '') {
            errors.push('Por favor, ingresa una descripción.');
        } else if (descripcion.length < 10) {
            errors.push('La descripción debe tener al menos 10 caracteres.');
        }
    }


    // Función que muestra los mensajes de error en los contenedores correspondientes
    function displayErrors(errors) {
        for (var i = 0; i < errors.length; i++) {
            var errorContainerId = 'emailError'; // Contenedor predeterminado

            // Se verifica si el mensaje de error incluye la palabra "email"
            if (errors[i].toLowerCase().includes('departamento')) {
                errorContainerId = 'departamentoError';
            }

            if (errors[i].toLowerCase().includes('ubicación')) {
                errorContainerId = 'ubicacionError';
            }

            if (errors[i].toLowerCase().includes('categoría')) {
                errorContainerId = 'categoriaError';
            }

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
        document.getElementById('departamentoError').textContent = '';
        document.getElementById('ubicacionError').textContent = '';
        document.getElementById('categoriaError').textContent = '';
        document.getElementById('descripcionError').textContent = '';
    }
});

