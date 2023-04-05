<div class="col-3 d-none d-md-block border-end">
<div class="card-body">
    <h4 class="subheader">Business settings</h4>
    <div class="list-group list-group-transparent">
        <a href="./settings.html"  class="list-group-item list-group-item-action d-flex align-items-center">My Account</a>
        <a href="{{ route('systemsettings') }}"  class="{{request()->route()->uri =='system-settings' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('System Setting') }} </a>
        <a href="{{ route('companysettings') }}"  class="{{request()->route()->uri =='company-settings' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Company Setting') }} </a>
        <a href="{{ route('emailsettings') }}"  class="{{request()->route()->uri =='email-settings' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Email Notification') }} </a>
        <a href="{{ route('emailsettings') }}"  class="list-group-item list-group-item-action d-flex align-items-center {{ Request::segment(1) == 'email_template' || Request::route()->getName() == 'manage.email.language' ? ' active' : '' }}">{{ __('Email Template') }} </a>
        <a href="#"  class="list-group-item list-group-item-action d-flex align-items-center">Connected  Apps</a>
        <a href="./settings-plan.html" class="list-group-item list-group-item-action d-flex align-items-center">Plans</a>
        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">Billing & Invoices</a>
    </div>
    <h4 class="subheader mt-4">Experience</h4>
    <div class="list-group list-group-transparent">
        <a href="#" class="list-group-item list-group-item-action">Give Feedback</a>
    </div>
</div>
</div>