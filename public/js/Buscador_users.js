function buscarUsuario() {
    return {
        routeShow: window.routeShow,
        primer_apellido: '',
        email: '',
        departamento: '',
        nombre: '',
        resultados: [],
        /* Paginacion usuarios */
        resul: [],
        paginaActual: 1,
        usuariosPorPagina: 5, // Número de usuarios por página
        totalUsuarios: 0, // Este valor debe ser actualizado con el total real de usuarios desde la respuesta del servidor


        cambiarPagina(pagina) {
            this.paginaActual = pagina;
            // Lógica para obtener los usuarios de la página actual desde el array completo
            // Puedes usar slice para obtener la porción correcta del array
            this.resul = this.getResultadosPagina();
        },

        getResultadosPagina() {
            const inicio = (this.paginaActual - 1) * this.usuariosPorPagina;
            const fin = inicio + this.usuariosPorPagina;
            return this.resultados.slice(inicio, fin);
        },

        bloquearUsuario(usuario) {
            // Llamada a la API para bloquear al usuario
            axios.post(`/usuario/addbanned/${usuario.id}`)
                .then(response => {
                    console.log('Usuario bloqueado:', response.data);
                    usuario.status = 0;

                    // Luego, ejecutar la búsqueda nuevamente para actualizar la interfaz
                    console.log(this.paginaActual);
                    //this.buscarUsuario2();

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
                   // this.buscarUsuario2();
                    // Puedes realizar acciones adicionales si es necesario
                })
                .catch(error => {
                    console.error('Error al desbloquear usuario:', error);
                });
        },



        buscarUsuario2() {
            this.paginaActual = 1
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
                    this.totalUsuarios = this.resultados.length; // Asegúrate de obtener este valor desde la respuesta del servidor
                    this.resul = this.getResultadosPagina();


                })
                .catch(error => {
                    console.error(error);
                });
        }
    };
}

