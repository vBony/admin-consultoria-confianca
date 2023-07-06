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
            },
            paging: []
        }
    },

    methods: {
        buscarSolicitacoes(){
            this.loading = true
            
            var data = new FormData();
            data.append('filtros', this.filtros)
            data.append('paging', this.paging)

            $.ajax({
                url: this.baseUrl+'solicitacoes/buscar',
                type: "POST",             
                data: {filtros: this.filtros, "paging": this.paging}, 
                dataType: 'json',                
                success: (data) => {
                    this.listaStatus = data.status
                    this.solicitacoes = data.solicitacoes.data
                    this.minhasSolicitacoes = data.minhasSolicitacoes
                    this.tiposSolicitacao = data.tiposSolicitacao
                    this.paging = data.solicitacoes.paging

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

        $('#paging').mask("#")

        $(function () {
            $('[data-toggle="popover"]').popover()
        })

        this.buscarIdAdmin()
        this.buscarSolicitacoes()
    }
}).mount('#app')