Vue.createApp({
    data() {
        return {
            idCargo: 0,
            codigos:[],
            loading: false
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
            if (!response.ok) {
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