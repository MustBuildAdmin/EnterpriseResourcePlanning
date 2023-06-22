<!DOCTYPE html>
@php
    // $logo=asset(Storage::url('uploads/logo/'));
    $logo=\App\Models\Utility::get_file('uploads/logo');

    $company_logo=Utility::getValByName('company_logo_dark');
    $company_logos=Utility::getValByName('company_logo_light');
    $company_favicon=Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $mode_setting = \App\Models\Utility::mode_layout();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $company_logo = \App\Models\Utility::GetLogo();
    $SITE_RTL= isset($setting['SITE_RTL'])?$setting['SITE_RTL']:'off';

@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">
<head>
    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'Must BuildApp')}} - @yield('page-title')</title>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="Dashboard Template Description"/>
    <meta name="keywords" content="Dashboard Template"/>
    <meta name="author" content="Rajodiya Infotech"/>

    <!-- Favicon icon -->
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image/x-icon"/>

    <!-- font css -->
    <link href="{{asset('assets/dist/css/tabler.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-flags.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-payments.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-vendors.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/demo.min.css?1674944402')}}" rel="stylesheet"/>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

      :root {
      	--tblr-font-sans-serif: 'Poppins', sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>

</head>
<body  class=" d-flex flex-column">
@yield('content')
<script src="{{asset('assets/dist/js/demo-theme.min.js?1674944402')}}"></script>
<!-- Required Js -->
<script src="{{asset('assets/dist/js/tabler.min.js?1674944402')}}" defer></script>
<script src="{{asset('assets/dist/js/demo.min.js?1674944402')}}" defer></script>
<script src="{{ asset('assets/js/vendor-all.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script>
    feather.replace();
</script>


<script>
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

    // var custdarklayout = document.querySelector("#cust-darklayout");
    // custdarklayout.addEventListener("click", function () {
    //     if (custdarklayout.checked) {
    //         document
    //             .querySelector(".m-header > .b-brand > .logo-lg")
    //             .setAttribute("src", "{{ asset('assets/images/logo.svg') }}");
    //         document
    //             .querySelector("#main-style-link")
    //             .setAttribute("href", "{{ asset('assets/css/style-dark.css') }}");
    //     } else {
    //         document
    //             .querySelector(".m-header > .b-brand > .logo-lg")
    //             .setAttribute("src", "{{ asset('assets/images/logo-dark.png') }}");
    //         document
    //             .querySelector("#main-style-link")
    //             .setAttribute("href", "{{ asset('assets/css/style.css') }}");
    //     }
    // });

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>
@stack('custom-scripts')
</body>
</html>
