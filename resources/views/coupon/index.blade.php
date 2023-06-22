@extends('layouts.admin')
@push('script-page')
    <script>
        $(document).on('click', '.code', function () {
            var type = $(this).val();
            if (type == 'manual') {
                $('#manual').removeClass('d-none');
                $('#manual').addClass('d-block');
                $('#auto').removeClass('d-block');
                $('#auto').addClass('d-none');
            } else {
                $('#auto').removeClass('d-none');
                $('#auto').addClass('d-block');
                $('#manual').removeClass('d-block');
                $('#manual').addClass('d-none');
            }
        });

        $(document).on('click', '#code-generate', function () {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#auto-code').val(result);
        });
    </script>
@endpush
@section('page-title')
    {{__('Manage Coupon')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Coupon')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
    @can('create coupon')

       <a href="#" data-size="lg" data-url="{{ route('coupons.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Coupon')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        @endcan

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{__('Name')}}</th>
                                <th> {{__('Code')}}</th>
                                <th> {{__('Discount (%)')}}</th>
                                <th> {{__('Limit')}}</th>
                                <th> {{__('Used')}}</th>
                                <th> {{__('Action')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($coupons as $coupon)
                                <tr class="font-style">
                                    <td>{{ $coupon->name }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount }}</td>
                                    <td>{{ $coupon->limit }}</td>
                                    <td>{{ $coupon->used_coupon() }}</td>
                                    <td class="Action">
                                        <span>
                                        <div class="action-btn bg-info ms-2">
                                        <a href="{{ route('coupons.show',$coupon->id) }}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('View')}}">
                                            <i class="ti ti-eye text-white"></i>
                                        </a>
                                        </div>
                                        @can('edit coupon')
                                        <div class="action-btn bg-primary ms-2">
                                                <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ route('coupons.edit',$coupon->id) }}" data-ajax-popup="true" data-title="{{__('Edit Coupon')}}" data-bs-toggle="tooltip"  title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                            @endcan
                                            @can('delete coupon')
                                            <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id],'id'=>'delete-form-'.$coupon->id]) !!}

                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$coupon->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                                {!! Form::close() !!}
                                            </div>
                                            @endcan
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
