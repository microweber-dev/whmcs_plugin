<?php include 'partials/header.php'; ?>

<?php
$plans = $controller->get_hosting_products();
?>

<?php if ($plans) { ?>
    <?php foreach ($plans as $key => $plan) { ?>
        <?php
        if ($key == 0) {
            $planColor = 'primary';
        } elseif ($key == 1) {
            $planColor = 'default';
        } elseif ($key == 2) {
            $planColor = 'info';
            $planIcon = 'mw-micon-solid-Money-Smiley';
        } else {
            $planColor = 'primary';
        }
        ?>

        <?php if ($key == 0): ?>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>Можете да си направите сайт, он-лайн магазин или блог напълно безплатно с сайт билдъра на <?php echo $CONFIG['CompanyName']; ?>. <br/>Подаряваме ти и безплатен хостинг за него до 1000 mb дисково пространство, спонсорирано от Нетера.<br/><br/></p>
                            <p>Започни още сега с абсолютно безплатния ни план!</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-15 inverse">
                <div class="container align-self-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="img-holder-bg d-flex align-items-center justify-content-center" style="background-image: url('<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plans-1.png');">
                                <div class="text-left">
                                    <h2 class="text-<?php echo $planColor; ?>"><?php print $plan['name'] ?>!</h2>
                                    <h2>1 GB <span class="text-default">безплатно<br/>пространство</span> <br>и не ограничен <br/>трафик.</h2>
                                    <div class="m-t-50 support-by">
                                        <p>С подкрепата на: &nbsp; <a href="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/neterra_logo.png" alt=""></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 align-self-center">
                            <div class="info-holder text-left ">
                                <div class="align-self-center">
                                    <img src="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plans-up-1.png"/><br/><br/>
                                    <div class="box">
                                        <div class="thing"><img src="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plan-1.svg"/></div>
                                        <div class="price text-<?php echo $planColor; ?>">
                                            <span class="sum"><script language="javascript" src="<?php print $CONFIG['SystemURL']; ?>/feeds/productsinfo.php?pid=<?php print $plan['id'] ?>&get=price&billingcycle=monthly"></script></span> <span class="per"> / на месец</span>
                                        </div>
                                        <br/>
                                        <img src="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/neterra_logo.png"/>
                                        <br/>
                                        <br/>
                                        <!-- <h4>--><?php //print _lang('Повече от 50,000 инсталации из целия свят', 'template/microweber-whitelabel'); ?><!--</h4>-->

                                        <ul>
                                            <li><i class="fa fa-check"></i> <span>1 GB дисково пространство</span></li>
                                            <li><i class="fa fa-check"></i> <span>Суб-домейн (domain.microweber.bg)</span></li>
                                            <li><i class="fa fa-check"></i> <span>Неограничен трафик</span></li>
                                            <li><i class="fa fa-check"></i> <span>SLL сертификат за сигурност</span></li>
                                            <li><i class="fa fa-check"></i> <span>Без банери и реклами *</span></li>
                                        </ul>

                                        <p class="m-t-30">Ние не пускаме реклами в безплатния ви уебсайт. Единствено добавяме името на Microweber и Neterra във футръра на вашия уебсайт. Може да го премахнете с всеки платен план </p>

                                        <div class="text-center" style="margin-bottom: -63px; margin-top: 30px;">
                                            <a href="<?php echo $current_url ?>&plan=<?php print $plan['id'] ?>" class="btn btn-<?php echo $planColor; ?> btn-md">Започни <?php print $plan['name'] ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

            <section class="section-15 inverse">
                <div class="container align-self-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="img-holder-bg d-flex align-items-center justify-content-center" style="background-image: url('<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plans-2.png');">
                                <div class="text-left">
                                    <h2 class="text-<?php echo $planColor; ?>"><?php print $plan['name'] ?></h2>
                                    <h2>10 GB свободно<br/>
                                        пространство,<br/>
                                        собствейн<br/>
                                        домейн и имайл<br/></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 align-self-center">
                            <div class="info-holder text-left ">
                                <div class="align-self-center">
                                    <img src="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plans-up-2.png"/><br/><br/>
                                    <div class="box">
                                        <div class="thing"><img src="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plan-2.svg"/></div>
                                        <div class="price text-default">
                                            <span class="sum"><script language="javascript" src="<?php print $CONFIG['SystemURL']; ?>/feeds/productsinfo.php?pid=<?php print $plan['id'] ?>&get=price&billingcycle=monthly"></script></span> <span class="per"> / на месец</span>
                                        </div>
                                        <p class="bold text-<?php echo $planColor; ?> m-t-10">При едногодишен абонамент </p>

                                        <br/>
                                        <!-- <h4>--><?php //print _lang('Повече от 50,000 инсталации из целия свят', 'template/microweber-whitelabel'); ?><!--</h4>-->

                                        <ul>
                                            <li><i class="fa fa-check"></i> <span>10 GB дисково пространство</span></li>
                                            <li><i class="fa fa-check"></i> <span>5 пощенски кутии (имейл)</span></li>
                                            <li><i class="fa fa-check"></i> <span>При едногодишен абонамент </span></li>
                                            <li><i class="fa fa-check"></i> <span>Неограничен трафик</span></li>
                                            <li><i class="fa fa-check"></i> <span>SLL сертификат за сигурност</span></li>
                                            <li><i class="fa fa-check"></i> <span>FTP достъп</span></li>
                                            <li><i class="fa fa-check"></i> <span>Достъп до всички темплейти</span></li>
                                            <li><i class="fa fa-check"></i> <span>Достъп до всички модули</span></li>
                                            <li><i class="fa fa-check"></i> <span>Техническа поддръжка</span></li>
                                            <li><i class="fa fa-check"></i> <span>Собствени линкове във футъра</span></li>
                                        </ul>


                                        <div class="text-center" style="margin-bottom: -63px; margin-top: 30px;">
                                            <a href="<?php echo $current_url ?>&plan=<?php print $plan['id'] ?>" class="btn btn-<?php echo $planColor; ?> btn-md">Поръчай <?php print $plan['name'] ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

            <section class="section-15 inverse">
                <div class="container align-self-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="img-holder-bg d-flex align-items-center justify-content-center" style="background-image: url('<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plans-3.png');">
                                <div class="text-left">
                                    <h2 class="text-info"><?php print $plan['name'] ?></h2>
                                    <h2>Наеми си сървър, <br/>подходящо за <br/>онлайн търговци</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 align-self-center">
                            <div class="info-holder text-left ">
                                <div class="align-self-center">
                                    <img src="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plans-up-3.png"/><br/><br/>
                                    <div class="box">
                                        <div class="thing"><img src="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/plan-3.svg"/></div>
                                        <div class="price text-<?php echo $planColor; ?>">
                                            <span class="sum"><script language="javascript" src="<?php print $CONFIG['SystemURL']; ?>/feeds/productsinfo.php?pid=<?php print $plan['id'] ?>&get=price&billingcycle=monthly"></script></span> <span class="per">/ на месец</span>
                                        </div>
                                        <p class="bold text-<?php echo $planColor; ?> m-t-10">Доставка до 10 минути.</p>
                                        <br/>

                                        <!-- <h4>--><?php //print _lang('Повече от 50,000 инсталации из целия свят', 'template/microweber-whitelabel'); ?><!--</h4>-->

                                        <ul>
                                            <li><i class="fa fa-check"></i> <span>Собствен физически сървър</span></li>
                                            <li><i class="fa fa-check"></i> <span>Неограничен трафик</span></li>
                                            <li><i class="fa fa-check"></i> <span>24/7 поддръжка</span></li>
                                        </ul>

                                        <br/>


                                        <a href="https://client.cloudware.bg/index.php?/cart/dedicated-servers/" target="_blank"><img src="<?php print $CONFIG['SystemURL']; ?>/modules/addons/microweber_addon/order/templates/microweber.bg/plans/assets/img/cloudware.png"/></a>
                                        <br/>
                                        <br/>
                                        <br/>

                                        <div class="text-center" style="margin-bottom: -63px; margin-top: 30px;">
                                            <a href="<?php echo $current_url ?>&plan=<?php print $plan['id'] ?>" class="btn btn-<?php echo $planColor; ?> btn-md">Поръчай <?php print $plan['name'] ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php } ?>
<?php } ?>

<?php include 'partials/footer.php'; ?>