Vue.createApp({
    data() {
        return {
            loading: false,
            baseUrl: $('#baseUrl').val(),
            solicitacoes: [],
            tiposSolicitacao: [],
            idAdmin: 0,
            listaStatus: [],
            minhasSolicitacoes: 0,
            filtros: {
                minhasSolicitacoes: false,
                status: [],
                tiposSolicitacoes: []
            }
        }
    },

    methods: {
        buscarSolicitacoes(){
            this.loading = true
            
            var data = new FormData();
            data.append('filtros', this.filtros)

            
            $.ajax({
                url: this.baseUrl+'solicitacoes/buscar',
                type: "POST",             
                data: {filtros: this.filtros}, 
                dataType: 'json',                
                success: (data) => {
                    this.listaStatus = data.status
                    this.solicitacoes = data.solicitacoes
                    this.minhasSolicitacoes = data.minhasSolicitacoes
                    this.tiposSolicitacao = data.tiposSolicitacao

                    this.loading = false
                },
                complete(){
                    this.loading = false
                }
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
        },

        setMinhasSolicitacoes(){
            if(this.filtros.minhasSolicitacoes === true){
                this.filtros.minhasSolicitacoes = false
                $('#minhasSolicitacoesBtn').removeClass('active')
            }else{
                this.filtros.minhasSolicitacoes = true
                $('#minhasSolicitacoesBtn').addClass('active')
            }

            this.buscarSolicitacoes()
        },

        addTipoSolicitacao(){
            console.log(this.filtros.tiposSolicitacoes);
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