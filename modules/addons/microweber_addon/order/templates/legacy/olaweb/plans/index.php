<?php include 'partials/header.php'; ?>

<?php
$plans = $controller->get_hosting_products();
?>

<?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?>
    <div class="row m-t-20">
        <div class="col-md-12 text-center"><h1>Choose a plan</h1></div>
    </div>
<?php endif; ?>

<?php if ($plans): ?>
    <?php foreach ($plans as $key => $plan): ?>
        <?php
        if ($key == 0) {
            $planColor = 'primary';
            $planKey = 1;
        } elseif ($key == 1) {
            $planColor = 'default';
            $planKey = 2;
        } elseif ($key == 2) {
            $planColor = 'info';
            $planKey = 3;
        } else {
            $planColor = 'primary';
            $planKey = 1;
        }
        ?>

        <?php if ($key == 0): ?>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>You can make a website, online store or blog is completely free with the site builder on <?php echo $CONFIG['CompanyName']; ?>. <br/> Also support free hosting for it up to 1000 mb of Neterra sponsored space.<br/><br/></p>
                            <p>Start now with our absolutely free plan!</p>
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif ($key == 1): ?>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>You can make a website, online store or blog is completely free with the site builder on <?php echo $CONFIG['CompanyName']; ?>. <br/> Also support free hosting for it up to 1000 mb of Neterra sponsored space.<br/><br/></p>
                            <p>Start now with our absolutely free plan!</p>
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif ($key == 2): ?>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>You can make a website, online store or blog is completely free with the site builder on <?php echo $CONFIG['CompanyName']; ?>. <br/> Also support free hosting for it up to 1000 mb of Neterra sponsored space.<br/><br/></p>
                            <p>Start now with our absolutely free plan!</p>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="section-15 inverse">
            <div class="container align-self-center">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="img-holder-bg d-flex align-items-center justify-content-center" style="background-image: url('<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/olaweb/plans/assets/img/plans-<?php print $planKey; ?>.png');">
                            <div class="text-left">
                                <h2 class="text-<?php echo $planColor; ?>"><?php print $plan['name'] ?>!</h2>
                                <?php if ($key == 0): ?>
                                    <h2>300MB <span class="text-default">de espaço<br>grátis</span> <br>e tráfego <br>ilimitado.</h2>
                                <?php elseif ($key == 1): ?>
                                    <h2>300MB <span class="text-default">de espaço<br>grátis</span> <br>e tráfego <br>ilimitado.</h2>
                                <?php elseif ($key == 2): ?>
                                    <h2>300MB <span class="text-default">de espaço<br>grátis</span> <br>e tráfego <br>ilimitado.</h2>
                                <?php endif; ?>

                                <div class="m-t-50 support-by">
                                    <p>Inicie agora mesmo seu projeto: &nbsp; <img src="<?php print $CONFIG['LogoURL']; ?>" alt="" style="max-width: 140px;"/></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-center">
                        <div class="info-holder text-left ">
                            <div class="align-self-center">
                                <img src="<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/olaweb/plans/assets/img/plans-up-<?php print $planKey; ?>.png"/><br/><br/>
                                <div class="box">
                                    <div class="thing"><img src="<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/olaweb/plans/assets/img/plan-<?php print $planKey; ?>.svg"/></div>
                                    <div class="price text-<?php echo $planColor; ?>">
                                        <span class="sum"><script language="javascript" src="<?php print site_url(); ?>/feeds/productsinfo.php?pid=<?php print $plan['id'] ?>&get=price&billingcycle=monthly"></script></span> <span class="per"> / per month</span>
                                    </div>
                                    <br/>

                                    <br/>
                                    <?php echo $plan['description']; ?>

                                    <div class="text-center" style="margin-bottom: -63px; margin-top: 30px;">
                                        <a href="<?php echo $current_url ?>&plan=<?php print $plan['id'] ?>" class="btn btn-<?php echo $planColor; ?> btn-md">Order <?php print $plan['name'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>