$(document).ready(function(){
    let path = $('#path').val()

    $(`.nav-link[data-id='${path}']`).addClass('active')
})