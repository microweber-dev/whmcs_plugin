<div class="mw-whm clientareadomains">

    <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css"/>

    <div>
        <div class="title-bar">
            <div class="text-center">
                <h1>{$LANG.domainrenewals}</h1> sadasddad<br/>
                {include file="templates/orderforms/{$carttpl}/category-chooser.tpl"}
            </div>
        </div>
        <br/>
        <p class="m-t-30 text-center">{$LANG.domainrenewdesc}</p>

        <form method="post" action="cart.php?a=add&renewals=true">

            <div class="table-container table-responsive clearfix m-t-20">
                <table class="table table-list">
                    <thead>
                    <tr>
                        <th width="20"></th>
                        <th>{$LANG.orderdomain}</th>
                        <th>{$LANG.domainstatus}</th>
                        <th>{$LANG.domaindaysuntilexpiry}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$renewals item=renewal}
                        <tr>
                            <td>
                                {if !$renewal.pastgraceperiod && !$renewal.beforerenewlimit}
                                    <input type="checkbox" name="renewalids[]" value="{$renewal.id}"/>
                                {/if}
                            </td>
                            <td>
                                {$renewal.domain}
                            </td>
                            <td>
                                {$renewal.status}
                            </td>
                            <td>
                                {if $renewal.daysuntilexpiry > 30}
                                    <span class="textgreen">
                                    {$renewal.daysuntilexpiry} {$LANG.domainrenewalsdays}
                                </span>
                                {elseif $renewal.daysuntilexpiry > 0}
                                    <span class="textred">
                                    {$renewal.daysuntilexpiry} {$LANG.domainrenewalsdays}
                                </span>
                                {else}
                                    <span class="textblack">
                                    {$renewal.daysuntilexpiry*-1} {$LANG.domainrenewalsdaysago}
                                </span>
                                {/if}
                                {if $renewal.ingraceperiod}
                                    <br/>
                                    <span class="textred">
                                    {$LANG.domainrenewalsingraceperiod}
                                </span>
                                {/if}
                            </td>
                            <td>
                                {if $renewal.beforerenewlimit}
                                    <span class="textred">
                                    {$LANG.domainrenewalsbeforerenewlimit|sprintf2:$renewal.beforerenewlimitdays}
                                </span>
                                {elseif $renewal.pastgraceperiod}
                                    <span class="textred">
                                    {$LANG.domainrenewalspastgraceperiod}
                                </span>
                                {else}
                                    <select name="renewalperiod[{$renewal.id}]">
                                        {foreach from=$renewal.renewaloptions item=renewaloption}
                                            <option value="{$renewaloption.period}">
                                                {$renewaloption.period} {$LANG.orderyears} @ {$renewaloption.price}
                                            </option>
                                        {/foreach}
                                    </select>
                                {/if}
                            </td>
                        </tr>
                        {foreachelse}
                        <tr class="carttablerow">
                            <td colspan="5">{$LANG.domainrenewalsnoneavailable}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>

            <p class="text-center">
                <button type="submit" class="btn mw-blue m-t-30">
                    <i class="fa fa-shopping-cart" ></i>
                    {$LANG.ordernowbutton}
                </button>
            </p>

        </form>

    </div>
</div>
