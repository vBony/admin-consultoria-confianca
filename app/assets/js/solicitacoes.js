Vue.createApp({
    data() {
        return {
            loading: false,
            baseUrl: $('#baseUrl').val(),
            solicitacoes: [],
            idAdmin: 0,
            listaStatus: [],
            minhasSolicitacoes: 0,
            filtros: {
                minhasSolicitacoes: false,
                status: []
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

        addStatus(id){
            let found = false

            for (var i=0; i <= this.filtros.status.length; i++){
                if (this.filtros.status[i] == id){                    
                    this.filtros.status.splice(i, 1)
                    found = true
                }
            }

            if(!found){
                this.filtros.status.push(id)
            }

            this.buscarSolicitacoes()
        },

        setMinhasSolicitacoes(){
            if(this.filtros.minhasSolicitacoes === true){
                this.filtros.minhasSolicitacoes = false
            }else{
                this.filtros.minhasSolicitacoes = true
            }

            this.buscarSolicitacoes()
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