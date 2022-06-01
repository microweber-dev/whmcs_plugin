<?php include 'partials/header.php'; ?>

<?php
$plans = $controller->get_hosting_products();
?>

<?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?>
    <div class="row m-t-20">
        <div class="col-md-12 text-center"><h1 class="bold">Избери си план</h1></div>
        <div class="col-md-12 text-center"><p>Направи си <strong>сайт лесно, бързо и забавно</strong>. Избери с кой план ще започнеш?</p></div>
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
            <section class="section p-b-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p class="m-b-0">Можете да си направите сайт, он-лайн магазин или блог напълно безплатно с сайт билдъра на <?php echo $CONFIG['CompanyName']; ?>. <br/>Подаряваме ти и безплатен хостинг за него до 1000 mb дисково пространство.<br/><br/></p>
                            <!--                            <p>Започни още сега с абсолютно безплатния ни план!</p>-->
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif ($key == 1): ?>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>С план “ъпгрейд” получаваш достъп до всички темплейти и модули на Микроубър.</p>
                            <p>Използваш собствен домейн, е-мейл. Имап 10 gb дисково пространство и разчиташ на техническа поддръжка по всяко време.</p>
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif ($key == 2): ?>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>Наеми си сървър от най-големия български телеком, Нетера.<br/>
                                Развивай своят он-лайн бизнес с лекота, с нает сървър от Нетера и получи огромна отстъпка
                                <br/>и специално отношение.</p>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="section-15 inverse p-t-0">
            <div class="container align-self-center">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="img-holder-bg d-flex align-items-center justify-content-center" style="background-image: url('<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plans-<?php print $planKey; ?>.png');">
                            <div class="text-left" style="max-width: 460px;">
                                <h2 class="text-<?php echo $planColor; ?>"><?php print $plan['name'] ?>!</h2>
                                <?php if ($key == 0): ?>
                                    <h2>1 GB <span class="text-default">безплатно пространство</span><br/> и неограничен <br/>трафик.</h2>
                                <?php elseif ($key == 1): ?>
                                    <h2>10 GB свободно<br/> пространство,<br/> собствен <br/>домейн и имейл.</h2>
                                <?php elseif ($key == 2): ?>
                                    <h2>Наеми си сървър,<br/> подходящ за<br/> онлайн търговци.</h2>
                                <?php endif; ?>
                                <?php if ($key == 0): ?>
                                    <div class="m-t-50 support-by" style="display: none;">
                                        <p>С подкрепата на: &nbsp; <a href="https://neterra.net/bg" target="_blank"><img src="<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/neterra_logo.png" alt=""/></a></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-center">
                        <div class="info-holder text-left ">
                            <div class="align-self-center">
                                <img src="<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plans-up-<?php print $planKey; ?>.png"/><br/><br/>
                                <div class="box">
                                    <div class="thing"><img src="<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plan-<?php print $planKey; ?>.svg"/></div>
                                    <div class="price text-<?php echo $planColor; ?>">
                                        <span class="sum">
                                            <?php if ($key == 0): ?>
                                                0 лв.
                                            <?php else: ?>
                                                <script language="javascript" src="<?php print site_url(); ?>/feeds/productsinfo.php?pid=<?php print $plan['id'] ?>&get=price&billingcycle=monthly&currency=4"></script>
                                            <?php endif; ?>
                                        </span>
                                        <span class="per"> / на месец</span>
                                    </div>
                                    <?php if ($key == 1): ?>
                                        <p class="bold text-default m-t-10">При едногодишен абонамент</p>
                                    <?php elseif ($key == 2): ?>
                                        <p class="bold text-info m-t-10">Доставка до 10 минути.</p>
                                    <?php endif; ?>
                                    <br/>

                                    <?php if ($key == 0): ?>
                                        <div style="display: none;">
                                            <a href="https://neterra.net/bg" target="_blank"><img src="<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/neterra_logo.png"/></a>
                                            <br/>
                                            <br/>
                                        </div>
                                    <?php endif; ?>

                                    <?php echo $plan['description']; ?>

                                    <?php if ($key == 2): ?>
                                        <br/>

                                        <a href="https://client.cloudware.bg/index.php?/cart/dedicated-servers/" target="_blank"><img src="<?php print site_url(); ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/cloudware.png"/></a>
                                    <?php endif; ?>

                                    <div class="text-center" style="margin-bottom: -63px; margin-top: 30px;">
                                        <?php if ($key == 2) {
                                            $checkout_url = 'https://client.cloudware.bg/index.php?/cart/dedicated-servers/';
                                        } else {
                                            $checkout_url = $current_url . '&plan=' . $plan['id'];
                                        } ?>

                                        <a href="<?php echo $checkout_url; ?>" class="btn btn-<?php echo $planColor; ?> btn-md">
                                            <?php if ($key == 0): ?>
                                                Започни безплатно
                                            <?php elseif ($key == 2): ?>
                                                Поръчай сега
                                            <?php else: ?>
                                                Поръчай <?php print $plan['name'] ?>
                                            <?php endif; ?>
                                        </a>
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