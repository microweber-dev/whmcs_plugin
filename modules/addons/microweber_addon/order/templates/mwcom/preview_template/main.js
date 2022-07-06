var _selectDeviceTime = null;

function selectDevice(name) {
    clearTimeout(_selectDeviceTime)
    $(".device-holder iframe").css('opacity', 0)
    $(".device-holder")
        .attr('class', 'device-holder device-' + name)
        .find('.device')
        .css('max-height', innerHeight);
    _selectDeviceTime = setTimeout(function(){
        setScale();
        $(".device-holder iframe").css('opacity', 1)
    }, 700)
}

function selectDevice2(name, target) {
    var width = '100%';
    if(name === 'tablet') {
        // width = '768px';
        width = '800px';
    } else if(name === 'phone') {
        width = '480px';
    }
    document.querySelector('#template-demo-iframe').style.width = width;
    Array.from(document.querySelectorAll('#preview-toolbar .screens button.active')).forEach(function (node){
        node.classList.remove('active');
    })
    if(target) {
        target.classList.add('active');
    }
}

var _setScaleInit = null;

function setScale() {
    if(!_setScaleInit){
        var foo = document.querySelector('#foo');
        var bar = document.querySelector('#bar');
        _setScaleInit = fit(bar, foo, {
            hAlign: fit.CENTER,
            vAlign: fit.CENTER,
            cover: false,
            watch: true,
            apply: true
        });
    } else {
        _setScaleInit.trigger();
    }
}

$(document).ready(function () {
    //   setScale();
})
