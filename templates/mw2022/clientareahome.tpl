<div class="mw-whm clientareahome">

   <div class="row  client-area-row-box ">
       <div class="col-lg-4 client-area-box-1" style="    margin-top: 100px;">
           <h1 style="font-size: 48px; font-weight: 700; line-height: 1.2;">Building a Website Has Never Been Easier</h1>
           <p style="margin-top: 20px;">Create the perfect site with powerful drag and drop tools</p>


           <a href="{$WEB_ROOT}/index.php?m=microweber_addon&function=order_iframe&style=default&from_step=2&target=_top" class="whmc-kbtn" style="margin-right: 10px">Create a Website</a>
           <a href="{$WEB_ROOT}/submitticket.php?step=2&deptid=2" class="whmc-kbtn-2" >Contact Sales</a>
       </div>

       <div class="col-lg-8 client-area-box-2">

           <img width="100%" src="{$WEB_ROOT}/templates/mw2022/img/client-panel-banner-2.jpg" alt="">

       </div>
   </div>
    <div class="tiles clearfix">


        <div class="row client-area-row">
            <div class="client-area-boxes col-lg-3 col-md-6 tile" onclick="window.location='clientarea.php?action=services'">
                <a href="clientarea.php?action=services">
                    <div class="icon" style="font-size: 20px;">
                        <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                            <polygon class="svg-icon-prime svg-icon-stroke" points="59,47.4 59,36.2 32,48 5,36.2 5,47.4 32,63 "></polygon>
                            <polygon class="svg-icon-prime-l svg-icon-stroke" points="32,44.3 11.2,32.3 5,35.9 32,51.5 59,35.9 52.8,32.3 "></polygon>
                            <line class="svg-icon-outline-s" x1="32" y1="32.7" x2="32" y2="43.2"></line>
                            <polyline class="svg-icon-outline-s" points="5.5,16.9 32,32.2 58.5,16.9 "></polyline>
                            <polygon class="svg-icon-outline-s" points="5,16.6 5,28.1 32,43.7 59,28.1 59,16.6 32,1 "></polygon>
                            <line class="svg-icon-outline-s" x1="37" y1="34.8" x2="44" y2="30.7"></line>
                        </svg>
                    </div>
                    <div class="stat">{$clientsstats.productsnumactive}</div>
                    <div class="title">Websites</div>
                    <div class="highlight bg-color-blue"></div>
                </a>
            </div>
            {if $registerdomainenabled || $transferdomainenabled}
                <div class="client-area-boxes col-lg-3 col-md-6 tile" onclick="window.location='clientarea.php?action=domains'">
                    <a href="clientarea.php?action=domains">
                        <div class="icon" style="font-size: 20px;">
                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" x="0px" y="0px" width="64px" height="64px">
                                <ellipse class="svg-icon-prime svg-icon-stroke" cx="31.45" cy="32.38" rx="7.48" ry="7.48"></ellipse>
                                <path class="svg-icon-outline-s" d="M54.14,54.29A30.57,30.57,0,0,1,32.2,63a30.34,30.34,0,0,1-21.85-8.71A31.18,31.18,0,0,1,1,32.38a31.18,31.18,0,0,1,9.35-21.91A31.18,31.18,0,0,1,32.2,1a31.37,31.37,0,0,1,21.94,9.47A30.67,30.67,0,0,1,63,32.38,30.67,30.67,0,0,1,54.14,54.29Z"></path>
                                <path class="svg-icon-outline-s" d="M1,32.89a15.35,15.35,0,0,1,.09-2"></path>
                                <path class="svg-icon-outline-s dashed-21" d="M5.79,23.9a24.23,24.23,0,0,1,4.57-3.36C16,17.3,23.7,15.3,32.24,15.3s16.28,2,21.88,5.24a21.48,21.48,0,0,1,6.51,5.51"></path>
                                <path class="svg-icon-outline-s" d="M62.7,29.74a8,8,0,0,1,.2,2"></path>
                                <path class="svg-icon-outline-s" d="M63,31.08C63,36,59.72,41,54.12,44.23a45,45,0,0,1-22,5.65,44.17,44.17,0,0,1-21.78-5.65C4.76,41,1,36.52,1,31.59"></path>
                                <path class="svg-icon-outline-s" d="M32.87,63a16.42,16.42,0,0,1-2-.11"></path>
                                <path class="svg-icon-outline-s dashed-22" d="M24.38,59.6a23.31,23.31,0,0,1-4.11-5.32C17,48.67,15,40.93,15,32.38s2-16.29,5.23-21.89a20.92,20.92,0,0,1,6.23-7l1-.65"></path>
                                <path class="svg-icon-outline-s" d="M30.89,1.3a7.81,7.81,0,0,1,2-.27"></path>
                                <path class="svg-icon-outline-s" d="M31.41,1c4.93,0,9.44,3.86,12.67,9.46a44.62,44.62,0,0,1,5.81,21.89,44.69,44.69,0,0,1-5.81,21.9C40.85,59.88,36.34,63,31.41,63"></path>
                            </svg>
                        </div>
                        <div class="stat">{$clientsstats.numactivedomains}</div>
                        <div class="title">{$LANG.navdomains}</div>
                        <div class="highlight bg-color-green"></div>
                    </a>
                </div>
            {elseif $condlinks.affiliates && $clientsstats.isAffiliate}
                <div class="client-area-boxes col-lg-3 col-md-6 tile" onclick="window.location='affiliates.php'">
                    <a href="affiliates.php">
                        <div class="icon" style="font-size: 20px;"><i class="fa fa-shopping-cart" ></i></div>
                        <div class="stat">{$clientsstats.numaffiliatesignups}</div>
                        <div class="title">{$LANG.affiliatessignups}</div>
                        <div class="highlight bg-color-green"></div>
                    </a>
                </div>
            {else}
                <div class="client-area-boxes col-lg-3 col-md-6 tile" onclick="window.location='clientarea.php?action=quotes'">
                    <a href="clientarea.php?action=quotes">
                        <div class="icon" style="font-size: 20px;"><i class="fa fa-file-text-o"></i></div>
                        <div class="stat">{$clientsstats.numquotes}</div>
                        <div class="title">{$LANG.quotes}</div>
                        <div class="highlight bg-color-green"></div>
                    </a>
                </div>
            {/if}
            <div class="client-area-boxes col-lg-3 col-md-6 tile" onclick="window.location='supporttickets.php'">
                <a href="supporttickets.php">
                    <div class="icon" style="font-size: 20px;">
                        <svg class="svg-icon" width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="svg-icon-outline-s" d="M13.1148 27.5496C13.1148 25.922 13.702 24.0903 14.7472 22.4575C15.7924 20.8247 17.21 19.5247 18.6881 18.8432L38.2908 9.80629C39.7688 9.12487 41.1864 9.11793 42.2316 9.787C43.2769 10.4561 43.8641 11.7464 43.8641 13.374V26.4946C43.8641 28.1222 43.2769 29.9538 42.2316 31.5866C41.1864 33.2193 39.7688 34.5195 38.2908 35.2009L30.3321 38.8698L21.9913 49.1974C20.8459 50.616 19.2646 50.4425 19.2646 48.8986V43.972L18.6881 44.2378C17.21 44.9192 15.7924 44.9262 14.7472 44.2571C13.702 43.5881 13.1148 42.2977 13.1148 40.6701V27.5496Z"></path>
                            <path class="svg-icon-outline-s dashed-40" d="M32.1611 12.5133V6.64023C32.1611 5.01259 31.5739 3.72231 30.5286 3.05323C29.4834 2.38416 28.0658 2.3911 26.5878 3.07253L6.98511 12.1095C5.50697 12.7909 4.08938 14.091 3.04419 15.7237C1.99899 17.3565 1.4118 19.1882 1.4118 20.8158V33.9363C1.4118 35.5639 1.99899 36.8543 3.04419 37.5233C4.08938 38.1924 5.50697 38.1854 6.98511 37.504L7.56165 37.2382V42.1648C7.56165 43.7088 9.14292 43.8822 10.2883 42.4636L12.8925 39.6738"></path>
                            <path class="svg-icon-prime-l svg-icon-stroke" d="M26.3246 31.1608C25.2825 32.7888 24.697 34.6151 24.697 36.238V49.3202C24.697 50.9431 25.2825 52.2296 26.3246 52.8967C27.3668 53.5638 29.1827 54.5099 30.254 55.701C30.5095 55.985 30.5633 56.1603 30.8064 56.4592C31.1581 56.8916 31.0031 56.8673 32.4671 57.7974C33.9311 58.7275 38.6214 61.7522 38.6214 61.7522L40.8473 47.8096L56.5439 39.8214C58.0177 39.142 59.4312 37.8457 60.4733 36.2177C61.5155 34.5897 62.5113 32.7798 62.5113 31.1569L62.3705 23.5844C61.8264 21.464 56.8214 18.0753 54.5267 17.6004C53.6723 17.4235 51.911 17.6004 49.7994 18.5466L30.254 27.5571C28.7802 28.2365 27.3668 29.5328 26.3246 31.1608Z"></path>
                            <path class="svg-icon-prime svg-icon-stroke" d="M31.9288 39.321C31.9288 37.6981 32.5142 35.8718 33.5564 34.2438C34.5985 32.6158 36.012 31.3195 37.4858 30.6401L57.0311 21.6296C58.5049 20.9501 59.9184 20.9432 60.9605 21.6103C62.0027 22.2774 62.5881 23.564 62.5881 25.1868V38.269C62.5881 39.8919 62.0027 41.7182 60.9605 43.3462C59.9184 44.9742 58.5049 46.2705 57.0311 46.9499L49.0957 50.6082L40.7794 60.9055C39.6373 62.3199 38.0606 62.1471 38.0606 60.6076V55.6954L37.4858 55.9605C36.012 56.6399 34.5985 56.6468 33.5564 55.9797C32.5142 55.3126 31.9288 54.0261 31.9288 52.4032V39.321Z"></path>
                            <path class="svg-icon-outline-i" d="M37.7524 37.3866L56.6174 28.6221"></path>
                            <path class="svg-icon-outline-i" d="M37.7524 43.6824L47.7968 39.0159"></path>
                            <path class="svg-icon-outline-i" d="M37.7524 50.1659L52.8171 43.167"></path>
                        </svg>
                    </div>
                    <div class="stat">{$clientsstats.numactivetickets}</div>
                    <div class="title">{$LANG.navtickets}</div>
                    <div class="highlight bg-color-red"></div>
                </a>
            </div>
            <div class="client-area-boxes col-lg-3 col-md-6 tile" onclick="window.location='clientarea.php?action=invoices'">
                <a href="clientarea.php?action=invoices">
                    <div class="icon" style="font-size: 20px;">
                        <svg class="svg-icon " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63.98 63.53" x="0px" y="0px" width="64px" height="64px">
                            <line class="svg-icon-outline-s" x1="18.37" y1="58.99" x2="15.96" y2="51.22"></line>
                            <line class="svg-icon-outline-s" x1="18.37" y1="58.99" x2="10.23" y2="60.22"></line>
                            <path class="svg-icon-outline-s" d="M17.73,58.41A30.6,30.6,0,0,1,1,31.06,29.85,29.85,0,0,1,31.19,1a33.37,33.37,0,0,1,8.24.81"></path>
                            <path class="svg-icon-outline-s" d="M32.26,62.53a28,28,0,0,1-4-.34"></path>
                            <path class="svg-icon-outline-s" d="M27.54,62.07c-1.39-.24-2.74-.55-3.91-.86"></path>
                            <path class="svg-icon-outline-s" d="M45.68,4.64a31.4,31.4,0,0,1,3.45,2"></path>
                            <path class="svg-icon-outline-s dashed-15" d="M54.08,10.73A30.08,30.08,0,0,1,63,30.8"></path>
                            <path class="svg-icon-outline-s" d="M62.92,34a28.6,28.6,0,0,1-.56,4"></path>
                            <line class="svg-icon-outline-s" x1="45.18" y1="4.27" x2="47.98" y2="11.87"></line>
                            <line class="svg-icon-outline-s" x1="53.6" y1="3.31" x2="45.18" y2="4.27"></line>
                            <polygon class="svg-icon-prime-l" points="27.09 10.17 25.23 11.6 43.75 32.24 52.69 52.88 54.53 52.31 54.53 27.24 27.09 10.17"></polygon>
                            <polygon class="svg-icon-prime" points="25.23 11.6 25.23 23.9 42.37 33.9 42.37 46.67 52.51 52.88 52.51 27.81 25.23 11.6"></polygon>
                            <polygon class="svg-icon-outline-s" points="42 59.05 14 42.88 14 18 42 34.17 42 59.05"></polygon>
                            <line class="svg-icon-outline-s" x1="14.3" y1="27.01" x2="42" y2="42.76"></line>s
                        </svg>
                    </div>
                    <div class="stat">{$clientsstats.numunpaidinvoices}</div>
                    <div class="title">{$LANG.navinvoices}</div>
                    <div class="highlight bg-color-gold"></div>
                </a>
            </div>
        </div>
    </div>


</div>
{literal}
    <style>
        div[menuitemname="Active Products/Services"],
        div[menuitemname="Recent News"] {
            display: none;
        }
    </style>

{/literal}

{literal}

    <script src="modules/addons/microweber_addon/order/embed.js?style=whmcs-order-process-style-2022&from_step=2&quick_search=1&target=_top" id="domain-search-iframe-js"></script>

{/literal}

