            <script src="<?php echo $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/scripts.js"></script>

            <!-- Plugins -->
            <script src="<?php echo $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/assets/plugins/bootstrap-3.3.7/js/bootstrap.min.js"></script>
            <script src="https://rawgithub.com/soulwire/fit.js/master/fit.js"></script>
            <script src="<?php echo $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.com/preview_template/main.js"></script>

            <script>

                var submitForPreview = function (form) {
                    form.submit();

                    /*var path = location.pathname;
                     if(path.indexOf('/templates') !== -1){
                     path = path.split('/templates')[0] +  '/templates/' + form.querySelector('[name="template_id"]').value;
                     history.pushState(null, null, path);
                     }*/


                }


                $(document).ready(function () {
                    // if(typeof(iframe) != 'undefined'){
                    // iframe.scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
                    // }

                });

            </script>
        </div>
    </body>
</html>