$(document).ready(function() {
    $('.js-domain-check-is-ready').each(function(k,item){

        var URL = "index.php?m=microweber_addon&ajax=1&function=service_check&service_id=" + encodeURI($(item).data('service-id'));

        lazyLoadAjaxManager.addRequest(URL); 

    });
});

var lazyLoadAjaxManager = (function() {

    const MAX_PARALLEL_CALL = 1;
    var queue = []; //to store the URL
    var activeCall = 0;

    function queueRequest(url) {
        queue.push(url)
        checkQueue()
    }

    function onPromiseCompleteOrFailure() {
        activeCall--
        checkQueue()
    }

    function checkQueue() {
        if (queue.length && activeCall <= MAX_PARALLEL_CALL) {
            let url = queue.shift()
            if (!url) {
                return
            }

            activeCall++

            fetch(url)
                .then(res => res.json())
                .then(response => {
                    onPromiseCompleteOrFailure()
                    //TODO Write your custom logic here
                    console.log('Success:', JSON.stringify(response))
                })
                .catch(error => {
                    onPromiseCompleteOrFailure()
                    console.error('Error:', error)
                })
        }
    }

    return {
        addRequest: queueRequest,
    }
})();
