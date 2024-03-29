                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <div class="wrapper">


                    <section class="copy pt-5">
                        <div class="row pt-5" style="justify-content: center; align-items: center;">

                            <div class="col-md-4">

                                {if $logo}
                                    <a href="{$WEB_ROOT}/" class="logo"><img src="templates/mw2022/img/logo.svg" alt="{$companyname}" class="img-responsive"></a>
                                {else}
                                    <a href="{$WEB_ROOT}/" class="logo">{$companyname}</a>
                                {/if}
                            </div>

                            <div class="col-md-4 text-center" style="margin-top: 20px;">

                                Copyright &copy; {$date_year} {$companyname}. Open Source Website Builder &amp; CMS under MIT License

                            </div>


                            <div class="col-md-4" style="margin-top: 20px;">
                                <div class="copy-follow">
                                    <a href="https://twitter.com/microweber" target="_blank">Twitter</a>
                                    <a href="https://facebook.com/microweber" target="_blank">Facebook</a>
                                    <a href="https://linkedin.com/company/microweber" target="_blank">LinkedIn</a>
                                    <a href="https://youtube.com/microweber" target="_blank">YouTube</a>
                                    {*                                    <a href="https://pinterest.com/Microweber" target="_blank">Pinterest</a>*}
                                    {*                                    <a href="https://plus.google.com/+Microweber" target="_blank">Google Plus</a>*}
                                    <br>


                                </div>
                            </div>

                            <div class="col-md-12 mx-auto text-center mt-4">
                                {if $languagechangeenabled && count($locales) > 1 || $currencies}
                                    <li class="list-inline-item" style="list-style: none;">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#modalChooseLanguage">
                                            <div class="d-inline-block align-middle">
                                                <div class="iti-flag {if $activeLocale.countryCode === 'GB'}us{else}{$activeLocale.countryCode|lower}{/if}"></div>
                                            </div>
                                            {$activeLocale.localisedName}
                                            /
                                            {$activeCurrency.prefix}
                                            {$activeCurrency.code}
                                        </button>
                                    </li>
                                {/if}
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
                            <button type="button" class="whmc-kbtn-2" data-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="whmc-kbtnmodal-submit">
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

        var pageWrapperSize = function () {
            var header = document.querySelector('#container > header');
            var footer = document.querySelector('#container > footer');
            var pageWrapper = document.querySelector('#container > .page-wrapper');
            if(header && footer && pageWrapper) {
                pageWrapper.style.minHeight = 'calc(100vh - ' + header.offsetHeight + 'px - ' + footer.offsetHeight + 'px)';
            }
        };

        addEventListener('load', pageWrapperSize);
        addEventListener('resize', pageWrapperSize);

    </script>

{/literal}
        {$footeroutput}
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    </body>
</html>
