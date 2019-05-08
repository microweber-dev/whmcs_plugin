$(document).ready(function () {
    resize_iframe_to_parent()
});

window.onresize = function (event) {
   // resize_iframe_to_parent()
}

prev_height = null

function resize_iframe_to_parent() {
    if ($('#frame-body').length > 0) {
        var documentHeight = document.getElementById('frame-body').scrollHeight;
        if (documentHeight != prev_height) {
            prev_height = documentHeight;
            message = 'documentHeight:' + documentHeight;
            parent.postMessage(message, "*");
        }
    }
}