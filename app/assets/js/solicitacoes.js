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
                }
            });
        },

        buscarIdAdmin(){
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

        $(function () {
            $('[data-toggle="popover"]').popover()
        })

        this.loading = true
        this.buscarIdAdmin()
        this.loading = false
        this.buscarSolicitacoes()

        setInterval(() => {
            this.buscarSolicitacoes()
        }, 30000);
    }
}).mount('#app')