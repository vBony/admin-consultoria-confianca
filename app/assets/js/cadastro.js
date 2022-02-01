$(document).ready(function(){
    const baseUrl = $('#burl').val()

    $('.form-control').on('change', function(){
        $(this).removeClass('is-invalid')
        $(`#msg-${$(this).attr('name')}`).text('')
    })

    $('#regForm').submit(function(e){
        e.preventDefault()
        let data = $(this).serialize()
        
        $.ajax({
            url: baseUrl+'cadastro/cadastrar',
            type: "POST",             
            data: data, 
            dataType: 'json',                
            success: function(data){
                let errors = data.error

                $(`.form-control`).removeClass('is-invalid')
                $(`.msg`).text('')
                Object.entries(errors).forEach(([index, message]) => {
                    $(`.form-control[name='${index}'`).addClass('is-invalid')
                    $(`.msg#msg-${index}`).text(message)
                })
            }
        });
    })
})