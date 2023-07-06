$(document).ready(function(){
    const baseUrl = $('#burl').val()

    $('.form-control').on('change', function(){
        $(this).removeClass('is-invalid')
        $(`#msg-${$(this).attr('name')}`).text('')
    })

    $('#regForm').submit(function(e){
        e.preventDefault()
        let data = $(this).serialize()
        
        clearErrors()
        loading()
        $.ajax({
            url: baseUrl+'cadastro/cadastrar',
            type: "POST",             
            data: data, 
            dataType: 'json',                
            success: function(data){

                if(data.error){
                    let errors = data.error
                    
                    Object.entries(errors).forEach(([index, message]) => {
                        $(`.form-control[name='${index}'`).addClass('is-invalid')
                        $(`.msg#msg-${index}`).text(message)
                    })
                }

                if(data.success){
                    if(data.success == 1){
                        window.location.href = baseUrl 
                    }else{
                        alert('Houve um problema na requisição, tente novamente mais tarde ou entre em contato com o desenvolvedor.')
                    }
                }

            },
            complete: function(){
                loadingComplete()
            }
        });
    })
})

function loading(){
    $('#btn-loading').show()
    $('#btn-register').hide()
    $('.form-control').prop('disabled', true)
}

function loadingComplete(){
    $('#btn-loading').hide()
    $('#btn-register').show()
    $('.form-control').prop('disabled', false)
}

function clearErrors(){
    $(`.form-control`).removeClass('is-invalid')
    $(`.msg`).text('')
}