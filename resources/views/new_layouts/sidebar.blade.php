<div class="col-3 d-none d-md-block border-end">
    <div class="card-body">
        <!-- <h4 class="subheader">Business settings</h4> -->
        <div class="list-group list-group-transparent">
            <a href="/new_profile"  class="list-group-item list-group-item-action d-flex align-items-center">My Account</a>
            <a href="{{ route('systemsettings') }}"  class="{{request()->route()->uri =='system-settings' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('System Setting') }} </a>
            <a href="{{ route('companysettings') }}"  class="{{request()->route()->uri =='company-settings' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Company Setting') }} </a>
            <a href="{{ route('emailsettings') }}"  class="{{request()->route()->uri =='email-settings' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Email Notification') }} </a>

            <a href="{{ route('order.index') }}"  class="{{request()->route()->uri =='orders' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Orders') }} </a>
            <a href="/plans"  class="{{request()->route()->uri =='plans' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Setup Subscription Plan') }} </a>
        </div>
        <!-- <h4 class="subheader mt-4">Experience</h4> -->
        <div class="list-group list-group-transparent">
            <a href="#" class="list-group-item list-group-item-action">Give Feedback</a>
        </div>

        </div>
    </div>
