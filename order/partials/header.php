<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="en">

<head>
    <title>Order</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <script src="assets/js/jquery.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"/>
    <link href="assets/plugins/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet"/>

    <link rel="stylesheet" href="assets/fonts/mw-icons-mind/line/style.css">
    <link rel="stylesheet" href="assets/fonts/mw-icons-mind/solid/style.css">

    <link href="assets/css/typography.css" rel="stylesheet"/>

    <?php if (isset($_GET['plan-style']) AND $_GET['plan-style'] == 'v2'): ?>
        <link rel="stylesheet" href="assets/plugins/bootstrap-4.3.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="partials/steps/plans-v2/css/main.css"/>
        <link rel="stylesheet" href="partials/steps/plans-v2/css/custom.css"/>
    <?php else: ?>
        <!-- Plugins -->
        <script src="assets/plugins/bootstrap-3.3.7/js/bootstrap.min.js"></script>

        <script src="assets/js/libs/TweenMax.min.js"></script>
        <script src="assets/js/libs/anime.min.js"></script>
        <script src="assets/js/libs/jquery.sticky-sidebar.min.js"></script>
        <script src="assets/js/main.js"></script>

        <!-- Plugins Styles -->
        <link href="assets/plugins/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet"/>

        <link rel="stylesheet" href="assets/plugins/bootstrap-select-1.12.4/css/bootstrap-select.min.css">

        <link href="assets/css/main.css" class="css-main" rel="stylesheet"/>
        <link href="assets/css/custom.css" rel="stylesheet"/>
    <?php endif; ?>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script src="../scripts.js"></script>
</head>

<body class="" id="frame-body">

<div class="main">