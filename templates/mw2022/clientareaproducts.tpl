<div class="mw-whm clientareaproducts">

    <div class="header-lined text-center">
        <h1 style="font-size: 36px; font-weight: 700;">My Website</h1>
        <br/>
        <a href="index.php?m=microweber_addon&function=order_iframe&style=whmcs-order-process-style-2022&target=_top" class="whmc-kbtn-2 m-b-10"><i class="fa fa-plus"></i> &nbsp; Create New Website</a>
    </div>


    {include file="$template/includes/tablelist.tpl" tableName="ServicesList" filterColumn="3"}
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var table = jQuery('#tableServicesList').removeClass('hidden').DataTable();
            {if $orderby == 'product'}
            table.order([0, '{$sort}']);
            {elseif $orderby == 'amount' || $orderby == 'billingcycle'}
            table.order(1, '{$sort}');
            {elseif $orderby == 'nextduedate'}
            table.order(2, '{$sort}');
            {elseif $orderby == 'domainstatus'}
            table.order(3, '{$sort}');
            {/if}
            table.draw();
            jQuery('#tableLoading').addClass('hidden');
        });
    </script>
    <div class="table-container table-responsive clearfix">
        <table id="tableServicesList" class="table table-list hidden" style="width: 100%;">
            <thead>
            <tr>
                <th style="width: 20%!important">{$LANG.orderproduct}</th>
                <th style="width: 20%!important">{$LANG.clientareaaddonpricing}</th>
                <th style="width: 20%!important">{$LANG.clientareahostingnextduedate}</th>
                <th style="width: 20%!important">{$LANG.clientareastatus}</th>
                <th class="responsive-edit-button" style="display: none;"></th>
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
                    <td class="text-center"><span class="hidden">{$service.normalisedNextDueDate}</span>{$service.nextduedate}</td>
                    <td class="text-center status-column"><span class="label status status-{$service.status|strtolower}"><span>{$service.statustext}</span></span></td>
                    <td class="responsive-edit-button" style="max-width: 250px; text-align: right">
                        {if $service.group == 'Templates'}
                            <a href="go_to_product.php?id={$service.id}&template=true" target="_blank" class="cbtn cbtn-small">View template</a>
                        {else}


                            <a href="upgrade.php?type=package&id={$service.id}" class="whmc-kbtn-2-small"  data-toggle="tooltip" title="Change plan">Plan</a>

                            <a href="clientarea.php?action=productdetails&amp;id={$service.id}" class="whmc-kbtn-2-small"  data-toggle="tooltip" title="{$LANG.manageproduct}">Manage</i></a>

                            <a href="{get_website_redirect_url($service.domain, $service.id)}" target="_blank" data-toggle="tooltip" title="Edit this website" class="whmc-kbtn-small">Edit</a>

                        {/if}


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
        });

    </script>
{/literal}