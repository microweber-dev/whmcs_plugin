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
    .tab-pane#hosting > .row{
        align-items: center;
        justify-content: center;
        justify-items: center;
        display: flex;
        flex-wrap: wrap;
    }
    @media screen and (max-width: 991px){
        .pricing-list-2 .specifications, .pricing-list-2 .description.last {
             display: block;
        }
        .tab-pane#hosting > .row > div{
           width: 100%;
            max-width: 500px;

        }
</style>

<div class="step-3">
    <section class="p-t-40  p-b-40 fx-particles">
        <div class="container p-t-50 p-b-100">
            <div class="row">
                <div class="col-md-12 fx-deactivate allow-drop text-center">
<!--                    <h3>Choose your --><?php //echo $controller->branding_get_company_name(); ?><!-- plan </h3>-->
                    <h1 style="font-size: 48px; font-weight: 700;"><?php print Lang::trans('MW_selectYourPlan') ?></h1>
                    <p><?php print Lang::trans('MW_takeAdvantageOfOurPremium') ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-63  p-t-0 p-b-0 fx-particles">
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

                                <div class="  <?php if ($is_free): ?> col-xs-12 product-plans-free-wrapper mt-5 <?php else : ?> col-lg-6 col-xl-4  <?php endif; ?> ">
                                    <div class="  <?php if ($is_free): ?> product-plans-free-wrapper <?php endif; ?>  plan <?php echo $planType; ?>" style="align-items: center; flex-wrap: wrap;" >
                                        <div class=" <?php if ($is_free): ?> pt-2 <?php endif; ?>  heading" style="text-align: center;">
                                            <div class="price">
                                                <h1 style="font-size: 24px; font-weight: 300; color: #2b2b2b;"><?php echo $plan['name']; ?></h1>
<!--                                                --><?php //echo $plan['description']; ?>
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
<!--                                                <p style="font-weight: bold; font-size: 36px; color: #2b2b2b;">--><?php //print Lang::trans('MW_free') ?><!--</p>-->
<!--                                                    <span class="period safe-element">--><?php //print Lang::trans('MW_14daysFreeTrial') ?><!--</span>-->

                                                <?php else: ?>
                                                    <p style="font-weight: bold; font-size: 36px; color: #2b2b2b;"><?php print $price; ?></p>


                                                    <span class="period safe-element"><?php print $billing_cycle; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="description" style="text-align: center;">
                                        <?php
                                        $desc = $plan['description'];

                                        if(isset($plan['features']) and  is_array($plan['features'])  and  !empty($plan['features'])){
                                            $desc = '<ul>';
                                             foreach ($plan['features'] as $featk=>$feat){
                                                $desc = $desc.'<li class="plans-whmc-li">'.$featk.' '.$feat.'</li>';
                                            }
                                            $desc .= '</ul>';
                                        }

                                       // $desc = str_replace('<div class="js-order-btn"></div>', '<a href="' . $current_url . '&plan=' . $plan['id'] . '" class="whmc-kbtn-2 btn-md m-t-20">Start ' . $plan['name'] . '</a>', $desc);
                                        print $desc;
                                        ?>
                                        </div>
                                        <?php if ($plan['id']): ?>
                                            <div class="description last">
                                                <form method="post" action="<?php echo $current_url ?>" class="clearfix" id="form_<?php print $plan['id'] ?>"  name="form_<?php print $plan['id'] ?>">
                                                    <input type="hidden" value="1" name="start_with_plan"/>
                                                    <input type="hidden" value="<?php print $plan['id'] ?>" name="plan_id"/>
                                                     <?php include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>
                                                    <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                                                    <button type="submit"   class="whmc-kbtn " style="width: 100%;" ><?php print Lang::trans('MW_orderNow') ?></button>
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

</div>

<?php include 'partials/footer.php'; ?>
