Vue.createApp({
    data() {
        return {
            idAdmin: 0,
            loading: false,
            loadingStatusAvaliacao: 0,
            loadingTelefone: false,
            solicitacao: [],
            baseUrl: $('#baseUrl').val(),
            isAvaliador: false,
            listas: [],
            mensagemWhatsapp: '',
            mensagemEmail: ''
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

            this.loadingTelefone = true
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
                    this.loadingTelefone = false
                }
            });
        },
        
        copiarNumeroCliente(){

            if(this.solicitacao['telefone']){
                navigator.clipboard.writeText(this.solicitacao['telefone']);
                Swal.fire({
                    icon: 'success',
                    title: 'Telefone copiado!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                })
            }else{
                alert("Não foi possível realizar essa ação.")
            }
        },
        
        confirmaAprovacao(){
            let idSolicitacao = this.solicitacao['id']

            var data = new FormData();
            data.append('idSolicitacao', idSolicitacao)

            Swal.fire({
                title: 'Confirma aprovação',
                text: "Confirma a aprovação dessa solicitação?",
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Aguarde um momento...', '', '')
                    Swal.showLoading()

                    $.ajax({
                        url: this.baseUrl+'api/solicitacao/aprovar',
                        data: {idSolicitacao: idSolicitacao},
                        type: "POST",
                        dataType: 'json',                
                        success: (data) => {
                            if(data.success){
                                this.solicitacao['statusAdmin'] = data.status
                                this.solicitacao['adminDate'] = data.date
                                Swal.fire('Sucesso', 'Solicitação aprovada com sucesso', 'success')
                            }else if(data.error){
                                Swal.fire('Erro', data.error, 'error')
                            }else{
                                Swal.fire('Erro', "Houve um erro na requisição, tente novamente mais tarde", 'error')  
                            }
                        }
                    });
                }
            })
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