Vue.createApp({
    data() {
        return {
            loading: false,
            filtros: {
                tipoSolicitacao:1,
                teste:'teste'
            },
            baseUrl: $('#baseUrl').val(),
            solicitacoes: [],
            idAdmin: 0
        }
    },

    methods: {
        buscarSolicitacoes(){
            var data = new FormData();
            data.append('filtros', this.filtros)
            
            $.ajax({
                url: this.baseUrl+'solicitacoes/buscar',
                type: "POST",             
                data: {filtros: this.filtros}, 
                dataType: 'json',                
                success: (data) => {
                    this.solicitacoes = data.solicitacoes
                },
            });
        },

        buscarIdAdmin(){
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

        $(function () {
            $('[data-toggle="popover"]').popover()
        })

        this.buscarIdAdmin()
        this.buscarSolicitacoes()

        setInterval(() => {
            this.buscarSolicitacoes()
        }, 30000);
    }
}).mount('#app')