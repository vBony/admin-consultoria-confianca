Vue.createApp({
    data() {
        return {
            idCargo: 0,
            codigos:[],
            loading: false,
            messages:[],
            codigo: '',
            cargos: [],
            usuario: [],
            usuarios: [],
            loadingUsuario: true
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
        },

        buscarCargos(){
            let baseUrl = $('#baseUrl').val()

            axios.post(baseUrl+'api/usuario/buscar-cargos')
            .then((response) => {
                this.cargos = response.data.listas.cargos
            })
        },

        buscarUsuarios(){
            let baseUrl = $('#baseUrl').val()
            axios.post(baseUrl+'api/usuario/buscar')
            .then((response) => {
                this.usuarios = response.data.listas.usuarios
            })
        },
        
        dadosUsuarioSelecionado(id){
            this.usuario = []
            this.loadingUsuario = true


            let data = new FormData()
            data.append('id', id);

            let baseUrl = $('#baseUrl').val()
            axios.post(baseUrl+'api/usuario/buscar', data)
            .then((response) => {
                this.usuario = response.data.usuario
            }).finally(() => {
                this.loadingUsuario =  false
            });
        }
    },

    mounted(){
        this.buscarCodigos(),
        this.buscarCargos(),
        this.buscarUsuarios()
    }
}).mount('#app')