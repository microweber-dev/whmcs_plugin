<?php include 'partials/header.php'; ?>
<style>
    .templates {
        padding: 60px 0;
        background: #fff;

    }

    .templates h3 {
        color: #2b2b2b;
        font-size: 14px;
        font-weight: bold;
    }

    .templates p {
        color: #2b2b2b;
        font-size: 13px;

    }

    .templates .container {
        background: #fff;
    }

    .templates a {
        text-decoration: none !important;
    }

    .templates .template {
        width: 420px;
        height: 350px;
        -webkit-background-size: contain;
        background-size: contain;
        background-repeat: no-repeat;
        display: inline-block;
        position: relative;
        overflow: hidden;
        transition: all 5s;
        background-size: 100% auto;
        background-repeat: no-repeat;
        background-position: center top;
        margin: 30px 0 0 0;
        border: 2px solid #f5f5f5;
        max-width: 100%;
    }

    .templates .template:hover {
        background-position: center bottom;
    }

</style>
<?php
//$templates = file_get_contents('https://microweber.org/api/market_json');
//$templates = json_decode($templates, true);


$hosting = new \MicroweberAddon\Hosting();

$templates = $hosting->get_enabled_market_templates('only_with_screenshots=1');
//dd($enabled_templates);
//dd($enabled_templates);
//$selected_templates =
//dd($templates);
?>
<div class="templates">
    <div class="container">
        <?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?>
            <div class="row">
                <div class="col-md-12 text-center"><h1>Избери темплейт</h1></div>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if ($templates): ?>
                <?php foreach ($templates as $template): ?>
                    <?php

                    // print_r($template);

                    $screenshot = '';
                    if (isset($template) AND isset($template['extra']) AND isset($template['extra']['_meta']) AND isset($template['extra']['_meta']['screenshot'])) {
                        $screenshot = $template['extra']['_meta']['screenshot'];
                    }

                    $description = '';
                    if (isset($template['description'])) {
                        $description = $template['description'];
                    }

                    $homepage = '';
                    if (isset($template['homepage'])) {
                        $homepage = $template['homepage'];
                    }


                    if (isset($template['configoption']) and isset($template['configoption']['id'])) {
                        $template_id = $template['configoption']['id'];
                    }
                    if (isset($template['configoption']) and isset($template['configoption']['configid'])) {
                        $config_gid = $template['configoption']['configid'];
                    }


                    //    print_r($template['configoption']);


                    ?>

                    <?php include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>

                    <div class="col-md-4 col-xs-6">
                        <form method="get" action="<?php echo $current_url ?>" <?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?> target="_top"<?php endif; ?> class="clearfix">

                            <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                            <input type="hidden" value="true" name="template_view"/>
                            <a href="javascript:;" onclick="parentNode.submit();">
                                <div class="template"
                                     style="background-image: url('<?php print $screenshot; ?>');"></div>
                                <h3><?php print $description; ?></h3>
                                <!-- <p><?php print $description; ?></p>-->
                            </a>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        scroll_iframe_to_parent();
        // if(typeof(iframe) != 'undefined'){
        // iframe.scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
        // }

    });

</script>

<?php include 'partials/footer.php'; ?>
