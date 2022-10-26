{if $createSuccess}
    {include file="$template/includes/alert.tpl" type="success" msg="<i class='fa fa-check fa-fw'></i> {$LANG.paymentMethods.addedSuccess}"}
{elseif $createFailed}
    {include file="$template/includes/alert.tpl" type="warning" msg="<i class='fa fa-times fa-fw'></i> {$LANG.paymentMethods.addFailed}"}
{elseif $saveSuccess}
    {include file="$template/includes/alert.tpl" type="success" msg="<i class='fa fa-check fa-fw'></i> {$LANG.paymentMethods.updateSuccess}"}
{elseif $saveFailed}
    {include file="$template/includes/alert.tpl" type="warning" msg="<i class='fa fa-check fa-fw'></i> {$LANG.paymentMethods.saveFailed}"}
{elseif $setDefaultResult === true}
    {include file="$template/includes/alert.tpl" type="success" msg="<i class='fa fa-check fa-fw'></i> {$LANG.paymentMethods.defaultUpdateSuccess}"}
{elseif $setDefaultResult === false}
    {include file="$template/includes/alert.tpl" type="warning" msg="<i class='fa fa-times fa-fw'></i> {$LANG.paymentMethods.defaultUpdateFailed}"}
{elseif $deleteResult === true}
    {include file="$template/includes/alert.tpl" type="success" msg="<i class='fa fa-check fa-fw'></i> {$LANG.paymentMethods.deleteSuccess}"}
{elseif $deleteResult === false}
    {include file="$template/includes/alert.tpl" type="warning" msg="<i class='fa fa-times fa-fw'></i> {$LANG.paymentMethods.deleteFailed}"}
{/if}

<p>{$LANG.paymentMethods.intro}</p>

<p>
    <a href="{routePath('account-paymentmethods-add')}" class="whmc-kbtn " data-role="add-new-credit-card">
        {$LANG.paymentMethods.addNewCC}
    </a>
    {if $allowBankDetails}
    <a href="{routePathWithQuery('account-paymentmethods-add', null, 'type=bankacct')}" class="whmc-kbtn-2">
        {$LANG.paymentMethods.addNewBank}
    </a>
    {/if}
</p>

<table class="table table-striped">
    <tr>
        <th></th>
        <th>{$LANG.paymentMethods.name}</th>
        <th>{$LANG.paymentMethods.description}</th>
        <th>{$LANG.paymentMethods.status}</th>
        <th colspan="2">{$LANG.paymentMethods.actions}</th>
    </tr>
    {foreach $client->payMethods->validateGateways() as $payMethod}
        <tr>
            <td>
                <i class="{$payMethod->getFontAwesomeIcon()}"></i>
            </td>
            <td>{$payMethod->payment->getDisplayName()}</td>
            <td>
                {if $payMethod->description}
                    {$payMethod->description}
                {else}
                    -
                {/if}
            </td>
            <td>{$payMethod->getStatus()}{if $payMethod->isDefaultPayMethod()} - {$LANG.paymentMethods.default}{/if}</td>
            <td>
                <a href="{routePath('account-paymentmethods-setdefault', $payMethod->id)}" class="btn btn-sm btn-default btn-set-default{if $payMethod->isDefaultPayMethod() || $payMethod->isExpired()} disabled{/if}">
                    {$LANG.paymentMethods.setAsDefault}
                </a>
                <a href="{routePath('account-paymentmethods-view', $payMethod->id)}" class="btn btn-sm btn-default{if $payMethod->getType() == 'RemoteBankAccount'} disabled{/if}" data-role="edit-payment-method">
                    <i class="fa fa-pencil"></i>
                    {$LANG.paymentMethods.edit}
                </a>
                {if $allowDelete}
                    <a href="{routePath('account-paymentmethods-delete', $payMethod->id)}" class="btn btn-sm btn-default btn-delete">
                        <i class="fa fa-trash"></i>
                        {$LANG.paymentMethods.delete}
                    </a>
                {/if}
            </td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="6" align="center">
                {$LANG.paymentMethods.noPaymentMethodsCreated}
            </td>
        </tr>
    {/foreach}
</table>

<form method="post" action="" id="frmDeletePaymentMethod">
<div class="modal fade" id="modalPaymentMethodDeleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{$LANG.paymentMethods.areYouSure}</h4>
      </div>
      <div class="modal-body">
        <p>{$LANG.paymentMethods.deletePaymentMethodConfirm}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="whmc-kbtn-2" data-dismiss="modal">{$LANG.no}</button>
        <button type="submit" class="whmc-kbtn ">{$LANG.yes}</button>
      </div>
    </div>
  </div>
</div>
</form>

<form method="post" action="" id="frmSetDefaultPaymentMethod"></form>

<script>
    jQuery(document).ready(function() {
        jQuery('.btn-set-default').click(function(e) {
            e.preventDefault();
            jQuery('#frmSetDefaultPaymentMethod')
                .attr('action', jQuery(this).attr('href'))
                .submit();
        });
        jQuery('.btn-delete').click(function(e) {
            e.preventDefault();
            jQuery('#frmDeletePaymentMethod')
                .attr('action', jQuery(this).attr('href'));
            jQuery('#modalPaymentMethodDeleteConfirmation').modal('show');
        });
    });
</script>
