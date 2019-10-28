{if $templatefile != 'login' AND $templatefile != 'password-reset-container'}
    </div><!-- /.main-content -->
{/if}
{if !$inShoppingCart && $secondarySidebar->hasChildren()}
    <div class="col-md-3 pull-md-left sidebar sidebar-secondary">
        {include file="$template/includes/sidebar.tpl" sidebar=$secondarySidebar}
    </div>
{/if}
<div class="clearfix"></div>
{if $templatefile != 'login' AND $templatefile != 'password-reset-container'}
    </div>
    </div>
    </section>
{/if}

<div class="modal system-modal fade" id="modalAjax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{$LANG.close}</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body panel-body">
                {$LANG.loading}
            </div>
            <div class="modal-footer panel-footer">
                <div class="pull-left loader">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    {$LANG.loading}
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {$LANG.close}
                </button>
                <button type="button" class="btn btn-primary modal-submit">
                    {$LANG.submit}
                </button>
            </div>
        </div>
    </div>
</div>

{include file="$template/includes/generate-password.tpl"}

{$footeroutput}
</div>

<footer class="p-t-100 p-b-60 not-whmcs-content">
    <div class="container">

        <div class="row">
            <div class="mx-auto col-xl-12">
                <div class="row">
                    <div class="mx-auto col col-xl-3">
                        <div class="logo">
                            {if $assetLogoPath}
                                <a href="{$WEB_ROOT}/index.php" class="logo"><img src="{$assetLogoPath}" alt="{$companyname}"></a>
                            {else}
                                <a href="{$WEB_ROOT}/index.php" class="logo logo-text">{$companyname}</a>
                            {/if}
                        </div>

                        <p>Микроуебър е система за създаване и
                            управление на сайтове с отводен код,
                            базирана на PHP / Laravel под MIT лиценз
                        </p>

                        <script async defer src="https://buttons.github.io/buttons.js"></script>
                        <span style="line-height: 23px; float: left; margin-right: 30px;">Следвай ни в Github</span> <a class="github-button" href="https://github.com/microweber/microweber" data-icon="octicon-star" data-show-count="true" aria-label="Star microweber/microweber on GitHub">Star</a>

                    </div>

                    <div class="mx-auto col col-xl-2">
                        <h3 class="small-title">За нас</h3>

                        <ul role="menu" id="" class="">
                            <li><a href="https://microweber.bg/"><span>Начало</span></a></li>
                            <li><a href="#"><span>За нас</span></a></li>
                            <li><a href="#"><span>Услуги</span></a></li>
                            <li><a href="https://microweber.bg/plans"><span>Хостинг</span></a></li>
                            <li><a href="https://microweber.bg/get-started"><span>Домейн</span></a></li>
                        </ul>
                    </div>

                    <div class="mx-auto col col-xl-2">
                        <h3 class="small-title">За платформата</h3>

                        <ul role="menu" id="" class="">
                            <li><a href="https://microweber.bg/templates"><span>Темплейти</span></a></li>
                            <li><a href="http://docs.microweber.com/" target="_blank"><span>Документация</span></a></li>
                            <li><a href="#"><span>Поддръжка</span></a></li>
                            <li><a href="#"><span>Блог</span></a></li>
                        </ul>
                    </div>

                    <div class="mx-auto col col-xl-2">
                        <h3 class="small-title">Връзки</h3>

                        <ul role="menu" id="" class="">
                            <li><a href="https://microweber.org/community"><span>Форум</span></a></li>
                            <li><a href="https://microweber.org/academy"><span>Академия</span></a></li>
                            <li><a href="#"><span>Предложения</span></a></li>
                        </ul>
                    </div>

                    <div class="mx-auto col col-xl-2">
                        <h3 class="small-title">Права и задължения</h3>

                        <ul role="menu" id="" class="">
                            <li><a href="#"><span>Условия за ползване</span></a></li>
                            <li><a href="#"><span>Конфиденциалност</span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center p-t-30">
                        <p>{lang key="copyrightFooterNotice" year=$date_year company=$companyname}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>

<button id="to-top" class="btn" style="display: block;"></button>

{if $templatefile != 'login' AND $templatefile != 'password-reset-container'}
    <script>
        $(document).ready(function () {
            $('.navigation-holder').addClass('not-transparent');
        })
    </script>
{/if}
<script src={$WEB_ROOT}/templates/{$template}/assets/js/main.js?v={$versionHash}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
{*<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>*}
</body>
</html>



















