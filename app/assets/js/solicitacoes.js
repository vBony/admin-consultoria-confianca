Vue.createApp({
    data() {
        return {
            loading: false,
            filtros: {
                tipoSolicitacao:1,
                teste:'teste'
            },
            baseUrl: $('#baseUrl').val(),
            solicitacoes: []
        }
    },

    methods: {
        buscarSolicitacoes(){
            var data = new FormData();
            data.append('filtros', this.filtros)
            this.loading = true
            $.ajax({
                url: this.baseUrl+'solicitacoes/buscar',
                type: "POST",             
                data: {filtros: this.filtros}, 
                dataType: 'json',                
                success: (data) => {
                    this.solicitacoes = data.solicitacoes
                },
                complete: () => {
                    this.loading = false
                }
            });
        }
    },

    mounted(){
        $('[data-toggle=popover]').popover({
            trigger: 'hover',
        });
        this.buscarSolicitacoes()
    },
}).mount('#app')