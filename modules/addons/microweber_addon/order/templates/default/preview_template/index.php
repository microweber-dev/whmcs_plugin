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

    <style>
        .btn-primary {
            color:#fff !important;
            background-color: #1062fe;
            border-color: #1062fe;

        }
    </style>

    <div class="container">
    <div class="preview-navbar">
        <div class="left logo">
            <a href="javascript:;" onclick="window.history.back()" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>
        </div>

        <div class="right buttons">

            <form method="post" action="<?php echo $current_url ?>" class="clearfix">
                <input type="hidden" value="false" name="template_view"/>
                <input type="hidden" value="1" name="start_with_template"/>

                <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php';?>

                <a href="<?php print $preview_url; ?>" target="_blank">
                    <span>Preview site</span>
                </a>

                <button class="btn btn-primary" onclick="submitForPreview(this.parentNode);">
                    <span>Start with this template</span>
                </button>

            </form>
        </div>
    </div>

    <?php if ($preview_url): ?>
    <iframe id="template-demo-iframe" src="<?php print $preview_url; ?>"
            name="preview-frame" frameborder="0"
            noresize="noresize" data-view="fullScreenPreview"
            height="1000px" width="100%"
            allow="geolocation 'self'; autoplay 'self'">
    </iframe>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            if (window.parent != window.self) {
                $('#template-demo-iframe').css('height', (top.innerHeight - $('.preview-navbar').outerHeight()));
            } else {
                $('#template-demo-iframe').css('height', (self.innerHeight - $('.preview-navbar').outerHeight()));
            }
        });
    </script>
    <?php endif; ?>


    </div>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>