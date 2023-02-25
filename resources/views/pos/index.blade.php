@php
   // $logo=asset(Storage::url('uploads/logo/'));
        $logo=\App\Models\Utility::get_file('uploads/logo');


    $company_favicon=Utility::getValByName('company_favicon');

     $SITE_RTL = Utility::getValByName('SITE_RTL');
     $setting = \App\Models\Utility::colorset();
        $color = 'theme-3';
        if (!empty($setting['color'])) {
            $color = $setting['color'];
        }
     $mode_setting = \App\Models\Utility::mode_layout();

@endphp
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        {{ !empty($companySettings['header_text']) ? $companySettings['header_text']->value : config('app.name', 'ERPGO SaaS') }}
        - {{ __('POS') }}</title>

    <link rel="icon"
          href="{{ asset(Storage::url('uploads/logo/')) . '/' . (isset($companySettings['company_favicon']) && !empty($companySettings['company_favicon']) ? $companySettings['company_favicon']->value : 'favicon.png') }}"
          type="image" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}" id="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <!-- vendor css -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" id="main-style-link">

    <style>

        .bg-color{
            @if($color=='theme-1')
                background :linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d;
            @elseif($color=='theme-2')
                background : linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, #4ebbd3 99.86%), #1f3996;
            @elseif($color=='theme-3')
                background :  linear-gradient(141.55deg, #6fd943 3.46%, #6fd943 99.86%), #6fd943;
            @elseif($color=='theme-4')
                background :  linear-gradient(141.55deg, rgba(104, 94, 229, 0) 3.46%, #685ee5 99.86%), #584ed2;
            @endif
        }
    </style>

    @stack('css-page')
</head>

    <body class="{{ $color }}">
<!-- [ Main Content ] start -->
<div class="container-fluid px-2">
    <?php $lastsegment = request()->segment(count(request()->segments())) ?>

        <div class="row">
        <div class="col-12">
            <div class="mt-2 pos-top-bar bg-color d-flex justify-content-between">
                <span class="text-white">POS</span>
                <a  href="{{ route('dashboard') }}" class="text-white"><i class="ti ti-home" style="font-size: 20px;"></i> </a>
            </div>
        </div>
    </div>

        <div class="mt-2 row">
            <div class="col-lg-7">
                <div class="sop-card card">
                    <div class="card-header p-2">
                        <div class="search-bar-left">
                            <form>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                                    </div>
                                    <input id="searchproduct" type="text" data-url="{{ route('search.products') }}" placeholder="{{ __('Search Product') }}" class="form-control pr-4 rounded-right">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="right-content">
                            <div class="button-list b-bottom catgory-pad">
                                <div class="form-row m-0" id="categories-listing">
                                </div>
                            </div>
                            <div class="product-body-nop">
                                    <div class="form-row" id="product-listing">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ps-lg-0">
                <div class="card m-0">
                    <div class="card-header p-2">
                        <div class="row">
                            <div class="col-md-6">
                                {{ Form::select('customer_id', $customers,'', array('class' => 'form-control select customer_select','id'=>'customer','required'=>'required')) }}
                                {{ Form::hidden('vc_name_hidden', '',['id' => 'vc_name_hidden']) }}

                            </div>
                            <div class="col-md-6">
                                {{ Form::select('warehouse_id', $warehouses,'', array('class' => 'form-control select warehouse_select ','id'=>'warehouse','required'=>'required')) }}
                                {{ Form::hidden('warehouse_name_hidden', '',['id' => 'warehouse_name_hidden']) }}

                            </div>
                        </div>
                    </div>
                    <div class="card-body carttable cart-product-list carttable-scroll"  id="carthtml">
                            @php $total = 0 @endphp

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-left">Name</th>
                                            <th class="text-center">QTY</th>
                                            <th>Tax</th>
                                            <th class="text-center" >Price</th>
                                            <th class="text-center" >Sub Total</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0)
                                        @foreach(session($lastsegment) as $id => $details)
                                            @php
                                                $product = \App\Models\ProductService::find($details['id']);
                                                $image_url = (  !empty($product) && isset($product->pro_image) && Storage::exists($product->pro_image)) ? $product->pro_image : 'uploads/pro_image/';
                                                $total += $details['subtotal'];
                                            @endphp
                                                <tr data-product-id="{{$id}}" id="product-id-{{$id}}">
                                                    <td class="cart-images">
                                                        <img alt="Image placeholder" src="{{ asset(Storage::url($image_url)) }}" class="card-image avatar rounded-circle-sale shadow hover-shadow-lg">
                                                    </td>
                                                    <td class="name">{{ $details['name'] }}</td>
                                                    <td>
                                                        <span class="quantity buttons_added">
                                                            <input type="button" value="-" class="minus">
                                                            <input type="number" step="1" min="1" max="" name="quantity"
                                                                                       title="{{ __('Quantity') }}" class="input-number"
                                                                                       data-url="{{ url('update-cart/') }}" data-id="{{ $id }}"
                                                                                       size="4" value="{{ $details['quantity'] }}">
                                                            <input type="button" value="+" class="plus">
                                                        </span>
                                                    </td>
                                                    <td class="tax">{{ $details['tax'] }}%</td>
                                                    <td class="price text-right">{{ Auth::user()->priceFormat($details['price']) }}</td>
                                                    <td class="col-sm-3 mt-2">
                                                        <span class="subtotal">{{ Auth::user()->priceFormat($details['subtotal']) }}</span>
                                                    </td>

                                                    <td class="col-sm-2 mt-2">
                                                        <a href="#" class="action-btn bg-danger bs-pass-para-pos" data-confirm="{{ __('Are You Sure?') }}" data-text="{{__('This action can not be undone. Do you want to continue?')}}"
                                                           data-confirm-yes="delete-form-{{ $id }}" title="{{ __('Delete') }}" data-id="{{ $id }}">
                                                            <i class="ti ti-trash text-white mx-3 btn btn-sm" title="{{ __('Delete') }}"></i>
                                                        </a>
                                                        {!! Form::open(['method' => 'delete', 'url' => ['remove-from-cart'],'id' => 'delete-form-'.$id]) !!}
                                                        <input type="hidden" name="session_key" value="{{ $lastsegment }}">
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                        @endforeach
                                        @else
                                            <tr class="text-center no-found">
                                                <td colspan="7">{{__('No Data Found.!')}}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="total-section mt-4">
                                    <div class="sub-total">
                                        <div class="d-flex align-items-center justify-content-between">
                                                <h4 class="mb-0 text-gray-800">Total</h4>
                                                <h4 class="mb-0 text-gray-800" id="displaytotal">{{ Auth::user()->priceFormat($total) }}</h4>
                                            </div>
                                        <div class="d-flex align-items-center justify-content-between pt-3" id="btn-pur">
                                            <button type="button" class="btn btn-primary rounded"  data-ajax-popup="true" data-size="lg" data-align="centered" data-url="{{route('pos.create')}}" data-title="{{__('POS Invoice')}}"
                                                    @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0) @else disabled="disabled" @endif>
                                                {{ __('PAY') }}
                                            </button>
                                            <div class="tab-content btn-empty text-end">
                                                <a href="#" class="btn btn-danger bs-pass-para-pos rounded m-0"  data-toggle="tooltip" data-original-title="{{ __('Empty Cart') }}"
                                                           data-confirm="{{ __('Are You Sure?') }}" data-text="{{__('This action can not be undone. Do you want to continue?')}}"
                                                           data-confirm-yes="delete-form-emptycart">
                                                            {{ __('Empty Cart') }}
                                                        </a>
                                                {!! Form::open(['method' => 'post', 'url' => ['empty-cart'],'id' => 'delete-form-emptycart']) !!}
                                                <input type="hidden" name="session_key" value="{{ $lastsegment }}" id="empty_cart">
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>

</div>


<div class="modal fade" id="commonModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
    <div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"> </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Required Js -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>


<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>



<script src="{{ asset('js/jscolor.js') }}"></script>
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

<script src="{{asset('js/jquery-ui.min.js')}}"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( document ).ready(function() {

        $( "#vc_name_hidden" ).val($('.customer_select').val());
        $( "#warehouse_name_hidden" ).val($('.warehouse_select').val());

        $(function () {
            getProductCategories();

        });

        if ($('#searchproduct').length > 0) {
            var url = $('#searchproduct').data('url');
            searchProducts(url,'','0');
        }

        $( '#warehouse' ).change(function() {
           var ware_id = $( "#warehouse" ).val();
            searchProducts(url,'','0',ware_id);
        });
        $( '.customer_select' ).change(function() {
            $( "#vc_name_hidden" ).val($(this).val());
        });
        $( '.warehouse_select' ).change(function() {
            $( "#warehouse_name_hidden" ).val($(this).val());

            var session_key =  $( "#empty_cart" ).val();
            $.ajax({
                type: 'POST',
                url: '{{route('warehouse-empty-cart')}}',
                data: {
                    'session_key': session_key
                },
                success: function (data) {
                    $( "#tbody" ).empty();

                    $("#tbody").html('<tr class="text-center no-found"><td colspan="7">{{__('No Data Found.!')}}</td></tr>');

                }
            });
        });




        $(document).on('click', '#clearinput', function (e) {
            var IDs = [];
            $(this).closest('div').find("input").each(function () {
                IDs.push('#' + this.id);
            });
            $(IDs.toString()).val('');
        });




        $(document).on('keyup', 'input#searchproduct', function () {
            var url = $(this).data('url');
            var value = this.value;
            var cat = $('.cat-active').children().data('cat-id');
            // console.log(cat);
            searchProducts(url, value,cat);
        });


        function searchProducts(url, value,cat_id,war_id = '0') {
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'search': value,
                    'cat_id': cat_id,
                    'war_id' : war_id,
                    'session_key': session_key
                },
                success: function (data) {
                    console.log(data)
                    $('#product-listing').html(data);
                }
            });
        }

        function getProductCategories() {
            $.ajax({
                type: 'GET',
                url: '{{ route('product.categories') }}',
                success: function (data) {
                    // console.log(data);
                    $('#categories-listing').html(data);
                }
            });
        }

        $(document).on('click', '.toacart', function () {
             // alert('hey');
            var sum = 0;
            $.ajax({
                url: $(this).data('url'),

                success: function (data) {

                    if (data.code == '200') {

                        $('#displaytotal').text(addCommas(data.product.subtotal));

                        if ('carttotal' in data) {
                            $.each(data.carttotal, function (key, value) {
                                $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                                sum += value.subtotal;
                            });
                            $('#displaytotal').text(addCommas(sum));
                        }

                        $('#tbody').append(data.carthtml);
                        $('.no-found').addClass('d-none');
                        $('.carttable #product-id-' + data.product.id + ' input[name="quantity"]').val(data.product.quantity);
                        $('#btn-pur button').removeAttr('disabled');
                        $('.btn-empty button').addClass('btn-clear-cart');
                        // loadConfirm();
                        }
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('{{ __("Error") }}', data.error, 'error');
                }
            });
        });

        $(document).on('change keyup', '#carthtml input[name="quantity"]', function (e) {
            e.preventDefault();
            var ele = $(this);
            var sum = 0;
            var quantity = ele.closest('span').find('input[name="quantity"]').val();

            // console.log(quantity)

            $.ajax({
                url: ele.data('url'),
                method: "patch",
                data: {
                    id: ele.attr("data-id"),
                    quantity: quantity,
                    session_key: session_key
                },
                success: function (data) {

                    if (data.code == '200') {

                        if (quantity == 0) {
                            ele.closest(".row").hide(250, function () {
                                ele.closest(".row").remove();
                            });
                            if (ele.closest(".row").is(":last-child")) {
                                $('#btn-pur button').attr('disabled', 'disabled');
                                $('.btn-empty button').removeClass('btn-clear-cart');
                            }
                        }

                        $.each(data.product, function (key, value) {
                            sum += value.subtotal;
                            $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                        });

                        $('#displaytotal').text(addCommas(sum));
                    }
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('{{ __("Error") }}', data.error, 'error');
                }
            });
        });

        $(document).on('click', '.remove-from-cart', function (e) {
            e.preventDefault();

            var ele = $(this);
            var sum = 0;

            if (confirm('{{ __("Are you sure?") }}')) {
                ele.closest(".row").hide(250, function () {
                    ele.closest(".row").parent().parent().remove();
                });
                if (ele.closest(".row").is(":last-child")) {
                    $('#btn-pur button').attr('disabled', 'disabled');
                    $('.btn-empty button').removeClass('btn-clear-cart');
                }
                $.ajax({
                    url: ele.data('url'),
                    method: "DELETE",
                    data: {
                        id: ele.attr("data-id"),
                        // session_key: session_key
                    },
                    success: function (data) {
                        if (data.code == '200') {

                            $.each(data.product, function (key, value) {
                                sum += value.subtotal;
                                $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                            });

                            $('#displaytotal').text(addCommas(sum));

                            show_toastr('Success', data.success, 'success')
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.btn-clear-cart', function (e) {
            e.preventDefault();

            if (confirm('{{ __("Remove all items from cart?") }}')) {

                $.ajax({
                    url: $(this).data('url'),
                    data: {
                        session_key: session_key
                    },
                    success: function (data) {
                        location.reload();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.btn-done-payment', function (e) {
            e.preventDefault();
            var ele = $(this);

            $.ajax({
                url: ele.data('url'),

                method: 'GET',
                data: {
                    vc_name: $('#vc_name_hidden').val(),
                    warehouse_name: $('#warehouse_name_hidden').val(),
                },
                beforeSend: function () {
                    ele.remove();
                },
                success: function (data) {
                    // console.log(data);
                    // return false;
                    if (data.code == 200) {
                        show_toastr('Success', data.success, 'success')
                    }
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('{{ __("Error") }}', data.error, 'error');
                }

            });

        });

        $(document).on('click', '.category-select', function (e) {
            var cat = $(this).data('cat-id');
            var white = 'text-white';
            var dark = 'text-dark';
            $('.category-select').parent().removeClass('cat-active');
            $('.category-select').find('.card-title').removeClass('text-white').addClass('text-dark');
            $('.category-select').find('.card-title').parent().removeClass('text-white').addClass('text-dark');
            $(this).find('.card-title').removeClass('text-dark').addClass('text-white');
            $(this).find('.card-title').parent().removeClass('text-dark').addClass('text-white');
            $(this).parent().addClass('cat-active');
            var url = '{{ route('search.products') }}'
            searchProducts(url,'',cat);
        });
    });




</script>


<script>
    var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName('site_currency_symbol_position') }}';
    var site_currency_symbol = '{{ \App\Models\Utility::getValByName('site_currency_symbol') }}';
</script>


</body>

</html>
