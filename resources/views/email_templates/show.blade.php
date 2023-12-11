@extends('layouts.admin')
@section('page-title')
    {{ $emailTemplate->name }}
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{asset('css/summernote/summernote-lite.css')}}">
@endpush

@push('script-page')
    <script src="{{asset('css/summernote/summernote-lite.js')}}"></script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current=>{{ __('Email Template') }}</li>
@endsection
@section('action-btn')
{{--    <div class="float-end">--}}
{{--        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true"--}}
{{--           data-title="{{__('Create New Email Template')}}" title="{{__('Create')}}" data-url="{{route('email_template.create')}}">--}}
{{--            <i class="ti ti-plus"></i> </a>--}}
{{--    </div>--}}

<div class="row">
    <div class="col-lg-6">

    </div>
    <div class="col-lg-6">
        <div class="text-end">
            <div class="d-flex justify-content-end drp-languages">
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="email-color dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                           href="#" role="button" aria-haspopup="false" aria-expanded="false"
                           id="dropdownLanguage">
                            {{-- <i class="ti ti-world nocolor"></i> --}}
                            <span
                                class="email-color drp-text hide-mob text-primary">{{ Str::upper($currEmailTempLang->lang) }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                             aria-labelledby="dropdownLanguage">
                            @foreach ($languages as $lang)

                                <a href="{{ route('manage.email.language', [$emailTemplate->id, $lang]) }}"
                                   class="dropdown-item {{ $currEmailTempLang->lang == $lang ? 'text-primary' : '' }}">{{ Str::upper($lang) }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="email-color dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                           href="#" role="button" aria-haspopup="false" aria-expanded="false"
                           id="dropdownLanguage">
                                                <span
                                                    class="drp-text hide-mob text-primary">{{ __('Template: ') }}{{ $emailTemplate->name }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end email_temp" aria-labelledby="dropdownLanguage">
                            @foreach ($EmailTemplates as $EmailTemplate)
                                <a href="{{ route('manage.email.language', [$EmailTemplate->id,(Request::segment(3)?Request::segment(3):\Auth::user()->lang)]) }}"
                                   class="dropdown-item {{$EmailTemplate->name == $emailTemplate->name ? 'text-primary' : '' }}">{{ $EmailTemplate->name }}
                                </a>
                            @endforeach
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
@endsection


@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body ">
                    {{-- <div class="card"> --}}

                    {{Form::model($currEmailTempLang, array('route' => array('email_template.update', $currEmailTempLang->parent_id), 'method' => 'PUT')) }}
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h6 class="font-weight-bold pb-1">{{__('Place Holder')}}</h6>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row text-xs">

                                        @if($emailTemplate->slug=='create_user')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Email')}} : <span class="pull-right text-primary">{email}</span></p>
                                                <p class="col-4">{{__('Password')}} : <span class="pull-right text-primary">{password}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='create_client')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Client Name')}} : <span class="pull-right text-primary">{client_name}</span></p>
                                                <p class="col-4">{{__('Email')}} : <span class="pull-right text-primary">{client_email}</span></p>
                                                <p class="col-4">{{__('Password')}} : <span class="pull-right text-primary">{client_password}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='create_support')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('User Name')}} : <span class="pull-right text-primary">{support_name}</span></p>
                                                <p class="col-4">{{__('Support Title')}} : <span class="pull-right text-primary">{support_title}</span></p>
                                                <p class="col-4">{{__('Support Priority')}} : <span class="pull-right text-primary">{support_priority}</span></p>
                                                <p class="col-4">{{__('Support End Date')}} : <span class="pull-right text-primary">{support_end_date}</span></p>
                                                <p class="col-4">{{__('Support Description')}} : <span class="pull-right text-primary">{support_description}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='create_contract')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Contract Subject')}} : <span class="pull-right text-primary">{contract_subject}</span></p>
                                                <p class="col-4">{{__('Client Name')}} : <span class="pull-right text-primary">{contract_client}</span></p>
                                                <p class="col-4">{{__('Contract Title')}} : <span class="pull-right text-primary">{contract_value}</span></p>
                                                <p class="col-4">{{__('Contract Priority')}} : <span class="pull-right text-primary">{contract_start_date}</span></p>
                                                <p class="col-4">{{__('Contract End Date')}} : <span class="pull-right text-primary">{contract_end_date}</span></p>
                                                <p class="col-4">{{__('Contract Description')}} : <span class="pull-right text-primary">{contract_description}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='lead_assign')
                                            <div class="row">
                                                <p class="col-4">{{__('Lead Name')}} : <span class="pull-right text-primary">{lead_name}</span></p>
                                                <p class="col-4">{{__('Lead Email')}} : <span class="pull-right text-primary">{lead_email}</span></p>
                                                <p class="col-4">{{__('Lead Subject')}} : <span class="pull-right text-primary">{lead_subject}</span></p>
                                                <p class="col-4">{{__('Lead Pipeline')}} : <span class="pull-right text-primary">{lead_pipeline}</span></p>
                                                <p class="col-4">{{__('Lead Stage')}} : <span class="pull-right text-primary">{lead_stage}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='deal_assign')
                                            <div class="row">
                                                <p class="col-4">{{__('Deal Name')}} : <span class="pull-right text-primary">{deal_name}</span></p>
                                                <p class="col-4">{{__('Deal Pipeline')}} : <span class="pull-right text-primary">{deal_pipeline}</span></p>
                                                <p class="col-4">{{__('Deal Stage')}} : <span class="pull-right text-primary">{deal_stage}</span></p>
                                                <p class="col-4">{{__('Deal Status')}} : <span class="pull-right text-primary">{deal_status}</span></p>
                                                <p class="col-4">{{__('Deal Price')}} : <span class="pull-right text-primary">{deal_price}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='award_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Award Name')}} : <span class="pull-right text-primary">{award_name}</span></p>
                                                <p class="col-4">{{__('Award Email')}} : <span class="pull-right text-primary">{award_email}</span></p>
                                            </div>

                                        @elseif($emailTemplate->slug=='customer_invoice_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Customer Name')}} : <span class="pull-right text-primary">{customer_name}</span></p>
                                                <p class="col-4">{{__('Customer Email')}} : <span class="pull-right text-primary">{customer_email}</span></p>
                                                <p class="col-4">{{__('Invoice Name')}} : <span class="pull-right text-primary">{invoice_name}</span></p>
                                                <p class="col-4">{{__('Invoice Number')}} : <span class="pull-right text-primary">{invoice_number}</span></p>
                                                <p class="col-4">{{__('Invoice Url')}} : <span class="pull-right text-primary">{invoice_url}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='invoice_payment')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Customer Name')}} : <span class="pull-right text-primary">{invoice_payment_name}</span></p>
                                                <p class="col-4">{{__('Invoice Payment')}} : <span class="pull-right text-primary">{invoice_payment}</span></p>
                                                <p class="col-4">{{__('Invoice Payment Amount')}} : <span class="pull-right text-primary">{invoice_payment_amount}</span></p>
                                                <p class="col-4">{{__('Invoice Payment Date')}} : <span class="pull-right text-primary">{invoice_payment_date}</span></p>
                                                <p class="col-4">{{__('Invoice Payment Method')}} : <span class="pull-right text-primary">{invoice_payment_method}</span></p>

                                            </div>
                                        @elseif($emailTemplate->slug=='payment_reminder')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Customer Name')}} : <span class="pull-right text-primary">{customer_name}</span></p>
                                                <p class="col-4">{{__('Customer Email')}} : <span class="pull-right text-primary">{customer_email}</span></p>
                                                <p class="col-4">{{__('Payment Reminder Name')}} : <span class="pull-right text-primary">{payment_reminder_name}</span></p>
                                                <p class="col-4">{{__('Invoice Payment Number')}} : <span class="pull-right text-primary">{invoice_payment_number}</span></p>
                                                <p class="col-4">{{__('Payment Due Amount')}} : <span class="pull-right text-primary">{invoice_payment_dueAmount}</span></p>
                                                <p class="col-4">{{__('Payment Reminder Date')}} : <span class="pull-right text-primary">{payment_reminder_date}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='bill_payment')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Payment Name')}} : <span class="pull-right text-primary">{payment_name}</span></p>
                                                <p class="col-4">{{__('Payment Bill')}} : <span class="pull-right text-primary">{payment_bill}</span></p>
                                                <p class="col-4">{{__('Payment Amount')}} : <span class="pull-right text-primary">{payment_amount}</span></p>
                                                <p class="col-4">{{__('Payment Date')}} : <span class="pull-right text-primary">{payment_date}</span></p>
                                                <p class="col-4">{{__('Payment Method')}} : <span class="pull-right text-primary">{payment_method}</span></p>

                                            </div>
                                        @elseif($emailTemplate->slug=='bill_resend')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Vendor Name')}} : <span class="pull-right text-primary">{vender_name}</span></p>
                                                <p class="col-4">{{__('Vendor Email')}} : <span class="pull-right text-primary">{vender_email}</span></p>
                                                <p class="col-4">{{__('Bill Name')}} : <span class="pull-right text-primary">{bill_name}</span></p>
                                                <p class="col-4">{{__('Bill Number')}} : <span class="pull-right text-primary">{bill_number}</span></p>
                                                <p class="col-4">{{__('Bill Url')}} : <span class="pull-right text-primary">{bill_url}</span></p>

                                            </div>
                                        @elseif($emailTemplate->slug=='proposal_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Proposal Name')}} : <span class="pull-right text-primary">{proposal_name}</span></p>
                                                <p class="col-4">{{__('Proposal Email')}} : <span class="pull-right text-primary">{proposal_number}</span></p>
                                                <p class="col-4">{{__('Proposal Url')}} : <span class="pull-right text-primary">{proposal_url}</span></p>


                                            </div>
                                        @elseif($emailTemplate->slug=='complaint_resend')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Complaint Name')}} : <span class="pull-right text-primary">{complaint_name}</span></p>
                                                <p class="col-4">{{__('Complaint Title')}} : <span class="pull-right text-primary">{complaint_title}</span></p>
                                                <p class="col-4">{{__('Complaint Against')}} : <span class="pull-right text-primary">{complaint_against}</span></p>
                                                <p class="col-4">{{__('Complaint Date')}} : <span class="pull-right text-primary">{complaint_date}</span></p>
                                                <p class="col-4">{{__('Complaint Date')}} : <span class="pull-right text-primary">{complaint_description}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='leave_action_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Leave Name')}} : <span class="pull-right text-primary">{leave_name}</span></p>
                                                <p class="col-4">{{__('Leave Status')}} : <span class="pull-right text-primary">{leave_status}</span></p>
                                                <p class="col-4">{{__('Leave Reason')}} : <span class="pull-right text-primary">{leave_reason}</span></p>
                                                <p class="col-4">{{__('Leave Start Date')}} : <span class="pull-right text-primary">{leave_start_date}</span></p>
                                                <p class="col-4">{{__('Leave End Date')}} : <span class="pull-right text-primary">{leave_end_date}</span></p>
                                                <p class="col-4">{{__('Leave Days')}} : <span class="pull-right text-primary">{total_leave_days}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='payslip_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{employee_name}</span></p>
                                                <p class="col-4">{{__('Employee Email')}} : <span class="pull-right text-primary">{employee_email}</span></p>
                                                <p class="col-4">{{__('Payslip Name')}} : <span class="pull-right text-primary">{payslip_name}</span></p>
                                                <p class="col-4">{{__('Payslip Salary Month ')}} : <span class="pull-right text-primary">{payslip_salary_month}</span></p>
                                                <p class="col-4">{{__('Payslip Url')}} : <span class="pull-right text-primary">{payslip_url}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='promotion_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p clss="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{employee_name}</span></p>
                                                <p class="col-4">{{__('Designation')}} : <span class="pull-right text-primary">{promotion_designation}</span></p>
                                                <p class="col-4">{{__('Promotion Title')}} : <span class="pull-right text-primary">{promotion_title}</span></p>
                                                <p class="col-4">{{__('Promotion Date')}} : <span class="pull-right text-primary">{promotion_date}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='resignation_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                {{--                                        <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{employee_name}</span></p>--}}
                                                <p class="col-4">{{__('Employee Email')}} : <span class="pull-right text-primary">{resignation_email}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{assign_user}</span></p>
                                                <p class="col-4">{{__('Last Working Date')}} : <span class="pull-right text-primary">{resignation_date}</span></p>
                                                <p class="col-4">{{__('Resignation Date')}} : <span class="pull-right text-primary">{notice_date}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='termination_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{termination_name}</span></p>
                                                <p class="col-4">{{__('Employee Email')}} : <span class="pull-right text-primary">{termination_email}</span></p>
                                                <p class="col-4">{{__('Notice Date')}} : <span class="pull-right text-primary">{notice_date}</span></p>
                                                <p class="col-4">{{__('Termination Date')}} : <span class="pull-right text-primary">{termination_date}</span></p>
                                                <p class="col-4">{{__('Termination Type')}} : <span class="pull-right text-primary">{termination_type}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='transfer_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{transfer_name}</span></p>
                                                <p class="col-4">{{__('Employee Email')}} : <span class="pull-right text-primary">{transfer_email}</span></p>
                                                <p class="col-4">{{__('Transfer Date')}} : <span class="pull-right text-primary">{transfer_date}</span></p>
                                                <p class="col-4">{{__('Transfer Department')}} : <span class="pull-right text-primary">{transfer_department}</span></p>
                                                <p class="col-4">{{__('Transfer Branch')}} : <span class="pull-right text-primary">{transfer_branch}</span></p>
                                                <p class="col-4">{{__('Transfer Desciption')}} : <span class="pull-right text-primary">{transfer_description}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='trip_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee ')}} : <span class="pull-right text-primary">{trip_name}</span></p>
                                                <p class="col-4">{{__('Purpose of Trip')}} : <span class="pull-right text-primary">{purpose_of_visit}</span></p>
                                                <p class="col-4">{{__('Start Date')}} : <span class="pull-right text-primary">{start_date}</span></p>
                                                <p class="col-4">{{__('End Date')}} : <span class="pull-right text-primary">{end_date}</span></p>
                                                <p class="col-4">{{__('Country')}} : <span class="pull-right text-primary">{place_of_visit}</span></p>
                                                <p class="col-4">{{__('Description')}} : <span class="pull-right text-primary">{trip_description}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='vender_bill_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Vendor Name')}} : <span class="pull-right text-primary">{vender_bill_name}</span></p>
                                                <p class="col-4">{{__('Bill Number')}} : <span class="pull-right text-primary">{vender_bill_number}</span></p>
                                                <p class="col-4">{{__('Bill Url')}} : <span class="pull-right text-primary">{vender_bill_url}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='warning_send')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{employee_warning_name}</span></p>
                                                <p class="col-4">{{__('Subject')}} : <span class="pull-right text-primary">{warning_subject}</span></p>
                                                <p class="col-4">{{__('Description')}} : <span class="pull-right text-primary">{warning_description}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='create_consultant')
                                            <div class="row">
                                                <p class="col-4">{{__('App Name')}} :
                                                    <span class="pull-end text-primary">{app_name}</span>
                                                </p>
                                                <p class="col-4">{{__('Company Name')}} :
                                                    <span class="pull-right text-primary">{company_name}</span>
                                                </p>
                                                <p class="col-4">{{__('App Url')}} :
                                                    <span class="pull-right text-primary">{app_url}</span>
                                                </p>
                                                <p class="col-4">{{__('Email')}} :
                                                    <span class="pull-right text-primary">{email}</span>
                                                </p>
                                                <p class="col-4">{{__('Password')}} :
                                                    <span class="pull-right text-primary">{password}</span>
                                                </p>
                                            </div>

                                            @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-6">
                            {{\Auth::user()->creatorId()}}
                            {{ Form::label('subject', __('Subject'), ['class' => 'col-form-label text-dark']) }}
                            {{ Form::text('subject', null, ['class' => 'form-control font-style', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('from', __('From'), ['class' => 'col-form-label text-dark']) }}
                            {{ Form::text('from', $emailTemplate->from, ['class' => 'form-control font-style', 'required' => 'required']) }}
                        </div>


                        <div class="form-group col-12">
                            {{ Form::label('content', __('Email Message'), ['class' => 'col-form-label text-dark']) }}
                            {{ Form::textarea('content', $currEmailTempLang->content, ['class' => 'summernote-simple', 'required' => 'required']) }}
                        </div>


                        <div class="modal-footer">
                            {{ Form::hidden('lang', null) }}
                            {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                        </div>

                        {{ Form::close() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

