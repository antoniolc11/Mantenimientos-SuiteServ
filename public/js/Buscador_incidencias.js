function buscarIncidencia() {
    return {
        porestados: '',
        porprioridad: '',
        porcategoria: '',
        pordepartamento: '',
        searchTerm: '',
        resultados: [],
        buscarIncidencia2() {
            let campo = this.searchTerm.trim()

            axios.get(`/buscar-incidencia`, {
                    params: {
                        search: campo,
                        estado: this.porestados,
                        prioridad: this.porprioridad,
                        categoria: this.porcategoria,
                        departamento: this.pordepartamento,
                    }
                })
                .then(response => {
                    this.resultados = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    };
}

