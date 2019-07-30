$(document).ready(function () {
    $('.section-61').css('height', 'auto');
    resize_iframe_to_parent();
    var body = document.body;
    var html = document.documentElement;
    $('html,body').css('overflow', 'hidden')

});

window.onresize = function (event) {
    //resize_iframe_to_parent()
}

var prev_height = null,
    _ifrChecker = null,
    message;

function resize_iframe_to_parent() {
    var body = document.getElementById('frame-body');
    if (body) {
        if (!_ifrChecker) {
            _ifrChecker = document.createElement('div');
            document.body.appendChild(_ifrChecker);
        }
        var otop = _ifrChecker.offsetTop;
        if(otop !== prev_height){
            message = 'documentHeight:' + otop;
            top.postMessage(message, "*");
            message = 'frameLocation:' + location.href;
            top.postMessage(message, "*");
            prev_height = otop;
        }
    }
}

setInterval(function(){
    resize_iframe_to_parent()
}, 333)


function scroll_iframe_to_parent() {

    var message = 'scrollCommand:' + 'top';
    top.postMessage(message, "*");

}

