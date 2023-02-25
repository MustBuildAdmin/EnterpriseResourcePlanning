@extends('layouts.admin')
@section('page-title')
    {{__('Manage Coupon Details')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Coupon Details')}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{__('User')}}</th>
                                <th> {{__('Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($userCoupons as $userCoupon)
                                <tr class="font-style">
                                    <td>{{ !empty($userCoupon->userDetail)?$userCoupon->userDetail->name:'' }}</td>
                                    <td>{{ $userCoupon->created_at }}</td>
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
