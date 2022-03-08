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
                    this.idCargo = 0
                }
            })
            .catch((error) => {
                this.loading = false
            }).finally(() => {
                this.loading =  false
            });
        },

        buscarCodigos(){
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
        },

        copyToClipboard(text, element) {
            navigator.clipboard.writeText(text);

            let button = $(element)
            if(button.length){
                let originalText = $(element).text()
                
                button.text('copiado!')
                setTimeout(() => {
                    button.text(originalText)
                }, 2000);
            }else{
                console.log('element not found');
            }
        }
    },

    mounted(){
        this.buscarCodigos()
    }
}).mount('#app')