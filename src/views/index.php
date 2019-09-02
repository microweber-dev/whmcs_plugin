<?php
/** @var \MicroweberAddon\Manager $manager */
//$manager = new \MicroweberAddon\Manager;

$templates = $manager->get_templates();
$settings = $manager->get_settings();
$settings_render = $manager->config->get_settings_for_render();
$hosting = $manager->hosting->get_hosting_products();
$enabled_templates = $manager->hosting->get_enabled_templates('return_mode=simple');

//dd($enabled_templates);
?>
<style>
    .microweber-addon SELECT, INPUT[type="text"] {
        width: 160px;
        box-sizing: border-box;
    }

    .microweber-addon SECTION {
        padding: 8px;
        background-color: #f0f0f0;
        overflow: auto;
    }

    .microweber-addon SECTION > DIV {
        float: left;
        padding: 4px;
    }

    .microweber-addon SECTION > DIV + DIV {
        width: 40px;
        text-align: center;
    }
</style>

<style>
    .microweber-addon select option[value="aaa"] {
        background-color: powderblue;
    }

    .microweber-addon select option[value="opel"] {
        background-color: red;
    }

    .microweber-addon select option[value="audi"] {
        background-color: green;
    }

    .microweber-addon .template-bg-img {
        display: inline-block;
        height: 40px;
        width: 40px;
        background-repeat: no-repeat;
        background-size: contain;
    }

</style>

<script>
    $(document).ready(function () {

        $("#btnLeft").click(function () {
            var selectedItem = $("#rightValues option:selected");
            $("#leftValues").append(selectedItem);
        });

        $("#btnRight").click(function () {
            var selectedItem = $("#leftValues option:selected");
            $("#rightValues").append(selectedItem);
        });

        $("#rightValues").change(function () {
            var selectedItem = $("#rightValues option:selected");
            $("#txtRight").val(selectedItem.text());
        });
    });

</script>


<div class="microweber-addon">


    <?php
    //var_dump($hosting)

    ?>

    <style>
        .project {
            margin-bottom: 30px;
            vertical-align: top;
            margin-right: 30px;
            float: left;
            cursor: pointer;
            width: 100%;
        }

        .project figure {
            position: relative;
            display: inline-block;
            height: 200px;
            overflow: hidden;
        }

        .project figure img {
            width: 100%;
        }

        .btn-warning bnt-action {
            margin: 0% 0% auto;
        }

        figcaption .project-details {
            display: block;
            font-size: 16px;
            /*line-height: 33px;*/
            color: #000;
            /*height: 27px;*/
            width: 100%;
            margin: 0 auto 5px auto;
            /*margin-bottom: 5px;*/
            overflow: hidden;
        }

        .project figure:hover figcaption {
            background: #d81e05;
        }

        .project figure:hover figcaption .project-details {
            color: #fff;
        }

        figcaption .project-price {
            position: absolute;
            right: 15px;
            top: 12px;
            font-size: 22px;
            text-align: right;
            margin-top: 8px;
            letter-spacing: -1px;
            -webkit-font-smoothing: antialiased;
        }

        figcaption .project-creator {
            font-size: 13px;
            color: #545454;
            display: block;
        }

        figcaption .project-creator {
            font-size: 13px;
            color: #545454;
            display: block;
        }

        .project .actions button {
            padding: 13px 20px;
            font-size: 16px;
            top: 32%;
            position: absolute;
            left: 50%;
            width: 90%;
            margin-left: -45%;
            line-height: 18px;
            letter-spacing: 1px;
        }

        .project figure:hover .actions {
            background-color: rgba(29, 29, 29, 1);
            font-size: 2em;
            font-weight: 700;
        }

        .project .actions {
            display: block;
            position: relative;
            z-index: 1;
            opacity: 1;
            background-color: rgba(29, 29, 29, .9);
            -ms-transition: all .2s ease-out;
            -webkit-transition: all .2s ease-out;
            -moz-transition: all .2s ease-out;
            -o-transition: all .2s ease-out;
            transition: all .2s ease-out;
            color: white;
            font-size: 14px;
            padding: 2px 10px;
            font-weight: bold;
            text-align: center;
        }


    </style>

    <div class="container">
        <form method="post">
            <input type="hidden" name="function" value="save"/>

            <h1 style="font-weight: bold; margin-bottom: 10px;">Select Hosting plans</h1>
            <p>Select the hosting plans you want to install by default Microweber CMS.</p>

            <hr class="divider-title">

            <div class="row">
                <?php foreach ($hosting as $plan) : ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input <?php if (isset($plan['has_website_builder']) and $plan['has_website_builder']) { ?> checked  <?php } ?> name="selected_hosting_plans[]" type="checkbox" value="<?php print $plan['id'] ?>"><?php print $plan['name'] ?></label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <br/>
            <br/>
            <br/>

            <h1 style="font-weight: bold; margin-bottom: 10px;">Select Templates</h1>
            <p>Select templates which will be allowable to install by your clients. This templates are available only with <a href="https://microweber.org/modules/mw-internal/white_label" target="_blank">White Label Hosting Pro License</a>.</p>

            <hr class="divider-title">
            <div class="row">
                <div class="col-xs-12">
                    <script>
                        $(document).ready(function () {
                            $('.js-select-all-templates').on('click', function () {
                                $('.js-template').each(function () {
                                    $(this).find('input').prop("checked", true);
                                })
                            })
                            $('.js-unselect-all-templates').on('click', function () {
                                $('.js-template').each(function () {
                                    $(this).find('input').prop("checked", false);
                                })
                            })
                        })
                    </script>
                    <div class="pull-right" style="height: 50px;">
                        <button type="button" class="js-select-all-templates btn btn-sm">Select all</button>
                        <button type="button" class="js-unselect-all-templates btn btn-sm">Unselect all</button>
                    </div>
                </div>
                <?php foreach ($templates as $template) : ?>
                    <?php
                    $item = $template['latest_version'];
                    $screenshot = '';
                    if (isset($item['extra']) and isset($item['extra']['_meta']) and isset($item['extra']['_meta']['screenshot'])) {
                        $screenshot = $item['extra']['_meta']['screenshot'];
                    }
                    ?>

                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-4 js-template">
                        <div class="project">
                            <figure class="img-responsive">
                                <img src="<?php print $screenshot ?>">
                            </figure>
                            <span class="actions">
                                 <span class="project-details">
                                 <div class="checkbox">
                                   <label><input <?php if (in_array($item['target-dir'], $enabled_templates)) { ?> checked  <?php } ?> type="checkbox" name="selected_templates[]" value="<?php print $item['target-dir'] ?>"> <strong><?php print $item['description'] ?></strong></label>
                                  </div>
                                </span>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


            <button type="submit" class="btn btn-success">Save changes</button>
        </form>
    </div>


    <!--    <pre>-->
    <?php // print_r($settings_render) ?>
    <?php //print_r($settings) ?>
    <?php // print_r($templates) ?>
    <?php // print_r($params) ?>
    <?php //print_r($enabled_templates) ?>
    <!--   </pre>-->

    <?php //include_once "embed_codes.php"; ?>

</div>







