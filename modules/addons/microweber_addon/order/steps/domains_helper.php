<script>
    var __dprev = $("#domain-search-field").val();
    __ajax_search = null;

    function searchDomainResults(el) {

        if (__ajax_search && typeof (__ajax_search.abort) !== 'undefined') {
            __ajax_search.abort();
        }

        var __dprev = $("#domain-search-field").val();

        if (!!el.value && el.value != __dprev) {
            $("#container").addClass('domain-search-field-on')
        } else {
            $("#container").removeClass('domain-search-field-on')
        }

        var keyword = $("#domain-search-field").val();


        var URL = "<?php print site_url();?>index.php?m=microweber_addon&ajax=1&function=domain_search&domain=" + encodeURI(keyword) + "<?php if (isset($_GET['tld_order'])) {
            echo '&tld_order=' . $_GET['tld_order'];
        }; ?>";

        __ajax_search = $.ajax({
            contentType: 'application/json',
            dataType: 'json',
            url: URL,
            cache: false,
            type: "POST",
            success: function (response) {

                $(".js-search-domains").removeAttr('disabled');

                if (response) {
                    if (response.results) {
                        render_domain_search_list(response.results);
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
                searchDomainResults(el);
            })(this)

            $('.js-clear-domain').addClass('visible');
            $('#domain-search-field-autocomplete').addClass('ajax-loading');
        });

        $('.js-clear-domain').on('click', function () {
            $('#domain-search-field').val('');
            $('#domain-search-field-autocomplete').empty();
            $(this).removeClass('visible');
        })

        $(document).on("click", ".domain-item.can-start", function () {

            var domain = $(this).attr('data-domain');
            var sld = $(this).attr('data-sld');
            var tld = $(this).attr('data-tld');
            var subdomain = $(this).attr('data-subdomain');
            var target = $(this).attr('data-target');

            var urlbase = document.location.href;
            if (urlbase.indexOf('?') == -1) {
                urlbase = urlbase+'?';
            }

            var url = urlbase + "&domain=" + domain + "&sld=" + sld + "&tld=" + tld + "&subdomain=" + subdomain + "&target=<?php echo htmlspecialchars($_GET['target']); ?>&style=<?php echo htmlspecialchars(trim($_GET['style'])); ?>";

            <?php if(isset($_GET['target']) AND $_GET['target'] == 'top'): ?>
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