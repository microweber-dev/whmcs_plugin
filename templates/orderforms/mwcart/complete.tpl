<link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css" />


{literal}<script type="text/javascript">


  var timeleft = 30;
  var downloadTimer = setInterval(function(){
    document.getElementById("progressBar").value = 30 - --timeleft;
    if(timeleft <= 0) {
      clearInterval(downloadTimer);
        $('#order-loading').fadeOut();
        $('#order-loading-done').fadeIn();
    }
  },1000);



</script>
{/literal}



<div id="order-modern">



<div class="oc-hero">
{*  <h1>{$LANG.orderconfirmation}</h1>*}
</div>

<div id="order-loading">

  <p  style="text-align: center; padding-top: 40px;">Loading...
    <progress value="0" max="10" id="progressBar"></progress></p>

</div>


  <div id="order-loading-done" style="display: none">
  <p align="center" style="padding-top: 40px;">


    <a href="{get_website_login_by_orderid($orderid)}" target="_blank"
       data-toggle="tooltip" title="Edit this website"
       class="whmc-kbtn">Go to my website</a>



  </p>
  </div>



  <h3 class="oi-title">Order information</h3>

<div class="signupfields padded">

<p>{$LANG.orderreceived}</p>

<div class="cartbox">
<p style="text-align: center;"><strong>{$LANG.ordernumberis} {$ordernumber}</strong></p>




</div>

<p>{$LANG.orderfinalinstructions}</p>

{if $invoiceid && !$ispaid}
<br />
<div class="errorbox" style="display:block;">{$LANG.ordercompletebutnotpaid}</div>
<p align="center"><a href="viewinvoice.php?id={$invoiceid}" target="_blank">{$LANG.invoicenumber}{$invoiceid}</a></p>
{/if}

{foreach from=$addons_html item=addon_html}
<div style="margin:15px 0 15px 0;">{$addon_html}</div>
{/foreach}

{if $ispaid}
<!-- Enter any HTML code which needs to be displayed once a user has completed the checkout of their order here - for example conversion tracking and affiliate tracking scripts -->
{/if}

</div>






<p align="center"><a class="btn btn-small" href="clientarea.php?action=services">{$LANG.ordergotoclientarea}</a></p>

<br /><br />

</div>