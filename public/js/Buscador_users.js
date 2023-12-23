
window.routeShow = "{{ route('users.show', ['user' => ':user_id']) }}";
window.routeEdit = "{{ route('users.edit', ['user' => ':user_id']) }}";

function buscarUsuario() {
    return {
        routeShow: window.routeShow,
        primer_apellido: '',
        email: '',
        departamento: '',
        nombre: '',
        resultados: [],

        bloquearUsuario(usuario) {
            // Llamada a la API para bloquear al usuario
            axios.post(`/usuario/addbanned/${usuario.id}`)
                .then(response => {
                    console.log('Usuario bloqueado:', response.data);
                    usuario.status = 0;

                    // Luego, ejecutar la búsqueda nuevamente para actualizar la interfaz
                    this.buscarUsuario2();
                    // Puedes realizar acciones adicionales si es necesario
                })
                .catch(error => {
                    console.error('Error al bloquear usuario:', error);
                });
        },

        desbloquearUsuario(usuario) {
            // Llamada a la API para desbloquear al usuario
            axios.post(`/usuario/outbanned/${usuario.id}`)
                .then(response => {
                    console.log('Usuario desbloqueado:', response.data);
                    usuario.status = 1;
                    // Luego, ejecutar la búsqueda nuevamente para actualizar la interfaz
                    this.buscarUsuario2();
                    // Puedes realizar acciones adicionales si es necesario
                })
                .catch(error => {
                    console.error('Error al desbloquear usuario:', error);
                });
        },



        buscarUsuario2() {
            let nombre = this.nombre.trim()

            let primer_apellido = this.primer_apellido.trim()
            let email = this.email.trim()
            let departamento = this.departamento.trim()

            // Realiza una llamada AJAX a tu servidor para buscar usuario por nombre

            axios.get(`/buscador/user`, {
                    params: {
                        nombre: nombre,
                        primer_apellido: this.primer_apellido,
                        email: this.email,
                        departamento: this.departamento,
                    }

                })
                .then(response => {
                    this.resultados = response.data.usuarios;

                })
                .catch(error => {
                    console.error(error);
                });
        }
    };
}

