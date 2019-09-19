<?php
$templates = file_get_contents('https://microweber.org/api/market_json');
$templates = json_decode($templates, true);
?>
<html>
<head>
    <title>Preview Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        body {
            overflow: hidden;
            font-family: 'Open Sans', sans-serif;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        .preview-navbar {
            width: 100%;
            height: 60px;
            border-bottom: 1px solid #000;
            background: #292929;
        }

        .preview-navbar form{
            margin-bottom:0;
        }

        .preview-navbar .left,
        .preview-navbar .right {
            float: left;
            width: 50%;
            box-sizing: border-box;
        }

        .preview-navbar .right {
            text-align: right;
        }

        .preview-navbar .logo {
            padding: 13px 35px;
        }

        .preview-navbar .logo img {
            max-width: 100%;
        }

        .preview-navbar .buttons {
            padding: 13px 25px;
        }

        .preview-navbar .buttons .close {
            display: block;
            float: right;
            margin-left: 40px;
        }

        .preview-navbar .buttons .close img {
            max-width: 100%;
            margin-top: 12px;
            width: 18px;
            height: 18px;
        }

        .preview-navbar .buttons .close:hover img {
            opacity: 0.8;
        }

        @media screen and (max-width: 480px) {
            .preview-navbar .left {
                width: 45%;
            }

            .preview-navbar .right {
                width: 55%;
            }

            .preview-navbar .logo {
                padding: 16px 15px;
            }

            .preview-navbar .buttons {
                padding: 11px 15px;
            }

            .preview-navbar .buttons .cbtn.cbtn-success {
                padding: 0px 15px;

                width: auto;
                margin: 0 10px;

                font-size: .8rem;
            }

        }

        .btn-default {
            color: #fff;
            background: #0303ff;
            border: 1px solid #0303ff;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .btn-default-outline,
        .btn-default.focus,
        .btn-default:focus,
        .btn-default:hover {
            color: #0303ff;
            background: #fff;
            border: 1px solid #0303ff;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .btn-default-outline.focus, .btn-default-outline:focus, .btn-default-outline:hover {
            color: #fff;
            background: #0303ff;
            border: 1px solid #0303ff;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .btn-default-outline,
        .btn-default.focus,
        .btn-default:focus,
        .btn-default:hover {
            color: #0303ff;
            background: #fff;
            border: 1px solid #0303ff;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

    </style>

    <script src="../scripts.js"></script>

    <script>
        var submitForPreview = function (form) {
            form.submit();
        }


        $(document).ready(function () {

        });
    </script>
</head>
<body>
<?php if ($templates["microweber-template"]): ?>
    <?php foreach ($templates["microweber-template"] as $template): ?>
        <?php if (isset($_GET['template']) AND $template['name'] == $_GET['template']): ?>
            <?php
            $screenshot = '';
            if (isset($template['latest_version']) AND isset($template['latest_version']['extra']) AND isset($template['latest_version']['extra']['_meta']) AND isset($template['latest_version']['extra']['_meta']['screenshot'])) {
                $screenshot = $template['latest_version']['extra']['_meta']['screenshot'];
            }

            $description = '';
            if (isset($template['description'])) {
                $description = $template['description'];
            }

            $homepage = 'http://microweber.com';
            if (isset($template['homepage'])) {
                $homepage = $template['homepage'];
            }

            $preview_url = 'http://microweber.com';
            if (isset($template['latest_version']) AND isset($template['latest_version']['extra']) AND isset($template['latest_version']['extra']['preview_url'])) {
                $preview_url = $template['latest_version']['extra']['preview_url'];
                $preview_url = str_replace('http://', 'https://', $preview_url);
            }

            ?>

            <?php include('params.php'); ?>

            <div class="preview-navbar">
                <div class="left logo">
                    <a href="javascript:;" onclick="window.history.back()" class="btn btn-default">Go Back</a>
                </div>

                <div class="right buttons">

                    <form method="get" action="<?php echo $current_url ?>" class="clearfix">
                        <input type="hidden" value="false" name="template_view"/>

                        <?php include('params_fields.php'); ?>

                        <a class="btn btn-default" href="<?php print $preview_url; ?>" target="_blank">Remove the Frame</a>
                        <a href="javascript:;" class="btn btn-default-outline" onclick="submitForPreview(this.parentNode);">Start with this Template</a>
                    </form>
                </div>
            </div>
            <?php if ($preview_url): ?>
                <iframe src="<?php print $preview_url; ?>" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>