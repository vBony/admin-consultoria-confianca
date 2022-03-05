Vue.createApp({
    data() {
        return {
            idCargo: 0,
            codigos:[],
            loading: false,
            messages:[],
            codigo: ''
        }
    },

    methods: {
        gerarCodigo() {
            // const axios = require('axios').default;
            let baseUrl = $('#baseUrl').val()

            var data = new FormData();
            data.append('idCargo', this.idCargo)

            this.loading = true
            axios.post(baseUrl+'usuario/criar-codigo', data)
            .then((response) => {
                this.loading = false
                if(response.data.error){
                    alert('Houve um problema na requisição, tente novamente mais tarde!')
                }else if (response.data.erros){
                    this.messages = response.data.erros
                }else if(response.data.success){
                    this.codigos = response.data.codigos
                    this.codigo = response.data.codigo
                    toastr.success('Código criado com sucesso')
                }
            })
            .catch((error) => {
                this.loading = false
            }).finally(() => {
                this.loading =  false
            });
        }
    },

    mounted(){
        let baseUrl = $('#baseUrl').val()

        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
        };

        this.loading = true
        fetch(baseUrl+'usuario/codigos-disponiveis', requestOptions)
        .then(async response => {
            const data = await response.json();
            
            // check for error response
            if (!response.ok || data.error) {
                alert('Houve um problema na requisição, tente novamente mais tarde!')
                
                // get error message from body or default to response status
                // const error = (data && data.message) || response.status;
                // return Promise.reject(error);
            }
    
            this.codigos = data.codigos
            this.loading = false
        })
        .catch(error => {
            this.errorMessage = error;
            console.error('There was an error!', error);
        });
    }
}).mount('#app')