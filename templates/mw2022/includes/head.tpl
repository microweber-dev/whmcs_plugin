<!-- Styling -->
<link rel="stylesheet" href="{$WEB_ROOT}/templates/{$template}/plugins/bootstrap/css/bootstrap.css">
{*<link rel="stylesheet" href="{$WEB_ROOT}/templates/{$template}/plugins/font-awesome-4.7.0/css/font-awesome.css">*}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/v4-shims.css">
<link rel="stylesheet" href="{$WEB_ROOT}/templates/{$template}/plugins/bootstrap-select/css/bootstrap-select.css">

{*<link href="{$WEB_ROOT}/templates/{$template}/css/microweber.css?v={$versionHash}" rel="stylesheet">*}
<link href="{$WEB_ROOT}/templates/{$template}/css/microweber-new.css" rel="stylesheet">
<link href="{$WEB_ROOT}/templates/{$template}/css/microweber-new-2022.css" rel="stylesheet">


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

{literal}
    <script type="text/javascript">
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MJ4VGK');

    </script>
{/literal}
<script>
    var whmcsBaseUrl = "{\WHMCS\Utility\Environment\WebHelper::getBaseUrl()}";
</script>
<script>
    var csrfToken = '{$token}',
        markdownGuide = '{lang|addslashes key="markdown.title"}',
        locale = '{if !empty($mdeLocale)}{$mdeLocale}{else}en{/if}',
        saved = '{lang|addslashes key="markdown.saved"}',
        saving = '{lang|addslashes key="markdown.saving"}',
        whmcsBaseUrl = "{\WHMCS\Utility\Environment\WebHelper::getBaseUrl()}",
        requiredText = '{lang|addslashes key="orderForm.required"}',
        recaptchaSiteKey = "{if $captcha}{$captcha->recaptcha->getSiteKey()}{/if}";
</script>
<script src="{$WEB_ROOT}/templates/{$template}/js/scripts.js?v={$versionHash}"></script>
<script src="{$WEB_ROOT}/templates/{$template}/js/whmcs.js?v={$versionHash}"></script>


<script src="{$WEB_ROOT}/templates/{$template}/js/microweber/script.js?v={$versionHash}" defer></script>
<script src="{$WEB_ROOT}/templates/{$template}/plugins/bootstrap-select/js/bootstrap-select.js"></script>

{if $templatefile == "viewticket" && !$loggedin}
    <meta name="robots" content="noindex"/>
{/if}

{assetExists file="custom.css"}
    <link href="{$__assetPath__}" rel="stylesheet">
{/assetExists}



{if $templatefile == "viewticket" && !$loggedin}
    <meta name="robots" content="noindex" />
{/if}
