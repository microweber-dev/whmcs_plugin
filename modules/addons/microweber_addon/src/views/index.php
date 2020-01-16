<?php
/** @var \MicroweberAddon\Manager $manager */
//$manager = new \MicroweberAddon\Manager;

$templates = $manager->get_templates();
$settings = $manager->get_settings();
$settings_render = $manager->config->get_settings_for_render();
$hosting = $manager->hosting->get_hosting_products();
$enabled_templates = $manager->hosting->get_enabled_templates('return_mode=simple');
?>
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

    function openTemplateSettings(template_id) {
        $('.js-template-settings-' + template_id).toggle();
    }
</script>

<?php include_once "index_css.php"; ?>

<div class="microweber-addon">

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
                <?php $i=0; foreach ($templates as $template) : ?>
                    <?php

                    $item = $template['latest_version'];
                    $screenshot = '';
                    if (isset($item['extra']) and isset($item['extra']['_meta']) and isset($item['extra']['_meta']['screenshot'])) {
                        $screenshot = $item['extra']['_meta']['screenshot'];
                    }

                    $get_template = get_template_by_git_package_name($item['name']);
                    if (!$get_template) {
                        $get_template = insert_template_by_git_package_name($item['name']);
                    }

                    if (!$get_template->preview_sort) {
                        $get_template->preview_sort =  $i;
                    }
                    ?>

                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-4 js-template">
                        <div class="project">
                            <figure class="img-responsive">
                                <img src="<?php echo $screenshot ?>">
                            </figure>
                            <span class="actions" style="height: 45px;">
                                 <span class="project-details">
                                 <div class="checkbox">
                                   <label style="float:left;">
                                       <input <?php if (in_array($item['target-dir'], $enabled_templates)) { ?> checked  <?php } ?> type="checkbox" name="selected_templates[]" value="<?php print $item['target-dir'] ?>">
                                       <strong><?php echo $item['description']; ?></strong>
                                   </label>
                                     <b onclick="openTemplateSettings(<?php echo $get_template->id; ?>);" style="float:right;">Settings</b>
                                  </div>
                                </span>
                            </span>
                            <div style="margin-top:30px; display: none;" class="js-template-settings-<?php echo $get_template->id; ?>">
                                Template name:
                                <input type="text" class="form-control" style="width: 100%" name="templates_settings[<?php echo $get_template->id; ?>][preview_name]" value="<?php echo $get_template->preview_name; ?>" />
                                <br />
                                Template demo:
                                <input type="text" class="form-control" style="width: 100%" name="templates_settings[<?php echo $get_template->id; ?>][demo_url]" value="<?php echo $get_template->demo_url; ?>" />
                                <br />
                                Template sort:
                                <input type="text" class="form-control" style="width: 100%" name="templates_settings[<?php echo $get_template->id; ?>][preview_sort]" value="<?php echo $get_template->preview_sort; ?>" />
                                <br />
                                <br />
                                <input type="hidden" name="templates_settings[<?php echo $get_template->id; ?>][homepage_url]" value="<?php echo $item['homepage']; ?>" />
                                <input type="hidden" name="templates_settings[<?php echo $get_template->id; ?>][target_dir]" value="<?php echo $item['target-dir']; ?>" />
                                <input type="hidden" name="templates_settings[<?php echo $get_template->id; ?>][git_package_name]" value="<?php echo $item['name']; ?>" />
                                <input type="hidden" name="templates_settings[<?php echo $get_template->id; ?>][screenshot_url]" value="<?php echo $screenshot ?>" />
                                <input type="hidden" name="templates_settings[<?php echo $get_template->id; ?>][name]" value="<?php echo $item['description']; ?>" />
                                <input type="submit" class="btn btn-success btn-block" value="Save settings" />
                            </div>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>


            <button type="submit" class="btn btn-success">Save changes</button>
        </form>


        <div class="well" style="margin-top:50px;">
            <p>You have <b><?php echo $manager->report->getTotalClientProducts(); ?> </b> microweber active installations.</p>
        </div>

        <?php include_once "embed_codes.php"; ?>

    </div>
    <!--    <pre>-->
    <?php // print_r($settings_render) ?>
    <?php //print_r($settings) ?>
    <?php // print_r($templates) ?>
    <?php // print_r($params) ?>
    <?php //print_r($enabled_templates) ?>
    <!--   </pre>-->
</div>