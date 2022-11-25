
<style>
    #mw-whm-submit-ticket-block .col-xs-6.captchaimage,
    #mw-whm-submit-ticket-block .col-xs-6.captchaimage + .col-xs-6{
        padding: 0;
        margin: 0;
    }
    #mw-whm-submit-ticket-block .col-xs-6.captchaimage{
        width: 150px;
        padding: 12.5px;
        text-align: center;
        background-color: #7ab2cb;
        border-radius: 5px 0 0 5px;
    }
    #mw-whm-submit-ticket-block .md-header.btn-toolbar{
        display: none;
    }




    #default-captcha-domainchecker,
    #default-captcha-domainchecker{
        overflow: hidden;
        padding: 20px;
        text-align: left;
    }
    #mw-whm-attachments-row {
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 15px;
        margin: 0px;
    }
    #mw-whm-attachments-row input[type="file"]{
        margin: 15px 0;
        border: none;
        box-shadow: none;
        height: auto;
        padding: 0;
    }
    #mw-whm-attachments-row .text-muted{
        font-size:14px;
    }
    #mw-whm-attachments-row{
        max-width: 550px;
    }
</style>

<div class="mw-whm submittickket" id="mw-whm-submit-ticket-block">
    <div class="header-lined text-center mb-5">
        <h1>{$LANG.MW_supportTicket}</h1><br />
    </div>

    {if $errormessage}
        {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
    {/if}

    <form method="post" action="{$smarty.server.PHP_SELF}?step=3" enctype="multipart/form-data" role="form">

        <div class="row">

               <div class="col-sm-12">
                   <div class="form-group py-3 col-lg-6 col-12">
                       <label for="inputName">{$LANG.supportticketsclientname}</label>
                       <input type="text" name="name" id="inputName" value="{if $loggedin}{$clientname}{else}{$name}{/if}"
                              class="form-control{if $loggedin} disabled{/if}"{if $loggedin} disabled="disabled"{/if} />
                   </div>
                   <div class="form-group py-3 col-lg-6 col-12">
                       <label for="inputEmail">{$LANG.supportticketsclientemail}</label>
                       <input type="email" name="email" id="inputEmail" value="{$email}" class="form-control{if $loggedin} disabled{/if}"{if $loggedin} disabled="disabled"{/if} />
                   </div>


                   <div class="form-group py-3 col-md-12 col-12">
                       <label for="inputSubject">{$LANG.supportticketsticketsubject}</label>
                       <input type="text" name="subject" id="inputSubject" value="{$subject}" class="form-control"/>
                   </div>


                   <div class="form-group py-3 col-lg-4 col-12">
                       <label for="inputDepartment">{$LANG.supportticketsdepartment}</label>
                       <select name="deptid" id="inputDepartment" class="form-control" onchange="refreshCustomFields(this)">
                           {foreach from=$departments item=department}
                               <option value="{$department.id}"{if $department.id eq $deptid} selected="selected"{/if}>
                                   {$department.name}
                               </option>
                           {/foreach}
                       </select>
                   </div>
                   {if $relatedservices}
                       <div class="form-group py-3 col-lg-4 col-12">
                           <label for="inputRelatedService">{$LANG.relatedservice}</label>
                           <select name="relatedservice" id="inputRelatedService" class="form-control">
                               <option value="">{$LANG.none}</option>
                               {foreach from=$relatedservices item=relatedservice}
                                   <option value="{$relatedservice.id}">
                                       {$relatedservice.name} ({$relatedservice.status})
                                   </option>
                               {/foreach}
                           </select>
                       </div>
                   {/if}
                   <div class="form-group py-3 col-lg-4 col-12">
                       <label for="inputPriority">{$LANG.supportticketspriority}</label>
                       <select name="urgency" id="inputPriority" class="form-control">
                           <option value="High"{if $urgency eq "High"} selected="selected"{/if}>
                               {$LANG.supportticketsticketurgencyhigh}
                           </option>
                           <option value="Medium"{if $urgency eq "Medium" || !$urgency} selected="selected"{/if}>
                               {$LANG.supportticketsticketurgencymedium}
                           </option>
                           <option value="Low"{if $urgency eq "Low"} selected="selected"{/if}>
                               {$LANG.supportticketsticketurgencylow}
                           </option>
                       </select>
                   </div>
                   <div class=" form-group py-3 col-sm-12">
                       <label for="inputMessage">{$LANG.contactmessage}</label>
                       <textarea name="message" id="inputMessage" rows="12" class="form-control markdown-editor" data-auto-save-name="client_ticket_open">{$message}</textarea>
                   </div>

                  <div class=" col-md-8 col-12 justify-content-center">
                      <div class="col-sm-12 form-group py-3" id="mw-whm-attachments-row">
                          <div class="col-md-12">
                              <label for="inputAttachments">{$LANG.supportticketsticketattachments}</label>
                          </div>
                          <div class="col-lg-6 col-12">
                              <input type="file" name="attachments[]" id="inputAttachments" class="form-control"/>
                              <div id="fileUploadsContainer"></div>
                          </div>
                          <div class="col-lg-6 col-12">
                              <button type="button" class="whmc-kbtn-2 btn-block" onclick="extraTicketAttachment()">
                                  <i class="fa fa-plus"></i> {$LANG.addmore}
                              </button>
                          </div>
                          <div class="col-md-12 ticket-attachments-message text-muted">
                              {$LANG.supportticketsallowedextensions}: {$allowedfiletypes}
                          </div>
                      </div>
                  </div>

                   <div class="col-lg-5 col-12">
                       <div id="customFieldsContainer">
                           {include file="$template/supportticketsubmit-customfields.tpl"}
                       </div>
                       <div id="autoAnswerSuggestions" class="well hidden"></div>

                   </div>
                   <div class="col-lg-8 col-12">
                       <div class="text-center margin-bottom">
                           {include file="$template/includes/captcha.tpl"}
                       </div>
                   </div>


               </div>

                   <div class=" col-12 text-center mx-auto mt-5">

                       <a href="supporttickets.php" class="whmc-kbtn-2 mx-2">{$LANG.cancel}</a>
                       <input type="submit" id="openTicketSubmit" value="{$LANG.supportticketsticketsubmit}" class="whmc-kbtn mx-2"/>
                   </div>
        </div>

    </form>

    {if $kbsuggestions}
        <script>
            jQuery(document).ready(function () {
                getTicketSuggestions();
            });
        </script>
    {/if}
</div>
