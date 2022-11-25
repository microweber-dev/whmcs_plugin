<div class="panel-default panel mt-5 pt-5 mw-whm affiliates">
    <div class="header-lined text-center">
        <h1>Affiliate Program</h1><br />
    </div>
    {if $affiliatesystemenabled}
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                {include file="$template/includes/alert.tpl" type="info" title=$LANG.affiliatesignuptitle msg=$LANG.affiliatesignupintro|cat:'<br /><br />' textcenter=true}

                <ul class="features">
                    <li><span>{$LANG.affiliatesignupinfo1}</span></li>
                    <li><span>{$LANG.affiliatesignupinfo2}</span></li>
                    <li><span>{$LANG.affiliatesignupinfo3}</span></li>
                </ul>

                <br/>
                <br/>

                <form method="post" action="affiliates.php">
                    <input type="hidden" name="activate" value="true"/>
                    <p align="center"><input type="submit" value="{$LANG.affiliatesactivate}" class="cbtn"/></p>
                </form>
            </div>
        </div>
    {else}
        {include file="$template/includes/alert.tpl" type="warning" msg=$LANG.affiliatesdisabled textcenter=true}
    {/if}
</div>