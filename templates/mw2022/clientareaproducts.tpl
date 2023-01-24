<div class="panel panel-default pt-5 mt-5 mw-whm clientareaproducts">

    <div class="header-lined text-center">
        <h1 style="font-size: 36px; font-weight: 700;">{$LANG.MWmyWebsite}</h1>
        <br/>
        <a href="index.php?m=microweber_addon&function=order_iframe&style=whmcs-order-process-style-2022&target=_top" class="whmc-kbtn-2 m-b-10"><i class="fa fa-plus"></i> &nbsp; {$LANG.MWcreateNewWebsite}</a>
    </div>


{*    {include file="$template/includes/tablelist.tpl" tableName="ServicesList" filterColumn="4" startOrderCol="[1, 'desc'], [1, 'asc']"}*}
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var table = jQuery('#tableServicesList').removeClass('hidden').DataTable({
                dom:
                    "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 pagination-clientareaproducts'p>>",
            });
            {if $orderby == 'product'}
            table.order([2, 'desc']);
            {elseif $orderby == 'amount' || $orderby == 'billingcycle'}
            table.order(1, '{$sort}');
            {elseif $orderby == 'nextduedate'}
            table.order(2, '{$sort}');
            {elseif $orderby == 'domainstatus'}
            table.order(3, '{$sort}');
            {/if}
            table.draw();
            jQuery('#tableLoading').addClass('hidden');
            $(".more-table-button").on('click', function (){
                $(this).parent().toggleClass('menu-active')
            })
        });
    </script>
    {literal}
        <style>
            #tableServicesList-table-container table th:last-child,
            #tableServicesList-table-container table td:last-child{
                position: sticky;
                right: 0;
                background-color: white;
                text-align: right;
                padding-right: 0;
                padding-left: 12px;
            }
            #tableServicesList-table-container table th:first-child,
            #tableServicesList-table-container table td:first-child{
                position: sticky;
                left: 0;
                background-color: white;
                text-align: left;
                z-index: 1;
                padding-right: 12px;
                padding-left: 0;
            }

            #tableServicesList-table-container .tableServicesListWrap{
                max-width: 100%;
                overflow: auto;
                margin-bottom: 20px;

                border-bottom: 1px solid #ccc;
            }
            .more-table-button{
                background-image: url("data:image/svg+xml,%3Csvg  version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 210 210' style='enable-background:new 0 0 210 210;' xml:space='preserve'%3E%3Cpath id='XMLID_104_' d='M115,0H95c-8.284,0-15,6.716-15,15v20c0,8.284,6.716,15,15,15h20c8.284,0,15-6.716,15-15V15 C130,6.716,123.284,0,115,0z'/%3E%3Cpath  d='M115,80H95c-8.284,0-15,6.716-15,15v20c0,8.284,6.716,15,15,15h20c8.284,0,15-6.716,15-15V95 C130,86.716,123.284,80,115,80z'/%3E%3Cpath id='XMLID_106_' d='M115,160H95c-8.284,0-15,6.716-15,15v20c0,8.284,6.716,15,15,15h20c8.284,0,15-6.716,15-15v-20 C130,166.716,123.284,160,115,160z'/%3E%3C/svg%3E%0A");
                display: inline-block;
                vertical-align: middle;
                width: 30px;
                height: 30px;
                background-position: center;
                background-size: auto 20px ;
                background-repeat: no-repeat;
                cursor: pointer;
                opacity: .7;
            }
            .more-table-menu {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                flex-wrap: wrap;
                width: 100%;
            }
            .responsive-edit-button
            .more-table-menu a{
                width: 100%;
                margin: 5px 0;
            }
            /*.more-table-menu{
                display: none;
                position: absolute;
            }*/
            .menu-active {
                z-index: 2;
            }
            .menu-active .more-table-menu{
                display: block;
            }

            #tableServicesList-table-container table th,
            #tableServicesList-table-container table td{
                padding: 12px;
            }
            .mw-whm table.dataTable thead th:after{

                right: 0px;

            }
            #tableServicesList-table-container table thead th{
                white-space: nowrap;
                font-size: 12px;
                text-transform: uppercase;

            }
            .product-name{
                font-style: italic;
                color: #00aced;
            }

            @media (max-width: 700px) {
                #tableServicesList-table-container table tr > *:nth-child(4){
                    display: none !important;
                }
            }

            @media (max-width: 500px) {
                #tableServicesList-table-container table tr > *:nth-child(2){
                    display: none !important;
                }
            }

            @media (max-width: 900px) {
                #tableServicesList-table-container table,
                #tableServicesList-table-container table tbody{
                    width: 100% !important;
                }

                #tableServicesList-table-container table tr > *:nth-child(3){
                    display: none !important;
                }

                #tableServicesList-table-container table thead{
                    display: none !important;
                }
                #tableServicesList-table-container table tbody tr{
                    border-bottom: 1px solid #ccc;
                    width: 100%;
                    padding: 20px;
                }
                #tableServicesList-table-container table tbody tr:nth-child(2n+1) {

                }
            }
        </style>
    {/literal}
    <div class="table-container clearfix" id="tableServicesList-table-container">
        <table id="tableServicesList" class="table table-list hidden" >
            <thead>
            <tr>
                <th>{$LANG.orderproduct}</th>

                <th>{$LANG.clientareaaddonpricing}</th>
{*                <th>{$LANG.clientareahostingnextduedate}</th>*}
                <th>{$LANG.MWregisterDate}</th>
                <th>{$LANG.clientareastatus}</th>
                <th class="responsive-edit-button" >{$LANG.MWactions}</th>
            </tr>
            </thead>
            <tbody>

            {foreach key=num item=service from=$services}
                {*<tr onclick="clickableSafeRedirect(event, 'clientarea.php?action=productdetails&amp;id={$service.id}', false)">*}
                <tr class="product-row-status-{$service.status|strtolower}">
                    <td>
                        {if $service.domain}<br/><a href="http://{$service.domain}" target="_blank" class="domain-name">{$service.domain}</a><br>{/if}
                        <span class="product-name">{$service.product}</span>


                    </td>

                    <td class="text-center" data-order="{$service.amountnum}"><span class="product-amount">{$service.amount}</span><br/><span class="product-plan">{$service.billingcycle}</span></td>
                    <td class="text-center"><span class="hidden">{$service.normalisedRegDate}</span>{$service.normalisedRegDate}</td>
{*                    <td class="text-center"><span class="hidden">{$service.normalisedNextDueDate}</span>{$service.nextduedate}</td>*}
                    <td class="text-center status-column"><span class="status mw-whm-product-status status-{$service.status|strtolower}"><span>{$service.statustext}</span></span></td>
                    <td class="responsive-edit-button" style="max-width: 250px; text-align: right">
                        {*<span class="more-table-button"></span>*}


                        <div class="more-table-menu">
                            {if $service.group == 'Templates'}
                                <a href="go_to_product.php?id={$service.id}&template=true" target="_blank" class="cbtn cbtn-small">{$LANG.MWviewTemplate}</a>
                            {elseif $service.group == 'License'}
                                <a href="clientarea.php?action=productdetails&amp;id={$service.id}" class="whmc-kbtn-2-small"  data-toggle="tooltip" title="{$LANG.manageproduct}">{$LANG.MWmanage}</i></a>
                            {else}

                                <a href="upgrade.php?type=package&id={$service.id}" class="whmc-kbtn-2-small"  data-toggle="tooltip" title="Change plan">{$LANG.MWplan}</a>

                                <a href="clientarea.php?action=productdetails&amp;id={$service.id}" class="whmc-kbtn-2-small"  data-toggle="tooltip" title="{$LANG.manageproduct}">{$LANG.MWmanage}</i></a>

                                <a href="{get_website_redirect_url($service.domain, $service.id)}" target="_blank" data-toggle="tooltip" title="Edit this website" class="whmc-kbtn-small">{$LANG.MWedit}</a>

                            {/if}
                        </div>



                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        <div class="text-center" id="tableLoading">
            <p><i class="fa fa-spinner fa-spin"></i> {$LANG.loading}</p>
        </div>
    </div>

</div>

{literal}
    <script>

        $( document ).ready(function() {
            $('.form-control.input-sm').attr('placeholder', 'Search...');
            $('#tableServicesList').wrap('<div class="tableServicesListWrap"></div>')
        });

    </script>
{/literal}
