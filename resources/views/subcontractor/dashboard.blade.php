@include('new_layouts.header')
@include('consultants.dashboard.side_bar')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
<style>
    #create {
        height: 35px !important;
        width: 12% !important;
    }

    #invite {
        height: 35px !important;
        width: 12% !important;
    }

    #reset {

        width: 12% !important;
    }

    #search_button {
        height: 35px !important;
        width: 12% !important;
    }

    .dropdown-toggle::after {
        display: none;
        position: absolute;
        top: 50%;
        right: 20px;
    }

    .avatar.avatar-xl.mb-3.user-initial {
        border-radius: 50%;
        color: #FFF;
    }

    .avatar-xl {
        --tblr-avatar-size: 6.2rem;
    }
</style>
@php $profile = \App\Models\Utility::get_file('uploads/avatar/'); @endphp
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ __('View Company') }}</h2>
                </div>
                <!-- Page title actions -->
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                @forelse($users as $user)
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-header-right">
                                <div class="btn-group card-option float-end">
                                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    @if ($user->color_code != null || $user->color_code != '')
                                        @php $color_co = $user->color_code; @endphp
                                    @else
                                        @php $color_co = Utility::rndRGBColorCode(); @endphp
                                    @endif
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" data-size="lg"
                                            data-url="{{ route('subContractor.get_company_details', [$user->id]) }}"
                                            data-ajax-popup="true" class="dropdown-item"
                                            data-bs-original-title="{{ __('View Company details') }}">
                                            <i class="ti ti-eye"></i>
                                            <span>{{ __('view') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4 text-center">
                                @php $short = substr($user->name, 0, 1); @endphp
                                @php $short_lname = substr($user->lname, 0, 1); @endphp
                                @if (!empty($user->avatar))
                                    <img src="{{ !empty($user->avatar) ? $profile . $user->avatar :
                                    asset(Storage::url(' uploads/avatar/avatar.png ')) }}"
                                        class="avatar avatar-xl mb-3 rounded" alt="" />
                                @else
                                    @if ($user->color_code != null || $user->color_code != '')
                                        @php $color_co = $user->color_code; @endphp
                                    @else
                                        @php $color_co = Utility::rndRGBColorCode(); @endphp
                                    @endif
                                    <div class="avatar avatar-xl mb-3 user-initial"
                                        style="background-color:{{ $color_co }}">
                                        {{ strtoupper($short) }}{{ strtoupper($short_lname) }}
                                    </div>
                                @endif
                                @php
                                    $name = strlen($user->name) > 20 ? substr($user->name, 0, 19) . '...' : $user->name;
                                @endphp
                                <h3 class="m-0 mb-1">
                                    <a href="#">{{ $name }}</a>
                                </h3>
                            </div>
                            @if (\Auth::user()->type != 'super admin')
                                <div class="d-flex">
                                    <a data-bs-toggle="tooltip" data-copy_email="{{ $user->email }}"
                                        title="{{ $user->email }}" href="#" class="card-btn"
                                        onclick="copyToClipboard(this)">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2
                                                  2h-14a2 2 0 0 1 -2 -2z" />
                                            <path d="M3 7l9 6l9 -6" />
                                        </svg>
                                        {{ __('Email') }}
                                    </a>
                                    <a data-bs-toggle="tooltip" data-copy_phone="{{ $user->phone }}"
                                        title="{{ $user->phone }}" class="card-btn"
                                        onclick="copyToClipboardphone(this)">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2
                                                 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                        </svg>
                                        {{ __('Mobile') }}
                                    </a>
                                </div>
                            @else
                                <div class="row justify-content-between align-items-center"></div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="page-body">
                        <div class="container-xl d-flex flex-column justify-content-center">
                            <div class="empty">
                                <div class="empty-img">
                                    <img src="{{ asset('assets/images/undraw_printing_invoices_5r4r.svg') }}"
                                        height="128" alt="" />
                                </div>
                                <p class="empty-title">
                                    {{ __('No Sub Contractor Found') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="d-flex mt-4">
                <ul class="pagination ms-auto">
                    {!! $users->links() !!}
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container-xl">
    <div class="row row-cards">
        <div class="card activity-scroll">
            <div class="card-header">
                <h5>{{ __('Activity Log') }}</h5>
                <small>{{ __('Activity Log of this project') }}</small>
            </div>
            <div class="card-body vertical-scroll-cards">
                <div class="card p-2 mb-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">hgj</h6>
                                <p class="text-muted text-sm mb-0">dfgfdg</p>
                            </div>
                        </div>
                        <p class="text-muted text-sm mb-0">dfgfdggf</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('new_layouts.footer')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            copy_email = $(element).data('copy_email');
            $temp.val(copy_email).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.info("Email copying to clipboard was successful!");
        }

        function copyToClipboardphone(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            copy_phone = $(element).data('copy_phone');
            $temp.val(copy_phone).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success("Mobile copying to clipboard was successful!");
        }

        $(document).on('keypress', function(e) {
            if (e.which == 13) {
                swal.closeModal();
            }
        });


        $(document).on('change', '.document_setup', function() {
            var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'gif'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $(".show_document_file").hide();
                $(".show_document_error").html("Upload only pdf, jpeg, jpg, png");
                $('input[type="submit"]').prop('disabled', true);
                return false;
            } else {
                $(".show_document_file").show();
                $(".show_document_error").hide();
                $('input[type="submit"]').prop('disabled', false);
                return true;
            }
        });
    </script>
    <script src="https://tabler.io/demo/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1685976846"
        integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC" crossorigin="anonymous">
    </script>
    <script src="https://tabler.io/demo/dist/libs/jsvectormap/dist/maps/world-merc.js?1685976846"
        integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC" crossorigin="anonymous">
    </script>
</div>
