                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <div class="wrapper">
                    <div class="row">
                        <div class="col-xs-12">
                            {if $logo}
                                <a href="{$WEB_ROOT}/" class="logo"><img src="{$logo}" alt="{$companyname}" class="img-responsive"></a>
                            {else}
                                <a href="{$WEB_ROOT}/" class="logo">{$companyname}</a>
                            {/if}
                        </div>
                    </div>

                    <section class="copy">
                        <div class="row">
                            <div class="col-xs-4">

                                 <a href="https://microweber.com/" class="link" target="_blank">Go to Microweber.com</a>

                            </div>
                            <div class="col-xs-8">
                                <div class="copy-follow">
                                    Follow us:
                                    <a href="https://twitter.com/microweber" target="_blank">Twitter</a>
                                    <a href="https://facebook.com/microweber" target="_blank">Facebook</a>
                                    <a href="https://linkedin.com/company/microweber" target="_blank">LinkedIn</a>
                                    <a href="https://youtube.com/microweber" target="_blank">YouTube</a>
                                    <a href="https://pinterest.com/Microweber" target="_blank">Pinterest</a>
                                    <a href="https://plus.google.com/+Microweber" target="_blank">Google Plus</a>
                                    <br>

                                </div>
                            </div>
                        </div>
                        <div class="row"> <br><div class="col-xs-12 text-center">

                            Copyright &copy; {$date_year} {$companyname}. All Rights Reserved.   Open Source Website Builder &amp; CMS under MIT License
                            </div>
                        </div>
                    </section>
                </div>
            </footer>

            <div class="modal system-modal fade" id="modalAjax" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content panel panel-primary">
                        <div class="modal-header panel-heading">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Title</h4>
                        </div>
                        <div class="modal-body panel-body">
                            Loading...
                        </div>
                        <div class="modal-footer panel-footer">
                            <div class="pull-left loader">
                                <i class="fa fa-circle-o-notch fa-spin"></i> Loading...
                            </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-primary modal-submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{literal}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-1065179-29', 'auto');


        ga('require', 'displayfeatures');
        ga('require', 'linkid', 'linkid.js');

        ga('send', 'pageview');

    </script>
    <!-- Piwik -->
    <script type="text/javascript">
        var _paq = _paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="//piwik.microweber.com/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', '1']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <!-- End Piwik Code -->
{/literal}
        {$footeroutput}

    </body>
</html>
