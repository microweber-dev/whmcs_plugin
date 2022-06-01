<div class="mw-whm submittickket">
    <div class="header-lined text-center">
        <h1>Support / Open Ticket</h1>
        <p>{$LANG.supportticketsheader}</p>
    </div>

    <br/>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="row">
                {foreach from=$departments key=num item=department}
                    <div class="col-md-6 margin-bottom">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <div class="pull-right">
                                        <a href="{$smarty.server.PHP_SELF}?step=2&amp;deptid={$department.id}" class="btn btn-default btn-xs">
                                            open ticket
                                        </a>
                                    </div>
                                    <i class="fa fa-envelope"></i> {$department.name}
                                </h3>
                            </div>
                            <div class="panel-body">
                                {if $department.description}
                                    <p>{$department.description}</p>
                                {/if}
                            </div>

                            <div class="panel-footer">

                            </div>
                        </div>
                    </div>
                    {if $num % 2 == true}
                        <div class="clearfix"></div>
                    {/if}
                    {foreachelse}
                    {include file="$template/includes/alert.tpl" type="info" msg=$LANG.nosupportdepartments textcenter=true}
                {/foreach}
            </div>
        </div>
    </div>
</div>