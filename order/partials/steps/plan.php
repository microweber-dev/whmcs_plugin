<?php
$plans = $controller->get_hosting_products();
//print_r($plans);
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
    <section class="section-62 section-blue p-t-90  p-b-90 fx-particles edit safe-mode nodrop" field="layout-skin-66-<?php print $params['id'] ?>" rel="module">
        <div class="container p-t-50 p-b-100">
            <div class="row">
                <div class="col-md-12 fx-deactivate allow-drop text-center">
                    <h3>Choose your Microweber.com plan </h3>
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
                                                <script language="javascript" src="<?php print $CONFIG['SystemURL']; ?>/feeds/productsinfo.php?pid=<?php print $plan['id'] ?>&get=price&billingcycle=monthly"></script>
                                                <?php if ($key == 0): ?>
                                                    <span class="period safe-element">14 days free trial</span>
                                                <?php else: ?>
                                                    <span class="period safe-element">per month, billed yearly</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <?php print $plan['description'] ?>

                                        <div class="description last">
                                            <a href="<?php echo $current_url ?>&plan=<?php print $plan['id'] ?>" class="btn btn-default btn-md m-t-20">Start <?php print $plan['name'] ?></a>
                                            <br/>
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>



                        <?php

                        /*







                                                <div class="col-md-6 col-lg-3">
                                                    <div class="plan">

                                                        <div class="heading">
                                                            <p class="safe-element title"><span class="icon-holder"><i class="mw-micon-solid-Sleeping"></i></span> Free Trial</p>

                                                            <div class="price">
                                                                <small class="safe-element">$</small>
                                                                <span class="sum safe-element">0</span>
                                                                <span class="period safe-element">14 days free trial</span>
                                                            </div>
                                                        </div>

                                                        <div class="description">
                                                            <span class="title">Best for Beginers</span>
                                                            <p class="info">Try to create your website with Microweber.com. We are giving you two weeks free trial to be inspaired and creative.</p>

                                                            <a href="<?php echo $current_url ?>&plan=trial" class="btn btn-default btn-md m-t-20">Strat Free trial</a>
                                                            <br/>
                                                            <br/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-3">
                                                    <div class="plan blue">

                                                        <div class="heading">
                                                            <p class="safe-element title"><span class="icon-holder"><i class="mw-micon-solid-Fashion"></i></span> Personal</p>

                                                            <div class="price">
                                                                <small class="safe-element">$</small>
                                                                <span class="sum safe-element">5</span>
                                                                <span class="period safe-element">per month, billed yearly</span>
                                                            </div>
                                                        </div>
                                                        <div class="description">
                                                            <span class="title">Best for Personal Use</span>
                                                            <p class="info">Boost your website with a custom domain name. Get access to high quality email and live chat support. </p>

                                                            <a href="<?php echo $current_url ?>&plan=personal" class="btn btn-default btn-md m-t-20">Strat Personal</a>
                                                        </div>

                                                        <div class="specifications">
                                                            <ul>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span>Free Domain for First Year</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="We are giving you free domain name for one year. Premium domains are included. The domain will be renued at its regular price."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span>E-mail & Live Chat Support</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="High quality support to help you get your website up and running and working how you want it."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span>Free Templates</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Access to a wide range of professional theme templates for your website so you can find the exact design you're looking for."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>SSL</strong> Security Included</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Own email accoutn connected with your domain."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>1</strong> E-mail Account</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Own email accoutn connected with your domain."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>5 GB</strong> Storage Space</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="With increased storage space you'll be able to upload more images, audio, and documents to your website."> info </i>
                                                                </li>
                                                                <li>&nbsp;</li>
                                                                <li>&nbsp;</li>
                                                                <li>&nbsp;</li>
                                                                <li>&nbsp;</li>
                                                                <li>&nbsp;</li>
                                                                <li>&nbsp;</li>
                                                            </ul>
                                                        </div>

                                                        <div class="description last">
                                                            <a href="<?php echo $current_url ?>&plan=personal" class="btn btn-default btn-md m-t-20">Strat Personal</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-3">
                                                    <div class="plan gold">

                                                        <div class="heading">
                                                            <p class="safe-element title"><span class="icon-holder"><i class="mw-micon-solid-Sunglasses-Smiley2"></i></span> Premium</p>

                                                            <div class="price">
                                                                <small class="safe-element">$</small>
                                                                <span class="sum safe-element">10</span>
                                                                <span class="period safe-element">per month, billed yearly</span>
                                                            </div>
                                                        </div>

                                                        <div class="description">
                                                            <span class="title">Best for Entrepreneurs</span>
                                                            <p class="info">Build a unique website with advanced design tools, CSS editing, lots of space for audio and video, and the ability to monetize your site with ads.</p>

                                                            <a href="<?php echo $current_url ?>&plan=premium" class="btn btn-default btn-md m-t-20">Strat Premium</a>
                                                        </div>

                                                        <div class="specifications">
                                                            <ul>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span>Free Domain for First Year</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="We are giving you free domain name for one year. Premium domains are included. The domain will be renued at its regular price."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span>E-mail & Live Chat Support</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="High quality support to help you get your website up and running and working how you want it."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>Unlimited</strong> Templates</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Access to a wide range of professional theme templates for your website so you can find the exact design you're looking for."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>SSL</strong> Security Included</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Own email accoutn connected with your domain."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>10</strong> E-mail Account</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Own email accoutn connected with your domain."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>15 GB</strong> Storage Space</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="With increased storage space you'll be able to upload more images, audio, and documents to your website."> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> Install Premium Modules</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> Fully Integrated E-commerce</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> Access to Marketing Tools</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>

                                                                <li>&nbsp;</li>

                                                                <li>&nbsp;</li>

                                                                <li>&nbsp;</li>


                                                            </ul>
                                                        </div>

                                                        <div class="description last">
                                                            <a href="<?php echo $current_url ?>&plan=premium" class="btn btn-default btn-md m-t-20">Strat Premium</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-3">
                                                    <div class="plan warn">

                                                        <div class="heading">
                                                            <p class="safe-element title"><span class="icon-holder"><i class="mw-micon-solid-Money-Smiley"></i></span> Business</p>

                                                            <div class="price">
                                                                <small class="safe-element">$</small>
                                                                <span class="sum safe-element">25</span><span class="period safe-element">per month, billed yearly</span>
                                                            </div>
                                                        </div>

                                                        <div class="description">
                                                            <span class="title">Best for Small Business</span>
                                                            <p class="info">Power your business website with unlimited premium and business theme templates, Google Analytics support, unlimited storage, and the ability to remove Microweber.com branding.</p>

                                                            <a href="#" class="btn btn-default btn-md m-t-20">Strat Business</a>
                                                        </div>

                                                        <div class="specifications">
                                                            <ul>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span>Free Domain for First Year</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="We are giving you free domain name for one year. Premium domains are included. The domain will be renued at its regular price."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span>E-mail & Live Chat Support</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="High quality support to help you get your website up and running and working how you want it."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>Unlimited</strong> Templates</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Access to a wide range of professional theme templates for your website so you can find the exact design you're looking for."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>SSL</strong> Security Included</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Own email accoutn connected with your domain."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>Unlimited</strong> E-mail Account</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="Own email accoutn connected with your domain."> info </i>
                                                                </li>
                                                                <li>
                                                                    <i class="material-icons">check</i> <span><strong>Unlimited</strong> Storage Space</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="With increased storage space you'll be able to upload more images, audio, and documents to your website."> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> <strong>Unlimited</strong> Premium Modules</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> Fully Integrated E-commerce</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> Access to Marketing Tools</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> Abandoned Carts</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> Coupon Codes</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>

                                                                <li>
                                                                    <i class="material-icons">check</i> Newsletter E-mail Campaigns</span>
                                                                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title=""> info </i>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="description last">
                                                            <a href="#" class="btn btn-default btn-md m-t-20">Strat Business</a>
                                                        </div>
                                                    </div>
                                                </div>*/

                        ?>

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