Vue.createApp({
    data() {
        return {
            loading: false,
            baseUrl: $('#burl').val(),
            acessos: [],
            solicitacoes: [],
            idAdmin: 0
        }
    },

    methods: {
        logout(){
            this.loading = true

            $.ajax({
                url: this.baseUrl+'login/logout',
                type: "POST",
                dataType: 'json',                
                success: function(data){
                    if(data.success){
                        if(data.success == 1){
                            window.location.href = baseUrl 
                        }else{
                            alert('Houve um problema na requisição, tente novamente mais tarde ou entre em contato com o desenvolvedor.')
                        }
                    }
                },
                complete: function(){
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

        buscarDadosIniciais(){
            $.ajax({
                url: this.baseUrl+'api/dashboard/buscar-dados',
                type: "POST",
                dataType: 'json',                
                success: (data) => {
                    this.acessos = data.acessos
                    this.solicitacoes = data.solicitacoes
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

        this.buscarDadosIniciais()

    }
}).mount('#app')

function loading(){
    $('.loading').fadeIn('fast')
}

function loadingComplete(){
    $('.loading').fadeOut('fast')
}