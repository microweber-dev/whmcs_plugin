<?php
/** @var \MicroweberAddon\Manager $manager */
//$manager = new \MicroweberAddon\Manager;

$templates = $manager->get_templates();
$settings = $manager->get_settings();
$settings_render = $manager->config->get_settings_for_render();
$hosting = $manager->hosting->get_hosting_products();
$enabled_templates = $manager->hosting->get_enabled_templates('return_mode=simple');
?>
<script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
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


        // make sortable templates
        var $sortableList = $(".js-templates");

        var listTemplateElements = '';
        var sortEventHandler = function (event, ui) {
            listTemplateElements = $sortableList.children();
            for (let i = 0; i < listTemplateElements.length; i++) {
                var currentTemplate = listTemplateElements[i];
                var currentTemplateId = $(currentTemplate).attr('data-template-id');
                $('.js-template-preview-sort-' + currentTemplateId).val(i);
                // console.log(currentTemplateId);

            }
        };
        $sortableList.sortable({
            stop: sortEventHandler
        });
        $sortableList.on("sortchange", sortEventHandler);

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
                                <label><input <?php if (isset($plan['has_website_builder']) and $plan['has_website_builder']) { ?> checked  <?php } ?>
                                            name="selected_hosting_plans[]" type="checkbox"
                                            value="<?php print $plan['id'] ?>"><?php print $plan['name'] ?></label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <br/>
            <br/>
            <br/>

            <h1 style="font-weight: bold; margin-bottom: 10px;">Select Templates</h1>
            <p>Select templates which will be allowable to install by your clients. This templates are available only
                with <a href="https://microweber.org/modules/mw-internal/white_label" target="_blank">White Label
                    Hosting Pro License</a>.</p>

            <hr class="divider-title">
            <div class="row">
                <div class="col-xs-12">
                    <script>
                        $(document).ready(function () {
                            $('.js-select-all-templates').on('click', function () {
                                $('.js-template').each(function () {
                                    $(this).find('.js-select-template-item-checkbox').prop("checked", true);
                                })
                            })
                            $('.js-unselect-all-templates').on('click', function () {
                                $('.js-template').each(function () {
                                    $(this).find('.js-select-template-item-checkbox').prop("checked", false);
                                })
                            })



                            // $('.js-templates .form-control').off("click");

                        })
                    </script>
                    <div class="pull-right" style="height: 50px;">
                        <button type="button" class="btn btn-sm" onclick="$('.js-show-all-templates').toggle();">Show all settings</button>
                        <button type="button" class="js-select-all-templates btn btn-sm">Select all</button>
                        <button type="button" class="js-unselect-all-templates btn btn-sm">Unselect all</button>
                    </div>

                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
                <div class="js-templates">
                    <?php $i = 0;
                    foreach ($templates as $template) : ?>
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
                            $get_template->preview_sort = $i;
                        }


                        $preview_url = 'http://microweber.com';
                        if (isset($template['latest_version']) AND isset($template['latest_version']['extra']) AND isset($template['latest_version']['extra']['preview_url'])) {
                            $preview_url = $template['latest_version']['extra']['preview_url'];
                            $preview_url = str_replace('http://', 'https://', $preview_url);
                        }
                        if (!$get_template->preview_url || empty($get_template->preview_url)) {
                            $get_template->preview_url = $preview_url;
                        }
                        if (!$get_template->preview_name || empty($get_template->preview_name)) {
                            $get_template->preview_name = $item['description'];
                        }

                        if (empty($get_template->screenshot_url)) {
                            $get_template->screenshot_url = $screenshot;
                        }

                        ?>

                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-4 js-template"
                             data-template-id="<?php echo $get_template->id; ?>">
                            <div class="project">
                                <figure class="img-responsive ">
                                    <img src="<?php echo $get_template->screenshot_url ?>" <?php if (in_array($item['target-dir'], $enabled_templates)): ?> <?php  else: ?> style="opacity:0.3" <?php endif; ?>>
                                </figure>
                                <span class="actions" style="height: 45px;">
                                 <span class="project-details">
                                 <div class="checkbox">
                                   <label style="float:left;">
                                       <input <?php if (in_array($item['target-dir'], $enabled_templates)) { ?> checked  <?php } ?>
                                               type="checkbox" class="js-select-template-item-checkbox" name="selected_templates[]"
                                               value="<?php print $item['target-dir'] ?>">
                                       <strong><?php echo $item['description']; ?></strong>
                                   </label>
                                     <button class="btn btn-sm" type="button" onclick="openTemplateSettings(<?php echo $get_template->id; ?>);"
                                        style="position:sticky;float:right;color:#000;padding:2px;font-size:12px;width: 130px">Settings</button>
                                  </div>
                                </span>
                            </span>
                                <div style="margin-top:30px; display: none;"
                                     class="js-show-all-templates js-template-settings-<?php echo $get_template->id; ?>">

                                 <script>
                                     $(function () {
                                         $('#enableCustomSettingcCheck<?php echo $get_template->id; ?>').change(function() {
                                             $('#enableCustomSettingcCheckToggle<?php echo $get_template->id; ?>').toggle();
                                         });
                                     });
                                 </script>

                                    <div class="form-group form-check">
                                        <input value="1"
                                                type="checkbox"
                                            <?php if(intval($get_template->has_custom_settings) != 0): ?> checked <?php endif; ?>
                                               name="templates_settings[<?php echo $get_template->id; ?>][has_custom_settings]"
                                               class="form-check-input" id="enableCustomSettingcCheck<?php echo $get_template->id; ?>">
                                        <label class="form-check-label" for="enableCustomSettingcCheck<?php echo $get_template->id; ?>">Enable custom settings</label>
                                    </div>



<div class="well" id="enableCustomSettingcCheckToggle<?php echo $get_template->id; ?>" <?php if(intval($get_template->has_custom_settings) == 0): ?> style="display: none" <?php endif; ?>>



                                    Template name:
                                    <input type="text" class="form-control" style="width: 100%"
                                           name="templates_settings[<?php echo $get_template->id; ?>][preview_name]"
                                           value="<?php echo $get_template->preview_name; ?>"/>
                                    <br/>
                                    Template preview:
                                    <input type="text" class="form-control" style="width: 100%"
                                           name="templates_settings[<?php echo $get_template->id; ?>][preview_url]"
                                           value="<?php echo $get_template->preview_url; ?>"/>
                                    <br/>
                                    Template screenshot:
                                    <input type="text" class="form-control" style="width: 100%"
                                           name="templates_settings[<?php echo $get_template->id; ?>][screenshot_url]"
                                           value="<?php echo $get_template->screenshot_url; ?>"/>

</div>

                                    <br/>




                                    <div style="padding-bottom: 10px;">
                                    Template sort:
                                    <input type="text" class="form-control js-template-preview-sort-<?php echo $get_template->id; ?>" style="width: 100%"
                                           name="templates_settings[<?php echo $get_template->id; ?>][preview_sort]"
                                           value="<?php echo $get_template->preview_sort; ?>"/>
                                    </div>

                                    <input type="hidden"
                                           name="templates_settings[<?php echo $get_template->id; ?>][homepage_url]"
                                           value="<?php echo $item['homepage']; ?>"/>
                                    <input type="hidden"
                                           name="templates_settings[<?php echo $get_template->id; ?>][target_dir]"
                                           value="<?php echo $item['target-dir']; ?>"/>
                                    <input type="hidden"
                                           name="templates_settings[<?php echo $get_template->id; ?>][git_package_name]"
                                           value="<?php echo $item['name']; ?>"/>
                                     <input type="hidden"
                                           name="templates_settings[<?php echo $get_template->id; ?>][name]"
                                           value="<?php echo $item['description']; ?>"/>
                                    <input type="submit" class="btn btn-success btn-block" value="Save settings"/>
                                </div>
                            </div>
                        </div>
                        <?php $i++; endforeach; ?>
                </div>
            </div>


            <button type="submit" class="btn btn-success">Save changes</button>
        </form>


        <div class="well" style="margin-top:50px;">
            <p>You have <b><?php echo $manager->report->getTotalClientProducts(); ?> </b> microweber active
                installations.</p>
        </div>



        <div class="well" style="margin-top:50px;">
        <?php include __DIR__."/embed_codes.php"; ?>
        </div>
        <div class="well" style="margin-top:50px;">
        <?php include __DIR__."/templates_reset.php"; ?>
        </div>

    </div>
    <!--    <pre>-->
    <?php // print_r($settings_render) ?>
    <?php //print_r($settings) ?>
    <?php // print_r($templates) ?>
    <?php // print_r($params) ?>
    <?php //print_r($enabled_templates) ?>
    <!--   </pre>-->
</div>