<?php
/** @var \MicroweberAddon\Manager $manager */
//$manager = new \MicroweberAddon\Manager;

$templates = $manager->get_templates();
$settings = $manager->get_settings();
$settings_render = $manager->config->get_settings_for_render();
$hosting = $manager->hosting->get_hosting_products();
$enabled_templates = $manager->hosting->get_enabled_templates('return_mode=simple');


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

    <form method="post">
        <input type="hidden" name="function" value="save"/>


        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <h1>Select hosting plans to offer website builder</h1>

            <?php foreach ($hosting as $plan) : ?>

                <div class="form-group">

                    <div class="checkbox">
                        <label><input <?php if (isset($plan['has_website_builder']) and $plan['has_website_builder']) { ?> checked  <?php } ?>
                                    name="selected_hosting_plans[]" type="checkbox"
                                    value="<?php print $plan['id'] ?>"><?php print $plan['name'] ?>
                        </label>
                    </div>

                </div>
            <?php endforeach; ?>


        </div>


        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <h1>Select templates</h1>


            <?php foreach ($templates as $template) : ?>
                <?php

                $item = $template['latest_version'];
                $screenshot = '';
                if (isset($item['extra']) and isset($item['extra']['_meta']) and isset($item['extra']['_meta']['screenshot'])) {
                    $screenshot = $item['extra']['_meta']['screenshot'];
                }


                ?>
                <div class="form-group">

                    <div class="checkbox">
                        <label>
                            <div class="template-bg-img"
                                 style=" background-image: url('<?php print $screenshot ?>');"></div>

                            <input <?php if (in_array($item['target-dir'], $enabled_templates)) { ?> checked  <?php } ?>
                                    type="checkbox" name="selected_templates[]"
                                    value="<?php print $item['target-dir'] ?>"><?php print $item['description'] ?>
                        </label>
                    </div>

                </div>
            <?php endforeach; ?>


        </div>


        <button type="submit">Save</button>

    </form>


    hi


    <pre>
        <?php // print_r($settings_render) ?>
        <?php //print_r($settings) ?>
        <?php // print_r($templates) ?>
        <?php // print_r($params) ?>
        <?php print_r($enabled_templates) ?>
   </pre>



    <?php include_once "embed_codes.php"; ?>

</div>







