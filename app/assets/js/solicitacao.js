Vue.createApp({
    data() {
        return {
            idAdmin: 0,
            loading: false,
            loadingStatusAvaliacao: 0,
            solicitacao: [],
            baseUrl: $('#baseUrl').val(),
            isAvaliador: false,
            listas: [],
            mensagemWhatsapp: ''
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
        },
        
        tornarAvaliador(){
            let idSolicitacao = this.solicitacao['id']

            var data = new FormData();
            data.append('idSolicitacao', idSolicitacao)
            this.loadingStatusAvaliacao = true
            $.ajax({
                url: this.baseUrl+'api/solicitacao/tornar-avaliador',
                data: {idSolicitacao: idSolicitacao},
                type: "POST",
                dataType: 'json',                
                success: (data) => {
                    if(data.error){
                        Swal.fire(
                            'Erro ao definir Avaliador',
                            data.error,
                            'error'
                        )
                    }

                    if(data.solicitacao){
                        this.solicitacao = data.solicitacao

                        Swal.fire({
                            text: 'Agora você é avaliador desta solicitação',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                    }
                },
                complete: () => {
                    this.loadingStatusAvaliacao = false
                }
            });
        },

        ligarCliente(){
            if(this.solicitacao['telefone']){
                window.open(`tel:${this.solicitacao['telefone']}`, '_self')
            }else{
                alert("Não foi possível realizar essa ação.")
            }
        },

        getTelefone(){
            let idSolicitacao = this.solicitacao['id']

            var data = new FormData();
            data.append('idSolicitacao', idSolicitacao)

            $.ajax({
                url: this.baseUrl+'api/solicitacao/telefone-cliente',
                data: {idSolicitacao: idSolicitacao},
                type: "POST",
                dataType: 'json',                
                success: (data) => {
                    if(data.telefone){
                        this.solicitacao['telefone'] = data.telefone
                    }else{
                        if(data.error){
                            alert(data.error)
                        }else{
                            alert("Houve um erro na requisição.")
                        }
                    }
                },
                complete: () => {
                    this.loadingStatusAvaliacao = false
                }
            });
        }
        
    },

    mounted(){

        $(function () {
            $('[data-toggle="popover"]').popover()
        })
        
        this.buscarIdAdmin()
        this.buscarSolicitacao()
    },
}).mount('#app')