Vue.createApp({
    data() {
        return {
            idAdmin: 0,
            loading: false,
            solicitacao: [],
            baseUrl: $('#baseUrl').val(),
            isAvaliador: false
        }
    },

    methods: {
        buscarSolicitacao(){
            var data = new FormData();
            data.append('filtros', this.filtros)
            this.loading = true
            $.ajax({
                url: this.baseUrl+'api/solicitacao/buscar',
                type: "POST",
                dataType: 'json',                
                success: (data) => {
                    this.solicitacao = data.solicitacao
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
                },
                complete: () => {
                    this.loading = false
                }
            });
        }
    },

    mounted(){
        this.buscarIdAdmin()
        this.buscarSolicitacao()
    },
}).mount('#app')