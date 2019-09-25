<?php if (isset($_GET['domain-style']) AND $_GET['domain-style'] == 'v2') {
    include('domain-v2.php');
} elseif (isset($_GET['domain-style']) AND $_GET['domain-style'] == 'v3') {
    include('domain-v3.php');
} else {
    include('domain-v1.php');
} ?>
`
<script>
    var __dprev = $("#domain-search-field").val();
    var __dtime = null;

    function searchDomainResults(el) {
        setTimeout(function () {
            var __dprev = $("#domain-search-field").val();
            var __dtime = null;

            clearTimeout(__dtime);
            __dtime = setTimeout(function () {
                if (!!el.value && el.value != __dprev) {
                    $("#container").addClass('domain-search-field-on')
                } else {
                    $("#container").removeClass('domain-search-field-on')
                }
                __dprev = el.value;

                var keyword = $("#domain-search-field").val();
                var URL = encodeURI("<?php print $CONFIG['SystemURL'];?>/index.php?m=microweber_addon&ajax=1&function=domain_search&domain=" + keyword);
                $.ajax({
                    contentType: 'application/json',
                    dataType: 'json',
                    url: URL,
                    cache: false,
                    type: "POST",
                    success: function (response) {
                        if (response) {
                            if (response.results) {
                                render_domain_search_list(response.results);
                            }
                        }
                    }
                });
            }, 10);
        }, 1000);
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        //****************** Allow only alphabets, numbers and - in text field **********************//
        $('#domain-search-field').on('keydown', function (e) {
            if (!$(this).data("value")) {
                $(this).data("value", this.value);
            }
        });

        $('#domain-search-field').on('keyup', function (e) {
            if (!/^[-0-9a-z]*$/i.test(this.value)) {
                this.value = $(this).data("value");
            } else {
                $(this).data("value", null);
            }

        });
    });


    $(document).ready(function () {
        $(".js-search-domains").on('click', function () {
            // Define an expression of words to check for
            var words = new RegExp('test|neshtozabraneno');
            // Check if any of the words is contained within your element
            if (words.test($('#domain-search-field').val())) {
                $('#wrongSymbols').modal();
                $('#domain-search-field').val('');
                return false;
            }

            $('.ajax-loading-placeholder').show();

            (function (el) {
                searchDomainResults(el);
            })(this)

            $('.js-clear-domain').addClass('visible');
            $('#domain-search-field-autocomplete').addClass('ajax-loading');
        });

        $("#user_registration_form").on('submit', function (e) {
            e.preventDefault();

            // Define an expression of words to check for
            var words = new RegExp('test|neshtozabraneno');
            // Check if any of the words is contained within your element
            if (words.test($('#domain-search-field').val())) {
                $('#wrongSymbols').modal();
                $('#domain-search-field').val('');
                return false;
            }


            $('.ajax-loading-placeholder').show();

            (function (el) {
                searchDomainResults(el);
            })(this)

            $('.js-clear-domain').addClass('visible');
            $('#domain-search-field-autocomplete').addClass('ajax-loading');
        });

        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 50;  //time in ms, 5 second for example
        var $input = $('#domain-search-field');

        //on keyup, start the countdown
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown
        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        //user is "finished typing," do something
        function doneTyping() {
            // Define an expression of words to check for
            var words = new RegExp('test|neshtozabraneno');
            // Check if any of the words is contained within your element
            if (words.test($('#domain-search-field').val())) {
                $('#wrongSymbols').modal();
                $('#domain-search-field').val('');
                return false;
            }

            if ($('#domain-search-field').val() == '') {
                $('#domain-search-field').val('');
                $('#domain-search-field-autocomplete').empty();
                $(this).removeClass('visible');
            }

            $('.ajax-loading-placeholder').show();

            (function (el) {
                searchDomainResults(el);
            })(this)

            $('.js-clear-domain').addClass('visible');
            $('#domain-search-field-autocomplete').addClass('ajax-loading');
        }

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

            var url = document.location.href + "?&domain=" + domain + "&sld=" + sld + "&tld=" + tld + "&subdomain=" + subdomain + "&target=<?php echo htmlspecialchars($_GET['target']); ?>";
 
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