<?php include 'partials/header.php'; ?>

<?php
$controller = new MicroweberAddonApiController();



$plans = $controller->get_hosting_products($params);


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
                    <h3>Choose your <?php echo $controller->branding_get_company_name(); ?> plan </h3>
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
                                            <div class="description">
                                            <button type="submit"   class="whmc-kbtn-2 btn-md m-t-20" formtarget="form_<?php print $plan['id'] ?>" form="form_<?php print $plan['id'] ?>" >Start</button>
                                            </div>

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



                                       // $desc = str_replace('<div class="js-order-btn"></div>', '<a href="' . $current_url . '&plan=' . $plan['id'] . '" class="whmc-kbtn-2 btn-md m-t-20">Start ' . $plan['name'] . '</a>', $desc);

                                        print  $desc;



                                        ?>




                                        </div>
                                        <?php if ($plan['id']): ?>
                                            <div class="description last">

                                                <form method="post" action="<?php echo $current_url ?>" class="clearfix" id="form_<?php print $plan['id'] ?>"  name="form_<?php print $plan['id'] ?>">
                                                    <input type="hidden" value="1" name="start_with_plan"/>
                                                    <input type="hidden" value="<?php print $plan['id'] ?>" name="plan_id"/>
                                                     <?php include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>
                                                    <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                                                    <button type="submit"   class="whmc-kbtn-2 btn-md m-t-20" >Start</button>
                                                </form>



<!--                                                <a href="--><?php //echo $current_url ?><!--&plan=--><?php //print $plan['id'] ?><!--" class="whmc-kbtn-2 btn-md m-t-20">Start --><?php //print $plan['name'] ?><!--</a>-->
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



<div class="section" id="prices-section">
    <link rel="stylesheet" href="https://microweber.com/api/getTemplateStyleMW">

    <?php

    $defaultItemsToView = 7;

    $plans = Array(
        Array(
            "name" => 'MICROWEBER FREE',
            "startWith" => 'Start with Free',
            "id" => 'free',
            "description" => 'Start your Microweber.com website. Limited functionality, storage and visits.',
            "price" => 0,
            "url" => "https://members.microweber.com/modules/addons/microweber_addon/order/?plan=19",
            "kbtnType" => "kbtn-outline-dark",
        ),
        Array(
            "name" => 'MICROWEBER PRO',
            "startWith" => 'Start with PRO',
            "id" => 'pro',
            "description" => 'The full power of modern and fast Microweber hosting made easy.',
            "price" => 15,
            "url" => "https://members.microweber.com/modules/addons/microweber_addon/order/?plan=11",
            "kbtnType" => "kbtn-primary",
        ),
    );


    $features = Array(
        Array(
            "feature" => 'Custom Domain Name',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Custom domain name is not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Free for one year",
                    "mobile" => "Custom domain name for one year",
                    "icon" => "yes"
                ),
            )
        ),
        Array(
            "feature" => 'Premium Templates',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Premium Templates are not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Premium Templates",
                    "icon" => "yes"
                ),
            )
        ),
        Array(
            "feature" => 'Premium Modules',
            "description" => 'Adding forms, create backup and more. ',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Premium Modules are not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Premium Modules",
                    "icon" => "yes"
                ),
            )
        ),
        Array(
            "feature" => 'Premium Support',
            "description" => 'Build your website with our help.',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Premium Support is not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Premium Support",
                    "icon" => "yes"
                ),
            )
        ),
        Array(
            "feature" => 'Online Store',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Online Store is not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Online Store",
                    "icon" => "yes"
                ),
            )
        ),
        Array(
            "feature" => 'Storage',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "500MB",
                    "mobile" => "500MB of storage",
                    "icon" => "none"
                ),
                "pro" => Array(
                    "desktop" => "10GB",
                    "mobile" => "10GB of storage",
                    "icon" => "none"
                ),
            )
        ),
        Array(
            "feature" => 'Remove Ads',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Ads will be shown",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "No Ads",
                    "icon" => "yes"
                ),
            )
        ),
        Array(
            "feature" => 'Collect payments',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Collect payments is not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Collect payments",
                    "icon" => "yes"
                ),
            )
        ),

        Array(
            "feature" => 'Shipping providers integration',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Shipping providers are not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Shipping providers integration",
                    "icon" => "yes"
                ),
            )
        ),

        Array(
            "feature" => 'Unlimited email support',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Email support is not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Unlimited email support",
                    "icon" => "yes"
                ),
            )
        ),

        Array(
            "feature" => 'Live chat support',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Live chat support is not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Live chat support",
                    "icon" => "yes"
                ),
            )
        ),

        Array(
            "feature" => 'Own website email',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Website email is not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Own website email ",
                    "icon" => "yes"
                ),
            )
        ),

        Array(
            "feature" => 'Site backups and one-click restore',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Site backups and one-click restore are not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Site backups and one-click restore are included",
                    "icon" => "yes"
                ),
            )
        ),

        Array(
            "feature" => 'SFTP, Database access',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "SFTP, Database access are not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "SFTP, Database access are included",
                    "icon" => "yes"
                ),
            )
        ),

        Array(
            "feature" => 'SSL Certificate',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Included",
                    "mobile" => "SSL Certificate is included",
                    "icon" => "yes"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "SSL Certificate is included",
                    "icon" => "yes"
                ),
            )
        ),

        Array(
            "feature" => 'Sub-domains',
            "description" => '',
            "plans" => Array(
                "free" => Array(
                    "desktop" => "Not included",
                    "mobile" => "Sub-domains are not included",
                    "icon" => "no"
                ),
                "pro" => Array(
                    "desktop" => "Included",
                    "mobile" => "Sub-domains are included",
                    "icon" => "yes"
                ),
            )
        ),
    );





    ?>



        <div class="section-wrapper ">

            <div id="prices-section-title">
                <h4 class="title">Microweber Pro plan comes with a 14-day money back guarantee</h4>
            </div>

            <div class="prices">
                <div>
                    <div class="price-header">

                    </div>
                    <ul>
                        <?php


                        for ($i=0; $i < $defaultItemsToView; $i++) {
                            $feat = $features[$i];
                            ?>
                            <li class="price-feature-info"><strong><?php print $feat['feature']; ?></strong><small><?php print $feat['description']; ?></small></li>
                        <?php } ?>
                        <li class="price-feature-button-item">

                        </li>
                    </ul>
                    <ul>
                        <?php

                        for ($i = $defaultItemsToView; $i < sizeof($features); $i++) {
                            $feat = $features[$i];
                            ?>
                            <li class="price-feature-info"><strong><?php print $feat['feature']; ?></strong><small><?php print $feat['description']; ?></small></li>
                        <?php } ?>

                        <li class="price-feature-button-item">

                        </li>
                    </ul>
                </div>

                <?php
                $count = 0;
                foreach ($plans as $plan) {
                    $count++;
                    ?>

                    <div>
                        <div class="price-header">
                            <div class="price-header-top">
                                <h4 class="title"><?php print $plan['name']; ?></h4>
                                <p><?php print $plan['description']; ?></p>
                            </div>
                            <div class="price-header-bottom">
                                <span class="prices-price"><small>&euro;</small><?php print $plan['price']; ?></span>
                                <small class="price-desc">per month, billed yearly</small>
                                <a href="<?php print $plan['url']; ?>" class="kbtn <?php print $plan['kbtnType']; ?>"><?php print $plan['startWith']; ?></a>
                            </div>
                        </div>
                        <ul>
                            <?php

                            for ($i=0; $i<$defaultItemsToView; $i++) {
                                $feat = $features[$i];
                                ?>
                                <li class="price-feature-icon-<?php print $feat['plans'][$plan['id']]['icon']; ?>"><span class="pfni-desktop"><?php print $feat['plans'][$plan['id']]['desktop']; ?></span><span class="pfni-mobile"><?php print $feat['plans'][$plan['id']]['mobile']; ?></span></li>
                            <?php } ?>
                            <li class="price-feature-button-item">
                                <?php if($count === 1){ ?>
                                    <span class="price-feature-button">Show full plan comparison</span>
                                <?php } ?>
                            </li>
                        </ul>
                        <ul>
                            <?php

                            for ($i = $defaultItemsToView; $i < sizeof($features); $i++) {
                                $feat = $features[$i];
                                ?>
                                <li class="price-feature-icon-<?php print $feat['plans'][$plan['id']]['icon']; ?>"><span class="pfni-desktop"><?php print $feat['plans'][$plan['id']]['desktop']; ?></span><span class="pfni-mobile"><?php print $feat['plans'][$plan['id']]['mobile']; ?></span></li>
                            <?php } ?>
                            <li class="price-feature-button-item">
                                <?php if($count === 1){ ?>
                                    <span class="price-feature-button">Hide full plan comparison</span>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

            </div>
        </div>


</div>



<?php include 'partials/footer.php'; ?>
