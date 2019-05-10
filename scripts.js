$(document).ready(function () {
    resize_iframe_to_parent()
});

window.onresize = function (event) {
    //resize_iframe_to_parent()
}

prev_height = null

function resize_iframe_to_parent() {
    var body = document.getElementById('frame-body')
    if (body) {

        var documentHeight = Math.max(body.scrollHeight, document.documentElement.scrollHeight) ;
        if (documentHeight != prev_height) {

            top.postMessage('documentHeight:0', "*");
            message = 'documentHeight:' + Math.max(body.scrollHeight, document.documentElement.scrollHeight);

            console.log(message)
            top.postMessage(message, "*");
            prev_height = documentHeight;
        }
    }
}