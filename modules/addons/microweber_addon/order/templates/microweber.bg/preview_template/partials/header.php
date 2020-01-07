<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="en">

<head>
    <title>Preview Template</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <script src="<?php echo $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/assets/js/jquery.js"></script>

    <!-- Custom Theme -->
    <link href="<?php echo $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/assets/plugins/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/assets/plugins/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat+Alternates&display=swap" rel="stylesheet">


    <style>
        body {
            overflow: hidden;
            font-family: 'Open Sans', sans-serif;
            height: calc(100vh - 60px);
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

        .preview-navbar form {
            margin-bottom: 0;
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

        .btn{
            font-family: 'Montserrat Alternates', sans-serif;
            font-weight:bold;
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

        .btn-default-outline {
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

        .btn-primary-outline {
            color: #ff4200;
            background: #fff;
            border: 1px solid #ff4200;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .btn-primary-outline.focus, .btn-primary-outline:focus, .btn-primary-outline:hover {
            color: #fff;
            background: #ff4200;
            border: 1px solid #ff4200;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .btn-primary {
            color: #fff;
            background: #ff4200;
            border: 1px solid #ff4200;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .btn-primary.focus, .btn-primary:focus, .btn-primary:hover {
            color: #ff4200;
            background: #fff;
            border: 1px solid #ff4200;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }



    </style>
</head>

<body>

