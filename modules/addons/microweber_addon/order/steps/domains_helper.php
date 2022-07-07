<script>
    var __dprev = $("#domain-search-field").val();
    __ajax_search = null;

    function searchDomainResults(el, page = 0) {

        if (__ajax_search && typeof (__ajax_search.abort) !== 'undefined') {
            __ajax_search.abort();
        }

        $(".js-domain-search-load-more-btn").val(page);

        var __dprev = $("#domain-search-field").val();

        if (!!el.value && el.value != __dprev) {
            $("#container").addClass('domain-search-field-on')
        } else {
            $("#container").removeClass('domain-search-field-on')
        }

        var keyword = $("#domain-search-field").val();

        var URL = "<?php print site_url();?>index.php?m=microweber_addon&ajax=1&function=domain_search&domain=" + encodeURI(keyword) + "<?php if (isset($_GET['tld_order'])) {
            echo '&tld_order=' . $_GET['tld_order'];
        }; ?><?php if (isset($_REQUEST['template_id'])) {
            echo '&template_id=' . $_REQUEST['template_id'];
        }; ?>" + "&page=" + page;

        var appendNewData = false;
        if (page > 0) {
            appendNewData = true;
        }

        __ajax_search = $.ajax({
            contentType: 'application/json',
            dataType: 'json',
            url: URL,
            cache: false,
            type: "POST",
            success: function (response) {

                if (response.load_more_results == 1) {
                    $(".js-domain-search-load-more-btn").val(response.next_result_page);
                    $("#domain-search-load-more").show();
                } else {
                    $("#domain-search-load-more").hide();
                }

                $(".js-domain-search-load-more-btn").removeAttr('disabled');
                $(".js-domain-search-load-more-btn").html('Load more');

                $(".js-search-domains").removeAttr('disabled');

                if (response) {
                    if (response.results) {
                        render_domain_search_list(response.results, appendNewData);
                    }
                }
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $("#user_registration_form").on('submit', function (e) {
            e.preventDefault();
            $('.ajax-loading-placeholder').show();

            (function (el) {
                searchDomainResults(el,-0);
            })(this);

            $('.js-clear-domain').addClass('visible');
            $('#domain-search-field-autocomplete').addClass('ajax-loading');
        });

        $('.js-clear-domain').on('click', function () {
            $('#domain-search-field').val('');
            $('#domain-search-field-autocomplete').empty();
            $(this).removeClass('visible');
        })

        $(document).on("click", ".js-domain-search-load-more-btn", function () {

            var nextPage = $(".js-domain-search-load-more-btn").val();

            $(".js-domain-search-load-more-btn").attr('disabled','disabled');
            $(".js-domain-search-load-more-btn").html('Loading...');

            (function (el) {
                searchDomainResults(el, nextPage);
            })(this);

        });

        $(document).on("click", ".domain-item.can-start", function () {

            var domain = $(this).attr('data-domain');
            var sld = $(this).attr('data-sld');
            var tld = $(this).attr('data-tld');
            var subdomain = $(this).attr('data-subdomain');
            var target = $(this).attr('data-target');

         //   var urlbase = document.location.href;

            var urlbase = new URL(document.location.href);
            urlbase.searchParams.delete('from_step');

            urlbase = urlbase.toString()
            if (urlbase.indexOf('?') == -1) {
                urlbase = urlbase+'?';
            }
            var template_id = $(this).attr('data-template-id');
            var config_template_id = $(this).attr('data-config-gid');

            var url = urlbase + "&domain=" + domain + "&sld=" + sld + "&tld=" + tld + "&subdomain=" + subdomain + "&target=<?php echo htmlspecialchars($_GET['target']); ?>&style=<?php echo htmlspecialchars(trim($_GET['style'])); ?>";

            if(template_id && config_template_id){
                var url = url + "&template_id=" + template_id + "&config_gid=" + config_template_id ;

            }


            <?php if(isset($_GET['target']) AND ($_GET['target'] == 'top' or $_GET['target'] == '_top')): ?>
            window.top.location = url;
            <?php else: ?>
            document.location = url;
            <?php endif; ?>
        });

    })
</script>



<!-- The Modal -->
<div class="modal" id="wrongSymbols">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Allowable characters</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
                <p>You can use letters <strong>a-z</strong>, numbers <strong>0-9</strong> and hyphen(<strong>-</strong>).</p>
                <p>Words contain "<strong>test</strong>" are disallowed!</p>
                <br/>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>