<?php include 'partials/header.php'; ?>

<?php if (isset($_REQUEST['template'])): ?>
    <?php
    $template = get_template_by_config_option_id($_REQUEST['template']);


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

        #template-demo-iframe {
            scrollbar-width: thin ;
            scrollbar-color: #777;
        }
        #template-demo-iframe::-webkit-scrollbar {
            opacity: 1;
        }


        #template-demo-iframe::-webkit-scrollbar-track {
            background: transparent;
        }


        #template-demo-iframe::-webkit-scrollbar-thumb {
            background: #777;

        }

        #template-demo-iframe::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

    <div class="container"  >
    <div class="preview-navbar">
        <div class="left logo">
            <a href="javascript:;" onclick="window.history.back()" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>
        </div>

        <?php
        /*<div class="screens">
            <button onclick="selectDevice('desktop')" type="button">
                <svg width="28" height="22" viewBox="0 0 28 22" xmlns="http://www.w3.org/2000/svg">
                    <g fill="#fff" fill-rule="evenodd">
                        <path d="M11 18h1v4h-1z"></path>
                        <path d="M9 21h10v1H9z"></path>
                        <path d="M16 18h1v4h-1z"></path>
                        <path d="M1 3v13c0 1.11.891 2 1.996 2h22.008A2.004 2.004 0 0 0 27 16V3c0-1.11-.891-2-1.996-2H2.996A2.004 2.004 0 0 0 1 3zM0 3c0-1.657 1.35-3 2.996-3h22.008A2.994 2.994 0 0 1 28 3v13c0 1.657-1.35 3-2.996 3H2.996A2.994 2.994 0 0 1 0 16V3z"></path>
                    </g>
                </svg>
            </button>
            <button onclick="selectDevice('tablet')" type="button">
                <svg width="20" height="28" viewBox="0 0 20 28" xmlns="http://www.w3.org/2000/svg">
                    <g fill="#fff" fill-rule="evenodd">
                        <path d="M1 2.996v22.008C1 26.1 1.897 27 2.994 27h14.012c1.1 0 1.994-.895 1.994-1.996V2.996A2.001 2.001 0 0 0 17.006 1H2.994C1.894 1 1 1.895 1 2.996zm-1 0A2.997 2.997 0 0 1 2.994 0h14.012A3.001 3.001 0 0 1 20 2.996v22.008A2.997 2.997 0 0 1 17.006 28H2.994A3.001 3.001 0 0 1 0 25.004V2.996z"></path>
                        <path d="M9 23h2v2H9z"></path>
                    </g>
                </svg>
            </button>
            <button onclick="selectDevice('phone')" type="button">
                <svg width="12" height="22" viewBox="0 0 12 22" xmlns="http://www.w3.org/2000/svg">
                    <g fill="#fff" fill-rule="evenodd">
                        <path d="M1 3.001V19C1 20.105 1.894 21 2.997 21h6.006A2 2 0 0 0 11 18.999V3A1.999 1.999 0 0 0 9.003 1H2.997A2 2 0 0 0 1 3.001zm-1 0A3 3 0 0 1 2.997 0h6.006A2.999 2.999 0 0 1 12 3.001V19A3 3 0 0 1 9.003 22H2.997A2.999 2.999 0 0 1 0 18.999V3z"></path>
                        <path d="M5 18h2v2H5z"></path>
                    </g>
                </svg>
            </button>
        </div>*/

        ?>

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
            height="1500px" width="100%"
            scrolling="yes"
            style="height: 1000px"
            allow="geolocation 'self'; autoplay 'self'">
    </iframe>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            if (window.parent != window.self) {
            //     $('#template-demo-iframe').css('height', (top.innerHeight - $('.preview-navbar').outerHeight()));
            } else {
             //   $('#template-demo-iframe').css('height', (self.innerHeight - $('.preview-navbar').outerHeight()));
            }
        });
    </script>
    <?php endif; ?>


    </div>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>