Vue.createApp({
    data() {
        return {
            idAdmin: 0,
            loading: false,
            solicitacao: [],
            baseUrl: $('#baseUrl').val(),
            isAvaliador: false,
            listas: []
        }
    },

    methods: {
        buscarSolicitacao(){
            $.ajax({
                url: this.baseUrl+'api/solicitacao/buscar',
                type: "POST",
                dataType: 'json',                
                success: (data) => {
                    this.solicitacao = data.solicitacao
                    this.listas = data.listas
                },
                complete: () => {
                    this.loading = false
                }
            });
        },

        buscarIdAdmin(){
            var data = new FormData();
            data.append('filtros', this.filtros)
            this.loading = true
            $.ajax({
                url: this.baseUrl+'api/auth/id',
                type: "POST",
                dataType: 'json',                
                success: (data) => {
                    this.idAdmin = data.id
                }
            });
        }
    },

    mounted(){
        this.buscarIdAdmin()
        this.buscarSolicitacao()
    },
}).mount('#app')