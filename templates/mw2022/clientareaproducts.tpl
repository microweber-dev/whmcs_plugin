<div class="mw-whm clientareaproducts">

    <div class="header-lined text-center">
        <h1>My Products</h1>
        <br/>
        <a href="https://microweber.com/get-started" class="cbtn m-b-10"><i class="fa fa-plus"></i> &nbsp; Create New Website</a>
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
                <th>{$LANG.orderproduct}</th>
                <th>{$LANG.clientareaaddonpricing}</th>
                <th>{$LANG.clientareahostingnextduedate}</th>
                <th>{$LANG.clientareastatus}</th>
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


                            <a href="upgrade.php?type=package&id={$service.id}" class="cbtn cbtn-alt cbtn-small cbtn-circle" data-toggle="tooltip" title="Change plan"><i class="fa fa-database"></i></a>

                            <a href="clientarea.php?action=productdetails&amp;id={$service.id}" class="cbtn cbtn-alt cbtn-small cbtn-circle" data-toggle="tooltip" title="{$LANG.manageproduct}"><i class="fa fa-cog"></i></a>

                            <a href="{get_website_redirect_url($service.domain, $service.id)}" target="_blank" class="cbtn cbtn-small">Edit site</a>

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

