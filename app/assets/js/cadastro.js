$(document).ready(function(){
    const baseUrl = $('#burl').val()

    $('#regForm').submit(function(e){
        e.preventDefault()
        let data = $(this).serialize()
        
        $.ajax({
            url: baseUrl+'cadastro/cadastrar',
            type: "POST",             
            data: data, 
            dataType: 'json',                
            success: function(data){
                alert('sended')
            }
        });
    })
})