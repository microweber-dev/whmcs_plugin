$(document).ready(function () {
    if (typeof (window.mw_templates) != 'undefined' && window.mw_templates && window.mw_templates_config_option_id) {
        var mw_templates_config_option_id_element = $('#inputConfigOption' + window.mw_templates_config_option_id);

        if (mw_templates_config_option_id_element && mw_templates_config_option_id_element.length) {

            var html = '<div class="sub-heading">' +
                '                            <span>Select Template</span>\n' +
                '                        </div><div class="row mw-configoption-template-select-holder">';
            var mw_templates_config_option_id_form_item_name = 'configoption[' + window.mw_templates_config_option_id + ']';
            var mw_templates_config_option_selected_val = mw_templates_config_option_id_element[0].value;


            $.each(window.mw_templates, function (index, value) {
                if (value.name && value.target_dir && value.config_option_id) {

                    var is_selected = '';
                    var screenshot = '';

                    if (value.screenshot_url) {
                        var screenshot = value.screenshot_url;
                    }

                    if (mw_templates_config_option_selected_val == value.config_option_id) {
                        is_selected = ' checked="checked" ';
                    }

                    var item_html = '<div class="col-md-3" style="">' + '<label style="padding:10px; width: 100%">' +
                        '<div style="width: 100%; height: 120px; background-image: url(' + screenshot + '); ' +
                        'background-size: cover; background-position: top center;"></div><br />' +
                        '<div  style="width: 100%;"  ' +
                        'data-screenshot="' + screenshot + '" xxxonclick="installMarketplaceItemByPackageName(' + '\'' + value.name + '\'' + ')"' +
                        '>' +
                        ' <input type="radio" ' + is_selected + ' name="' + mw_templates_config_option_id_form_item_name + '" value="' + value.config_option_id + '"> ' + value.name + '</div>' +
                        '<br /></label>' + '</div>';

                    html += item_html;
                }
            });

            html += '</div>';

            if ($(mw_templates_config_option_id_element).parents('div[class^="row"]').length > 0) {
                $(mw_templates_config_option_id_element).parents('div[class^="row"]').eq(0).html(html);
            } else {
                $(mw_templates_config_option_id_element).parent().html(html);
            }
        }
    }
});
