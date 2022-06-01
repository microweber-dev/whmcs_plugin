<div class="mw-whm clientareahome">
    <div class="tiles clearfix">
        <div class="row">
            <div class="col-sm-3 col-xs-6 tile" onclick="window.location='clientarea.php?action=services'">
                <a href="clientarea.php?action=services">
                    <div class="icon" style="font-size: 20px;"><i class="fa fa-cube"></i></div>
                    <div class="stat">{$clientsstats.productsnumactive}</div>
                    <div class="title">Websites</div>
                    <div class="highlight bg-color-blue"></div>
                </a>
            </div>
            {if $registerdomainenabled || $transferdomainenabled}
                <div class="col-sm-3 col-xs-6 tile" onclick="window.location='clientarea.php?action=domains'">
                    <a href="clientarea.php?action=domains">
                        <div class="icon" style="font-size: 20px;"><i class="fa fa-globe"></i></div>
                        <div class="stat">{$clientsstats.numactivedomains}</div>
                        <div class="title">{$LANG.navdomains}</div>
                        <div class="highlight bg-color-green"></div>
                    </a>
                </div>
            {elseif $condlinks.affiliates && $clientsstats.isAffiliate}
                <div class="col-sm-3 col-xs-6 tile" onclick="window.location='affiliates.php'">
                    <a href="affiliates.php">
                        <div class="icon" style="font-size: 20px;"><i class="fa fa-shopping-cart"></i></div>
                        <div class="stat">{$clientsstats.numaffiliatesignups}</div>
                        <div class="title">{$LANG.affiliatessignups}</div>
                        <div class="highlight bg-color-green"></div>
                    </a>
                </div>
            {else}
                <div class="col-sm-3 col-xs-6 tile" onclick="window.location='clientarea.php?action=quotes'">
                    <a href="clientarea.php?action=quotes">
                        <div class="icon" style="font-size: 20px;"><i class="fa fa-file-text-o"></i></div>
                        <div class="stat">{$clientsstats.numquotes}</div>
                        <div class="title">{$LANG.quotes}</div>
                        <div class="highlight bg-color-green"></div>
                    </a>
                </div>
            {/if}
            <div class="col-sm-3 col-xs-6 tile" onclick="window.location='supporttickets.php'">
                <a href="supporttickets.php">
                    <div class="icon" style="font-size: 20px;"><i class="fa fa-comments"></i></div>
                    <div class="stat">{$clientsstats.numactivetickets}</div>
                    <div class="title">{$LANG.navtickets}</div>
                    <div class="highlight bg-color-red"></div>
                </a>
            </div>
            <div class="col-sm-3 col-xs-6 tile" onclick="window.location='clientarea.php?action=invoices'">
                <a href="clientarea.php?action=invoices">
                    <div class="icon" style="font-size: 20px;"><i class="fa fa-credit-card"></i></div>
                    <div class="stat">{$clientsstats.numunpaidinvoices}</div>
                    <div class="title">{$LANG.navinvoices}</div>
                    <div class="highlight bg-color-gold"></div>
                </a>
            </div>
        </div>
    </div>


</div>

<style>
    div[menuitemname="Active Products/Services"],
    div[menuitemname="Recent News"] {
        display: none;
    }
</style>



{literal}

    <script src="modules/addons/microweber_addon/order/embed.js?style=default&target=_top" id="domain-search-iframe-js"></script>

{/literal}

