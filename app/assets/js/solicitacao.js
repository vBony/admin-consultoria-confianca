Vue.createApp({
    data() {
        return {
            idAdmin: 0,
            loading: false,
            loadingStatusAvaliacao: 0,
            loadingTelefone: false,
            loadingEmail: false,
            solicitacao: [],
            baseUrl: $('#baseUrl').val(),
            isAvaliador: false,
            listas: [],
            mensagemWhatsapp: '',
            mensagemEmail: '',
            observacaoAdmin: ''
        }
    },

    methods: {
        buscarSolicitacao(){
            let tipoSolicitacao = this.getParameterByName('tipo')

            var data = new FormData();
            data.append('tipoSolicitacao', tipoSolicitacao)

            $.ajax({
                url: this.baseUrl+'api/solicitacao/buscar',
                type: "POST",
                data: {tipoSolicitacao: tipoSolicitacao},
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
            let tipoSolicitacao = this.getParameterByName('tipo')
            
            var data = new FormData();
            data.append('idSolicitacao', idSolicitacao)
            data.append('tipoSolicitacao', tipoSolicitacao)

            this.loadingStatusAvaliacao = true
            $.ajax({
                url: this.baseUrl+'api/solicitacao/tornar-avaliador',
                data: {idSolicitacao: idSolicitacao, tipoSolicitacao: tipoSolicitacao},
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

        abrirWhatsapp(){
            if(this.solicitacao['telefone']){
                window.open(`https://api.whatsapp.com/send?phone=${this.solicitacao['telefone']}`, '_blank')
            }else{
                alert("Não foi possível realizar essa ação.")
            }
        },

        getTelefone(){
            let idSolicitacao = this.solicitacao['id']
            let tipoSolicitacao = this.getParameterByName('tipo')

            var data = new FormData();
            data.append('idSolicitacao', idSolicitacao)
            data.append('tipoSolicitacao', tipoSolicitacao)

            this.loadingTelefone = true
            $.ajax({
                url: this.baseUrl+'api/solicitacao/telefone-cliente',
                data: {idSolicitacao: idSolicitacao, tipoSolicitacao: tipoSolicitacao},
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
            let tipoSolicitacao = this.getParameterByName('tipo')

            var data = new FormData();
            data.append('idSolicitacao', idSolicitacao)
            data.append('tipoSolicitacao', tipoSolicitacao)


            Swal.fire({
                title: 'Confirmar aprovação',
                text: "Confirma a aprovação dessa solicitação?",
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Aguarde...',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    })
                    Swal.showLoading()

                    $.ajax({
                        url: this.baseUrl+'api/solicitacao/aprovar',
                        data: {idSolicitacao: idSolicitacao, tipoSolicitacao: tipoSolicitacao},
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
        },

        reprovarSolicitacao(){
            let tipoSolicitacao = this.getParameterByName('tipo')


            var data = new FormData();
            data.append('idSolicitacao', this.solicitacao['id'])
            data.append('motivo', this.solicitacao['observacaoAdmin'])
            data.append('tipoSolicitacao', tipoSolicitacao)

            Swal.fire({
                title: 'Confirmar reprovação',
                text: "Confirma a reprovação dessa solicitação?",
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Aguarde...',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    })
                    Swal.showLoading()

                    $.ajax({
                        url: this.baseUrl+'api/solicitacao/reprovar',
                        data: {
                            idSolicitacao: this.solicitacao['id'],
                            motivo: this.solicitacao['observacaoAdmin'],
                            tipoSolicitacao: tipoSolicitacao
                        },
                        type: "POST",
                        dataType: 'json',                
                        success: (data) => {
                            if(data.success){
                                this.solicitacao['statusAdmin'] = data.status
                                this.solicitacao['adminDate'] = data.date
                                this.solicitacao['observacaoAdmin'] = data.motivo
                                Swal.fire('Sucesso', 'Solicitação reprovada com sucesso', 'success')
                                $('#modalReprovarSolicitacao').modal('hide')
                            }else if(data.error){
                                Swal.fire('Erro', data.error, 'error')
                            }else{
                                Swal.fire('Erro', "Houve um erro na requisição, tente novamente mais tarde", 'error')  
                            }
                        }
                    });
                }
            })
        },

        copyToClipboard(text, element) {
            navigator.clipboard.writeText(text);

            let button = $(element)
            if(button.length){
                let originalText = $(element).val()
                
                button.text('copiado!')
                setTimeout(() => {
                    button.text(originalText)
                }, 2000);
            }else{
                console.log('element not found');
            }
        },

        carregarEmail(){
            $('#modalEmail').modal('show')
            this.loadingEmail = true

            let idSolicitacao = this.solicitacao['id']
            let tipoSolicitacao = this.getParameterByName('tipo')

            var data = new FormData();
            data.append('idSolicitacao', idSolicitacao)
            data.append('tipoSolicitacao', tipoSolicitacao)

            $.ajax({
                url: this.baseUrl+'api/solicitacao/email-cliente',
                data: {idSolicitacao: idSolicitacao, tipoSolicitacao: tipoSolicitacao},
                type: "POST",
                dataType: 'json',                
                success: (data) => {
                    if(data.email){
                        this.solicitacao['email'] = data.email
                    }else{
                        if(data.error){
                            $('#modalEmail').modal('hide')
                            alert(data.error)
                        }else{
                            alert("Houve um erro na requisição.")
                        }
                    }
                },
                complete: () => {
                    this.loadingEmail = false
                }
            });
        },

        getParameterByName(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
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