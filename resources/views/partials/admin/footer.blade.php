<style>
    .error{
        color: red!important;
    }
</style>
<!-- [ Main Content ] end -->
<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <span class="text-muted">  {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright ERPGO') }} {{ date('Y') }}</span>
        </div>

    </div>
</footer>
<link href="{{ asset('assets/js/chosenjquery/chosen.css') }}" rel="stylesheet"/>

<!-- Warning Section Ends -->
<!-- Required Js -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{asset('js/avatarImageGenrator.js')}}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

<script src="{{ asset('assets/js/chosenjquery/chosen.jquery.js') }}"></script>
<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/jscolor.js') }}"></script>
<!-- script of the validator  -->
<script src="{{ asset('js/jquery.validate.js') }}"></script>

<script>
    var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName('site_currency_symbol_position') }}';
    var site_currency_symbol = '{{ \App\Models\Utility::getValByName('site_currency_symbol') }}';
</script>
<script src="{{ asset('js/custom.js') }}"></script>

@if($message = Session::get('success'))
    <script>
        show_toastr('success', '{!! $message !!}');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('error', '{!! $message !!}');
    </script>
@endif
@stack('script-page')

@stack('old-datatable-js')

@if (App\Models\Utility::getValByName1('gdpr_cookie') == 'on')
    <script type="text/javascript">
        var defaults = {
            'messageLocales': {
                /*'en': 'We use cookies to make sure you can have the best experience on our website. If you continue to use this site we assume that you will be happy with it.'*/
                'en': "{{ App\Models\Utility::getValByName1('cookie_text') }}"
            },
            'buttonLocales': {
                'en': 'Ok'
            },
            'cookieNoticePosition': 'bottom',
            'learnMoreLinkEnabled': false,
            'learnMoreLinkHref': '/cookie-banner-information.html',
            'learnMoreLinkText': {
                'it': 'Saperne di più',
                'en': 'Learn more',
                'de': 'Mehr erfahren',
                'fr': 'En savoir plus'
            },
            'buttonLocales': {
                'en': 'Ok'
            },
            'expiresIn': 30,
            'buttonBgColor': '#d35400',
            'buttonTextColor': '#fff',
            'noticeBgColor': '#000000',
            'noticeTextColor': '#fff',
            'linkColor': '#009fdd'
        };
    </script>
    <script src="{{ asset('js/cookie.notice.js') }}"></script>
@endif

<script>
jQuery.validator.addMethod("validate_email", function(value, element) {

    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
    
}, "Please enter a valid Email.");

jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 ;
}, "Please specify a valid phone number");

$(document).on("click", 'input[type=submit]', function () {
    
    $(this).closest('form').validate({
    rules: {
        email: {
            validate_email: true
        },
        company_email: {
            validate_email: true
        },
        contact: {
                phoneUS: true
        },
        phone: {
                phoneUS: true
        },
    }
    });
});

$(document).on("keyup", 'input[type=date]', function () {
    var tt= $(this).val().length;
    if(tt>10){
            $(this).val('');
            show_toastr('error', 'Please enter valid date');
            // Swal.fire({
            //     position: 'top-end',
            //     icon: 'error',
            //     title: 'Oops...',
            //     text: 'Please enter a valid date!'
            // })
    }
    setTimeout(
        function() 
        {
                $('#error').text('');
        }, 8000);
});
// country list
// var settings = {
//   "url": "https://api.countrystatecity.in/v1/countries/IN/states",
//   "method": "GET",
//   "headers": {
//     "X-CSCAPI-KEY": "API_KEY"
//   },
// };

// $.ajax(settings).done(function (response) {
//   console.log(response);
// });

// $(document).on("keyup", 'input[type=date]', function () {
//         var settings = {
//         "url": "https://api.countrystatecity.in/v1/countries",
//         "method": "GET",
//         "headers": {
//             "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
//         },
//         };

//         $.ajax(settings).done(function (response) {
//         console.log(response);
//         });
// });
// end country list


    feather.replace();
    var pctoggle = document.querySelector("#pct-toggler");
    if (pctoggle) {
        pctoggle.addEventListener("click", function () {
            if (
                !document.querySelector(".pct-customizer").classList.contains("active")
            ) {
                document.querySelector(".pct-customizer").classList.add("active");
            } else {
                document.querySelector(".pct-customizer").classList.remove("active");
            }
        });
    }

    var themescolors = document.querySelectorAll(".themes-color > a");
    for (var h = 0; h < themescolors.length; h++) {
        var c = themescolors[h];

        c.addEventListener("click", function (event) {
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            var temp = targetElement.getAttribute("data-value");
            removeClassByPrefix(document.querySelector("body"), "theme-");
            document.querySelector("body").classList.add(temp);
        });
    }
    //
    // var custthemebg = document.querySelector("#cust-theme-bg");
    // custthemebg.addEventListener("click", function () {
    //     if (custthemebg.checked) {
    //         document.querySelector(".dash-sidebar").classList.add("transprent-bg");
    //         document
    //             .querySelector(".dash-header:not(.dash-mob-header)")
    //             .classList.add("transprent-bg");
    //     } else {
    //         document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
    //         document
    //             .querySelector(".dash-header:not(.dash-mob-header)")
    //             .classList.remove("transprent-bg");
    //     }
    // });

    {{--var custdarklayout = document.querySelector("#cust-darklayout");--}}
    {{--custdarklayout.addEventListener("click", function () {--}}
    {{--    if (custdarklayout.checked) {--}}
    {{--        document--}}
    {{--            .querySelector(".m-header > .b-brand > .logo-lg")--}}
    {{--            .setAttribute("src", "{{ asset('js/chatify/autosize.js') }}../assets/images/logo.svg");--}}
    {{--        document--}}
    {{--            .querySelector("#main-style-link")--}}
    {{--            .setAttribute("href", "{{ asset('js/chatify/autosize.js') }}../assets/css/style-dark.css");--}}
    {{--    } else {--}}
    {{--        document--}}
    {{--            .querySelector(".m-header > .b-brand > .logo-lg")--}}
    {{--            .setAttribute("src", "{{ asset('js/chatify/autosize.js') }}../assets/images/logo-dark.svg");--}}
    {{--        document--}}
    {{--            .querySelector("#main-style-link")--}}
    {{--            .setAttribute("href", "{{ asset('js/chatify/autosize.js') }}../assets/css/style.css");--}}
    {{--    }--}}
    {{--});--}}

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>
