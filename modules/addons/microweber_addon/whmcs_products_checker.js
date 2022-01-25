$(document).ready(function() {
    $('.js-domain-check-is-ready').each(function(k,item){

        var URL = "index.php?m=microweber_addon&ajax=1&function=service_check&service_id=" + encodeURI($(item).data('service-id'));

        $.ajax({
            contentType: 'application/json',
            dataType: 'json',
            url: URL,
            cache: false,
            type: "POST",
            success: function (response) {


            }
        });
    });
});