<?php
/** @var \MicroweberAddon\Manager  $manager */
//$manager = new \MicroweberAddon\Manager;

$templates = $manager->get_templates();
$settings = $manager->get_settings();
$settings_render = $manager->config->get_settings_for_render();

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
    .microweber-addon select option[value="aaa"]   { background-color: powderblue;   }
    .microweber-addon select option[value="opel"]   { background-color: red;   }
    .microweber-addon select option[value="audi"]   { background-color: green;   }
</style>

    <script>
        $( document ).ready(function() {

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



    <section class="container">
        <div>
            <select id="leftValues" size="5" multiple> <option>5553</option></select>
        </div>
        <div>
            <input type="button" id="btnLeft" value="&lt;&lt;" />
            <input type="button" id="btnRight" value="&gt;&gt;" />
        </div>
        <div>
            <select id="rightValues" size="4" multiple>
                <option value="aaa">aaa</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
            </select>
            <div>
                <input type="text" id="txtRight" />
            </div>
        </div>
    </section>



    hi


   <pre>
        <?php print_r($settings_render) ?>
        <?php //print_r($settings) ?>
        <?php //print_r($templates) ?>
        <?php // print_r($params) ?>
   </pre>


</div>







