{if $showUserValidationBanner}
<div class="verification-banner user-validation">
    <div class="container">
        <div class="row">
            <div class="col-2 col-sm-1 order-3">
                <button id="btnUserValidationClose" type="button" class="btn close" data-uri="{routePath('dismiss-user-validation')}"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="col-10 col-sm-7 col-md-8 order-1">
                <i class="fal fa-passport"></i>
                <span class="text">{lang key='fraud.furtherValShort'}</span>
            </div>
            <div class="col-12 col-sm-4 col-md-3 order-sm-2 order-md-last">
                <a href="#" class="btn btn-default btn-sm btn-block btn-action" data-url="{$userValidationUrl}" onclick="openValidationSubmitModal(this);return false;">
                    {lang key='fraud.submitDocs'}
                </a>
            </div>
        </div>
    </div>
</div>
<div id="validationSubmitModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body top-margin-10">
                <iframe id="validationContent" allow="camera {$userValidationHost}" width="100%" height="700" frameborder="0" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{lang key='close'}</button>
            </div>
        </div>
    </div>
</div>
{/if}
