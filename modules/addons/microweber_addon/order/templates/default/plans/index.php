<?php include 'partials/header.php'; ?>

<?php
$controller = new MicroweberAddonApiController();

$plans = $controller->get_hosting_products();
// print_r($plans);
?>

<style>
    .pricing-list-2 .specifications {
        margin-top: 0;
    }

    .pricing-list-2 .plan .description p.info {
        height: 140px;
    }
</style>

<div class="step-3">
    <section class="section-62 section-blue p-t-90  p-b-90 fx-particles">
        <div class="container p-t-50 p-b-100">
            <div class="row">
                <div class="col-md-12 fx-deactivate allow-drop text-center">
                    <h3>Choose your <?php echo $CONFIG['CompanyName']; ?> plan </h3>
                    <p>We are giving you 14 days free trail, no credit card required <br/> before you make purchases.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-63 section-silver p-t-0 p-b-0 fx-particles">
        <div class="container p-t-50 p-b-50 pricing-holder">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="hosting">
                    <div class="row pricing-list-2">
                        <?php if ($plans) { ?>
                            <?php foreach ($plans as $key => $plan) { ?>
                                <?php
                                if ($key == 1) {
                                    $planType = 'gold';
                                    $planIcon = 'mw-micon-solid-Fashion';
                                } elseif ($key == 2) {
                                    $planType = 'blue';
                                    $planIcon = 'mw-micon-solid-Sunglasses-Smiley2';
                                } elseif ($key == 3) {
                                    $planType = 'warn';
                                    $planIcon = 'mw-micon-solid-Money-Smiley';
                                } else {
                                    $planType = '';
                                    $planIcon = 'mw-micon-solid-Sleeping';
                                }
                                ?>
                                <div class="col-md-6 col-lg-3">
                                    <div class="plan <?php echo $planType; ?>">

                                        <div class="heading">
                                            <p class="safe-element title"><span class="icon-holder"><i class="<?php echo $planIcon; ?>"></i></span> <?php print $plan['name'] ?></p>
                                            <div class="price">
<!--                                                <script language="javascript" src="--><?php //print site_url(); ?><!--feeds/productsinfo.php?pid=--><?php //print $plan['id'] ?><!--&get=price&billingcycle=monthly"></script>-->

                                                <?php
                                                $price = false;
                                                $billing_cycle = false;
                                                $is_free = false;

                                                //var_dump($plan ['pricing_data']);
                                                    if(isset($plan['pricing_data']) and isset($plan['pricing_data']['price'])){
                                                        $price = $plan['pricing_data']['price'];
                                                    }
                                                    if(isset($plan['pricing_data']) and isset($plan['pricing_data']['billing_cycle'])){
                                                        $billing_cycle = $plan['pricing_data']['billing_cycle'];
                                                    }
                                                    if(isset($plan['pricing_data']) and isset($plan['pricing_data']['is_free'])){
                                                        $is_free = $plan['pricing_data']['is_free'];
                                                    }

                                                ?>



                                                <?php if ($is_free): ?>
                                                Free
                                                    <span class="period safe-element">14 days free trial</span>
                                                <?php else: ?>
                                                    <?php print $price; ?>
                                                    <span class="period safe-element"><?php print $billing_cycle; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="description">
                                        <?php
                                        $desc = $plan['description'];
                                        if(isset($plan['features'])){
                                            $desc = '<ul>';
                                             foreach ($plan['features'] as $featk=>$feat){
                                                $desc = $desc.'<li><b>'.$featk.'</b> '.$feat.'</li>';
                                            }
                                            $desc .= '</ul>';
                                        }



                                       // $desc = str_replace('<div class="js-order-btn"></div>', '<a href="' . $current_url . '&plan=' . $plan['id'] . '" class="btn btn-default btn-md m-t-20">Start ' . $plan['name'] . '</a>', $desc);

                                        print  $desc;



                                        ?>




                                        </div>
                                        <?php if ($plan['id']): ?>
                                            <div class="description last">

                                                <form method="post" action="<?php echo $current_url ?>" class="clearfix">
                                                    <input type="hidden" value="1" name="start_with_plan"/>
                                                    <input type="hidden" value="<?php print $plan['id'] ?>" name="plan_id"/>

                                                    <?php include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>
                                                    <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                                                    <button type="submit"   class="btn btn-default btn-md m-t-20" >Start</button>
                                                </form>



<!--                                                <a href="--><?php //echo $current_url ?><!--&plan=--><?php //print $plan['id'] ?><!--" class="btn btn-default btn-md m-t-20">Start --><?php //print $plan['name'] ?><!--</a>-->
                                            </div>
                                        <?php endif; ?>





                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section-67 section-white p-t-0 p-b-0 fx-particles">
        <div class="container p-t-50 p-b-50 ">
            <div class="row m-b-70">
                <div class="col-xs-12 text-center">
                    <h3>What all plans include</h3>
                    <p>What your free website builder have?</p>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row specs-list">
                <div class="col-sm-6 col-md-3 cloneable">
                    <div class="title"><i class="material-icons safe-element">mouse</i> <span class="safe-element">Drag and Drop</span></div>
                    <div class="specifications">
                        <ul>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Drag and drop expirience</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Live Edit Text</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Real-time User Statistics</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Template Layouts</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">WYSIWYG Editor</span></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 cloneable">
                    <div class="title"><i class="material-icons safe-element">shopping_cart</i> <span class="safe-element">E-commerce</span></div>
                    <div class="specifications">
                        <ul>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Full E-commece solution</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Adding products</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Set Currencies</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Custom fields</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Managing orders</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Managing customers</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Track orders</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Set shipping cost</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Set Taxes</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Invoices</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Payment providers </span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">integrations</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Automatic e-mail order </span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Notification</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Abonded cart</span></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 cloneable">
                    <div class="title"><i class="material-icons safe-element">star</i> <span class="safe-element">Website Builder</span></div>
                    <div class="specifications">
                        <ul>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Adding pages</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Adding categories and subcategories</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Managing Menus</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Search</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Adding buttons and links</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Uploading images</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Managing Galleries</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Uploading Videos</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Automated Update System</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Login & Register</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Website Language Setup</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Database Backup & Restore</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">SEO Settings</span></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 cloneable">
                    <div class="title"><i class="material-icons safe-element">question_answer</i> <span class="safe-element">Blog Platform</span></div>
                    <div class="specifications">
                        <ul>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Real time Text writing</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Managing comments</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Social Sharing</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Quick E-mail reader</span></li>
                            <li class="cloneable"><i class="material-icons safe-element">check</i> <span class="safe-element">Contact forms</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'partials/footer.php'; ?>