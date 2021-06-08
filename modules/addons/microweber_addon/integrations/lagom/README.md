edit the file 


templates/lagom/core/pages/homepage/modern/shared/banner-slider.tpl

and add


```
{if file_exists("modules/addons/microweber_addon/integrations/lagom/tpl/banner-slider.tpl")}
{include file="modules/addons/microweber_addon/integrations/lagom/tpl/banner-slider.tpl"}
{/if}

```




edit the file 


templates/lagom/core/pages/homepage/modern/homepage.tpl

and add at the top


```
{if file_exists("modules/addons/microweber_addon/integrations/lagom/tpl/homepage.tpl")}
{include file="modules/addons/microweber_addon/integrations/lagom/tpl/homepage.tpl"}


{else}

rest of the page here

{/if}

```