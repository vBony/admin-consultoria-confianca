$(document).ready(function(){
    $('#submitBtn').click(()=>{
        $.getJSON("https://ipfind.co/?ip=45.4.41.181&auth=200cb1b4-9c3c-4c45-8922-7485f6d8ddaf", function(result){
            console.log('res', result);
        });
    })
})
