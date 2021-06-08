edit the file 


modules/addons/ResellersCenter/templates/clientarea/default/pages/configuration/general.tpl


and add


```
{if file_exists("modules/addons/microweber_addon/integrations/resellercenter/tpl/general.tpl")}
{include file="modules/addons/microweber_addon/integrations/resellercenter/tpl/general.tpl"}
{/if}

```