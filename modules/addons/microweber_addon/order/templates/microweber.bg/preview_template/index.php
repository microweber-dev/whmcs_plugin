<?php include 'partials/header.php'; ?>

<?php if (isset($_GET['template'])): ?>
    <?php
        $template = get_template_by_git_package_name($_GET['template']);

        $homepage = 'http://microweber.com';
        $preview_url = 'http://microweber.com';
        if (!empty($template->preview_url)) {
            $preview_url = $template->preview_url;
        }
        if (!empty($template->homepage_url)) {
            $homepage = $template->homepage_url;
        }
        ?>

        <?php include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>

        <div class="preview-navbar">
            <div class="left logo">
                <a href="javascript:;" onclick="window.history.back()" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>
            </div>

            <div class="right buttons">

                <form method="get" action="<?php echo $current_url ?>" class="clearfix">
                    <input type="hidden" value="false" name="template_view"/>

                    <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                    <a href="javascript:;" class="btn btn-primary" onclick="submitForPreview(this.parentNode);">Започни с този темплейт</a>
                    &nbsp;
                    <a class="btn btn-default" href="<?php print $preview_url; ?>" target="_blank"><i class="fa fa-times"></i></a>
                </form>
            </div>
        </div>

        <?php if ($preview_url): ?>
            <iframe src="<?php print $preview_url; ?>" frameborder="0" allowfullscreen></iframe>
        <?php endif; ?>

<?php endif; ?>

<?php include 'partials/footer.php'; ?>