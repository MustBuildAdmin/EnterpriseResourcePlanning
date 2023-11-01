<head>

    <title>{{__('Must BuildApp SaaS')}}</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />

    <link rel="stylesheet" href="{{asset('assets/css/plugins/animate.min.css')}}" />
    <!-- font css -->
    <link rel="stylesheet" href="{{asset('assets/fonts/tabler-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/material.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/customizer.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/landing.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
</head>
<section id="price" class="price-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9 title">
                <h2>
                    <span class="d-block mb-3">Price</span> All in one place CRM
                    system
                </h2>
                <p class="m-0">
                    Use these awesome forms to login or create new account in your
                    project for free.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($plans as $plan)
            <div class="col-lg-4 col-md-6">
                <div
                    class="card price-card price-1 wow animate__fadeInUp"
                    data-wow-delay="0.2s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <span class="price-badge bg-primary">{{$plan->name}}</span>
                        <span class="mb-4 f-w-600 p-price" style="font-size:65px !important">
                            ${{$plan->price}}
                            <small class="text-sm">/{{$plan->duration}}</small>
                        </span>
                        <p class="mb-0">
                            {{$plan->description ?? ''}}
                        </p>
                        <ul class="list-unstyled my-5">
                            @if(isset($plan->max_users))
                            <li>
                                <span class="theme-avtar">
                                    <i class="text-primary ti ti-circle-plus"></i>
                                </span>
                                {{$plan->max_users}} users
                            </li>
                            @endif
                            @if(isset($plan->max_customers))
                            <li>
                                <span class="theme-avtar">
                                    <i class="text-primary ti ti-circle-plus"></i>
                                </span>
                                {{$plan->max_customers}} customers
                            </li>
                            @endif
                            @if(isset($plan->max_venders))
                            <li>
                                <span class="theme-avtar">
                                    <i class="text-primary ti ti-circle-plus"></i>
                                </span>
                                {{$plan->max_venders}} venders
                            </li>
                            @endif
                            @if(isset($plan->max_clients))
                            <li>
                                <span class="theme-avtar">
                                    <i class="text-primary ti ti-circle-plus"></i>
                                </span>
                                {{$plan->max_clients}} clients
                            </li>
                            @endif
                            <li>
                                <span class="theme-avtar">
                                    <i class="text-primary ti ti-circle-plus"></i>
                                </span>
                                Integration help
                            </li>
                        </ul>
                        <div class="d-grid text-center">
                            <a href ="{{url('/home')}}"
                                class="btn mb-3 btn-primary d-flex justify-content-center align-items-center mx-sm-5"
                            >
                                Start with Standard plan
                                <i class="ti ti-chevron-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- <div class="col-lg-4 col-md-6">
                <div
                    class="card price-card price-2 bg-primary wow animate__fadeInUp"
                    data-wow-delay="0.4s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <span class="price-badge">STARTER</span>
                        <span class="mb-4 f-w-600 p-price"
                        >$59<small class="text-sm">/month</small></span
                        >
                        <p class="mb-0">
                            You have Free Unlimited Updates and <br />
                            Premium Support on each package.
                        </p>
                        <ul class="list-unstyled my-5">
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                2 team members
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                20GB Cloud storage
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integration help
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Sketch Files
                            </li>
                        </ul>
                        <div class="d-grid text-center">
                            <button
                                class="btn mb-3 btn-light d-flex justify-content-center align-items-center mx-sm-5"
                            >
                                Start with Standard plan
                                <i class="ti ti-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div
                    class="card price-card price-3 wow animate__fadeInUp"
                    data-wow-delay="0.6s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <span class="price-badge bg-primary">STARTER</span>
                        <span class="mb-4 f-w-600 p-price"
                        >$119<small class="text-sm">/month</small></span
                        >
                        <p class="mb-0">
                            You have Free Unlimited Updates and <br />
                            Premium Support on each package.
                        </p>
                        <ul class="list-unstyled my-5">
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                2 team members
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                20GB Cloud storage
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integration help
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                2 team members
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                20GB Cloud storage
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integration help
                            </li>
                        </ul>
                        <div class="d-grid text-center">
                            <button
                                class="btn mb-3 btn-primary d-flex justify-content-center align-items-center mx-sm-5"
                            >
                                Start with Standard plan
                                <i class="ti ti-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>

<script src="{{asset('assets/js/plugins/popper.min.js')}}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="{{asset('assets/js/pages/wow.min.js')}}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
