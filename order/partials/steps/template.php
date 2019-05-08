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
$templates = file_get_contents('https://microweber.org/api/market_json');
$templates = json_decode($templates, true);

?>
<div class="templates">
    <div class="container">
        <div class="row">
            <?php if ($templates["microweber-template"]): ?>
                <?php foreach ($templates["microweber-template"] as $template): ?>
                    <?php
                    $screenshot = '';
                    if (isset($template['latest_version']) AND isset($template['latest_version']['extra']) AND isset($template['latest_version']['extra']['_meta']) AND isset($template['latest_version']['extra']['_meta']['screenshot'])) {
                        $screenshot = $template['latest_version']['extra']['_meta']['screenshot'];
                    }

                    $description = '';
                    if (isset($template['description'])) {
                        $description = $template['description'];
                    }

                    $homepage = '';
                    if (isset($template['homepage'])) {
                        $homepage = $template['homepage'];
                    }
                    ?>

                    <?php include('params.php'); ?>

                    <div class="col-md-4 col-xs-6">
                        <form method="get" action="<?php echo $current_url ?>" class="clearfix">

                            <?php include('params_fields.php'); ?>

                            <input type="hidden" value="true" name="template_view"/>
                            <a href="javascript:;" onclick="parentNode.submit();">
                                <div class="template" style="background-image: url('<?php print $screenshot; ?>');"></div>
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