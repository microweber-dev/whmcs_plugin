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
$templates = get_enabled_templates();
?>
<?php if (empty((array) $templates)): ?>
    <div class="alert alert-danger" role="alert">
        <?php print Lang::trans('MWnoTemplatesAreEnabled') ?>
    </div>
<?php endif; ?>

<div class="templates">
    <div class="container">
        <?php if (isset($_GET['target']) AND $_GET['target'] == '_top'): ?>
            <div class="row">
                <div class="col-md-12 text-center mb-5">

                    <h1 style="font-size: 48px; font-weight: 700;"><?php print Lang::trans('MWweCreateAWebsiteBasedOnTemplate') ?></h1>
                    <p style="font-size: 18px!important; font-weight: 300;"><?php print Lang::trans('MWchooseFromALibraryOfHundred') ?></p>

                </div>
            </div>
        <?php endif; ?>

        <div class="row box-template-row">
            <?php if ($templates): ?>
                <?php foreach ($templates as $template): ?>

                    <?php
                    $template_id = $template->config_option_id;
                    $config_gid = $template->config_option_group_id;
                    ?>

                    <?php include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>

                    <div class="col-box-template m-b-30 template-box">
                        <form id="template-<?php print $template_id ?>" method="post" action="<?php echo $current_url ?>" <?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?> target="_top"<?php endif; ?> class="clearfix">

                            <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                            <input type="hidden" value="true" name="template_view"/>

                            <a href="javascript:;" onclick="parentNode.submit();">
                                <div class="template" style="background-image: url('<?php echo $template->screenshot_url; ?>');"></div>
                                <h3 class="template-box-bottom-1" style="font-size: 18px; font-weight: 700;"><?php echo $template->preview_name; ?></h3>
                            </a>

                        </form>

                        <div class="template-box-bottom-2 m-t-15">
                            <button type="submit" form="template-<?php print $template_id ?>" class="whmc-kbtn-2" style="margin-right: 10px;"><?php print Lang::trans('MWpreview') ?></button>

                            <form id="template-start-<?php print $template_id ?>" method="post" action="<?php echo $current_url ?>" <?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?> target="_top"<?php endif; ?> class="clearfix">

                                <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                                <input type="hidden" value="true" name="template_view"/>
                                <input type="hidden" value="true" name="skip_preview_template"/>


                                <button type="submit" class="whmc-kbtn" form="template-start-<?php print $template_id ?>"><?php print Lang::trans('MWstart') ?></button>
                            </form>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        scroll_iframe_to_parent();
    });
</script>
<?php include 'partials/footer.php'; ?>
