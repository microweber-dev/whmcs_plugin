<?php include 'partials/header.php'; ?>

<?php if (isset($_REQUEST['template'])): ?>
    <?php
    $template = get_template_by_git_package_name($_REQUEST['template']);

    $homepage = 'https://microweber.com';
    $preview_url = 'https://microweber.com';
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

            <form method="post" action="<?php /*echo $current_url */?>" class="clearfix">
                <input type="hidden" value="false" name="template_view"/>
                <input type="hidden" value="1" name="start_with_template"/>

                <?php /*include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; */?>

                <a href="javascript:;" class="btn btn-primary" onclick="submitForPreview(this.parentNode);">Start with this template</a>
                &nbsp;
                <a class="btn btn-default" href="<?php /*print $preview_url; */?>" target="_blank"><i class="fa fa-times"></i></a>
            </form>
        </div>
    </div>

    <?php if ($preview_url): ?>

        <iframe id="template-demo-iframe" src="<?php print $preview_url; ?>"
                name="preview-frame" frameborder="0"
                noresize="noresize" data-view="fullScreenPreview" height="1000px" width="100%" allow="geolocation 'self'; autoplay 'self'">
        </iframe>

    <script>
        $(document).ready(function() {
           if (window.parent != window.self) {
               //alert("Screen Width: "+ globalThis.screen.availWidth +"\nScreen Height: "+ globalThis.screen.availHeight)
               $('#template-demo-iframe').css('height', globalThis.screen.availHeight);
           }
        });
    </script>


    <?php endif; ?>

<?php endif; ?>

<?php include 'partials/footer.php'; ?>