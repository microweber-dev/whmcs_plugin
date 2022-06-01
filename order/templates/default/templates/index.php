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
<div class="templates">
    <div class="container">
        <?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?>
            <div class="row">
                <div class="col-md-12 text-center"><h1>Select Template</h1></div>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if ($templates): ?>
                <?php foreach ($templates as $template): ?>

                    <?php
                    $template_id = $template->config_option_id;
                    $config_gid = $template->config_option_group_id;
                    ?>

                    <?php include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>

                    <div class="col-md-4 col-xs-6">
                        <form method="post" action="<?php echo $current_url ?>" <?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?> target="_top"<?php endif; ?> class="clearfix">

                            <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                            <input type="hidden" value="true" name="template_view"/>

                            <a href="javascript:;" onclick="parentNode.submit();">
                                <div class="template" style="background-image: url('<?php echo $template->screenshot_url; ?>');"></div>
                                <h3><?php echo $template->preview_name; ?></h3>
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
    });
</script>
<?php include 'partials/footer.php'; ?>
