(function () {


    var script = document.getElementById("domain-search-iframe-js");
    var script_src = script.src;

    var script_src_root = script_src.split('/');


    script_src_root.pop()

    script_src_root = script_src_root.join('/')+'/'




    var iframe = document.createElement("iframe");
    iframe.src = script_src_root+'index.php';
    iframe.id = 'domain-search-iframe';
    iframe.style.width = "100%";
    iframe.style.height = "100px%";
    iframe.onload = function(){
  //      iframe.contentWindow.document.body.style.margin = 5+'px';
    //    iframe.style.height = (iframe.contentWindow.document.body.clientHeight+10)+"px";
    }
    iframe.frameBorder = 0;
    iframe.allowtransparency = 1;
    document.getElementById("domain-search-iframe-js").parentNode.insertBefore(iframe,script.nextSibling );


})();



$(document).ready(function () {
    // Setup event listener
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    // Listen for event
    eventer(messageEvent, function (e) {

        // Check that message being passed is the documentHeight
        if ((typeof e.data === 'string') && (e.data.indexOf('documentHeight:') > -1)) {

            // Split string from identifier
            var height = e.data.split('documentHeight:')[1];

            $('#domain-search-iframe').css({'height': height + 'px'})
            // do stuff with the height

        }
    }, false);

});


