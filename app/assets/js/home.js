$(document).ready(function(){
    const baseUrl = $('#burl').val()
    $('.loading').fadeOut('fast')

    $('#logout-btn').on('click', function(){
        loading()
        $.ajax({
            url: baseUrl+'login/logout',
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
                loadingComplete()
            }
        });
    })
})

function loading(){
    $('.loading').fadeIn('fast')
}

function loadingComplete(){
    $('.loading').fadeOut('fast')
}