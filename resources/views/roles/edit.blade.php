<style>
    .modal-content {
        width: 907px !important;
    }
</style>
{{ Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}<span style='color:red;'>*</span>
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Role Name'), 'required' => 'required']) }}
                @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-staff-tab" data-bs-toggle="pill" href="#staff" role="tab"
                        aria-controls="pills-home" aria-selected="true">{{ __('Staff') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-crm-tab" data-bs-toggle="pill" href="#crm" role="tab"
                        aria-controls="pills-profile" aria-selected="false">{{ __('CRM') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-project-tab" data-bs-toggle="pill" href="#project1" role="tab"
                        aria-controls="pills-contact" aria-selected="false">{{ __('Planning') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-diary-tab" data-bs-toggle="pill" href="#diary" role="tab"
                        aria-controls="pills-contact" aria-selected="false">{{ __('Diary') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-hrmpermission-tab" data-bs-toggle="pill" href="#hrmpermission"
                        role="tab" aria-controls="pills-contact" aria-selected="false">{{ __('HRM') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-account-tab" data-bs-toggle="pill" href="#account" role="tab"
                        aria-controls="pills-contact" aria-selected="false">{{ __('Account') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-consultant-tab" data-bs-toggle="pill" href="#consultant1"
                        role="tab" aria-controls="pills-contact" aria-selected="false">
                        {{ __('Consultant') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-sub_contractor-tab" data-bs-toggle="pill" href="#subContractor"
                        role="tab" aria-controls="pills-contact" aria-selected="false">
                        {{ __('Sub Contractor') }}
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="staff" role="tabpanel" aria-labelledby="pills-home-tab">
                    @php
                        // $modules=['user','role','client','product & service','constant unit','constant tax','constant category','company settings'];
                        $modules = ['user', 'role', 'client', 'company settings'];
                        if (\Auth::user()->type == 'company') {
                            //    $modules[] = 'language';
                            $modules[] = 'permission';
                        }
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign General Permission to Roles') }}<span
                                        style='color:red;'>*</span></h6>
                                <table class="table table-striped mb-0" id="">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox"
                                                    class="form-check-input align-middle custom_align_middle"
                                                    name="staff_checkall" id="staff_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td><input type="checkbox"
                                                        class="form-check-input align-middle ischeck staff_checkall"
                                                        data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}"
                                                        id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">
                                                </td>
                                                <td><label class="ischeck staff_checkall"
                                                        data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }} "
                                                        for="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">{{ ucfirst($module) }}</label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Add', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('move ' . $module, (array) $permissions))
                                                            @if ($key = array_search('move ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Move', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Manage', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Edit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Show', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('send ' . $module, (array) $permissions))
                                                            @if ($key = array_search('send ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Send', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('create payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income vs expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income vs expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income VS Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('loss & profit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('loss & profit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Loss & Profit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('tax ' . $module, (array) $permissions))
                                                            @if ($key = array_search('tax ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Tax', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('invoice ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invoice ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Invoice', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('bill ' . $module, (array) $permissions))
                                                            @if ($key = array_search('bill ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Bill', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('duplicate ' . $module, (array) $permissions))
                                                            @if ($key = array_search('duplicate ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Duplicate', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('balance sheet ' . $module, (array) $permissions))
                                                            @if ($key = array_search('balance sheet ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Balance Sheet', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('ledger ' . $module, (array) $permissions))
                                                            @if ($key = array_search('ledger ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Ledger', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('trial balance ' . $module, (array) $permissions))
                                                            @if ($key = array_search('trial balance ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input staff_checkall isscheck_' . str_replace(' ', '', str_replace('&', '', $module)), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Trial Balance', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="crm" role="tabpanel" aria-labelledby="pills-profile-tab">
                    @php
                        $modules = ['lead', 'pipeline', 'lead stage', 'source', 'label', 'deal', 'stage', 'task', 'form builder', 'form response', 'contract', 'contract type'];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign CRM related Permission to Roles') }}</h6>
                                <table class="table table-striped mb-0" id="">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox"
                                                    class="form-check-input align-middle custom_align_middle"
                                                    name="crm_checkall" id="crm_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td><input type="checkbox"
                                                        class="form-check-input align-middle ischeck crm_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        id="{{ str_replace(' ', '', $module) }}"></td>
                                                <td><label class="ischeck crm_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        for="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Add', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('move ' . $module, (array) $permissions))
                                                            @if ($key = array_search('move ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Move', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Manage', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Edit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Show', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('send ' . $module, (array) $permissions))
                                                            @if ($key = array_search('send ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Send', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('create payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income vs expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income vs expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income VS Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('loss & profit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('loss & profit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Loss & Profit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('tax ' . $module, (array) $permissions))
                                                            @if ($key = array_search('tax ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Tax', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('invoice ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invoice ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Invoice', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('bill ' . $module, (array) $permissions))
                                                            @if ($key = array_search('bill ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Bill', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('duplicate ' . $module, (array) $permissions))
                                                            @if ($key = array_search('duplicate ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Duplicate', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('balance sheet ' . $module, (array) $permissions))
                                                            @if ($key = array_search('balance sheet ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Balance Sheet', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('ledger ' . $module, (array) $permissions))
                                                            @if ($key = array_search('ledger ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Ledger', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('trial balance ' . $module, (array) $permissions))
                                                            @if ($key = array_search('trial balance ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input crm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Trial Balance', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="project1" role="tabpanel" aria-labelledby="pills-contact-tab">
                    {{-- @php
                        $modules=['project dashboard','project','milestone','grant chart','project stage','timesheet','expense','project task','activity','CRM activity','project task stage','bug report','bug status'];
                    @endphp --}}
                    @php
                        //  $modules=['project dashboard','project','milestone','grant chart','project stage','timesheet','expense','project task','activity','CRM activity','project task stage','directions','project specification','procurement material','vochange','RFI','concrete','site reports'];
                        $modules = ['project dashboard', 'project', 'grant chart', 'project task', 'revision', 'lookahead schedule', 'lookahead grant chart', 'active lookahead', 'activity','engineers', 'consultant project invitation', 'sub contractor project invitation','revised program','overall report','project holiday'];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign Project related Permission to Roles') }}</h6>
                                <table class="table table-striped mb-0" id="">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox"
                                                    class="form-check-input align-middle custom_align_middle"
                                                    name="project_checkall" id="project_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td><input type="checkbox"
                                                        class="form-check-input align-middle ischeck project_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        id="{{ str_replace(' ', '', $module) }}"></td>
                                                <td><label class="ischeck project_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        for="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Add', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('move ' . $module, (array) $permissions))
                                                            @if ($key = array_search('move ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Move', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('schedule ' . $module, (array) $permissions))
                                                            @if ($key = array_search('schedule ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Schedule', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('export ' . $module, (array) $permissions))
                                                        @if ($key = array_search('export ' . $module, $permissions))
                                                            <div class="col-md-3 custom-control custom-checkbox">
                                                                {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                {{ Form::label('permission' . $key, 'Export', ['class' => 'custom-control-label']) }}<br>
                                                            </div>
                                                        @endif
                                                    @endif

                                                        @if (in_array('invite ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invite ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input isscheck
                                                                                                                            project_checkall isscheck_' . str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'Invite', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Manage', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('lookahead ' . $module, (array) $permissions))
                                                            @if ($key = array_search('lookahead ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'view', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Edit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Show', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('send ' . $module, (array) $permissions))
                                                            @if ($key = array_search('send ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Send', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('create payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income vs expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income vs expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income VS Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('loss & profit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('loss & profit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Loss & Profit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('tax ' . $module, (array) $permissions))
                                                            @if ($key = array_search('tax ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Tax', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('invoice ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invoice ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Invoice', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('bill ' . $module, (array) $permissions))
                                                            @if ($key = array_search('bill ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Bill', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('duplicate ' . $module, (array) $permissions))
                                                            @if ($key = array_search('duplicate ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Duplicate', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('balance sheet ' . $module, (array) $permissions))
                                                            @if ($key = array_search('balance sheet ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Balance Sheet', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('ledger ' . $module, (array) $permissions))
                                                            @if ($key = array_search('ledger ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Ledger', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('trial balance ' . $module, (array) $permissions))
                                                            @if ($key = array_search('trial balance ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input project_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Trial Balance', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="diary" role="tabpanel" aria-labelledby="pills-profile-tab">
                    @php
                        $modules = ['directions', 'project specification', 'procurement material', 'vochange', 'RFI', 'concrete', 'site reports'];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign Diary related Permission to Roles') }}</h6>
                                <table class="table table-striped mb-0" id="">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox"
                                                    class="form-check-input align-middle custom_align_middle"
                                                    name="diary_checkall" id="diary_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td><input type="checkbox"
                                                        class="form-check-input align-middle ischeck diary_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        id="{{ str_replace(' ', '', $module) }}"></td>
                                                <td><label class="ischeck diary_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        for="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Add', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('move ' . $module, (array) $permissions))
                                                            @if ($key = array_search('move ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Move', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('invite ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invite ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input isscheck
                                                                            diary_checkall isscheck_' .
                                                                            str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'Invite', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Manage', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Edit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Show', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('send ' . $module, (array) $permissions))
                                                            @if ($key = array_search('send ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Send', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('create payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income vs expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income vs expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income VS Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('loss & profit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('loss & profit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Loss & Profit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('tax ' . $module, (array) $permissions))
                                                            @if ($key = array_search('tax ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Tax', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('invoice ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invoice ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Invoice', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('bill ' . $module, (array) $permissions))
                                                            @if ($key = array_search('bill ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Bill', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('duplicate ' . $module, (array) $permissions))
                                                            @if ($key = array_search('duplicate ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Duplicate', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('balance sheet ' . $module, (array) $permissions))
                                                            @if ($key = array_search('balance sheet ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Balance Sheet', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('ledger ' . $module, (array) $permissions))
                                                            @if ($key = array_search('ledger ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Ledger', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('trial balance ' . $module, (array) $permissions))
                                                            @if ($key = array_search('trial balance ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input diary_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Trial Balance', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="hrmpermission" role="tabpanel" aria-labelledby="pills-contact-tab">
                    {{-- @php
                        $modules=['hrm dashboard','employee','employee profile','department','designation','branch','document type','document','payslip type','allowance','commission','allowance option','loan option','deduction option','loan','saturation deduction','other payment','overtime','set salary','pay slip','company policy','appraisal','goal tracking','goal type','indicator','event','meeting','training','trainer','training type','award','award type','resignation','travel','promotion','complaint','warning','termination','termination type','job application','job application note','job onBoard','job category','job','job stage','custom question','interview schedule','estimation','holiday','transfer','announcement','leave','leave type','attendance'];
                    @endphp --}}
                    @php
                        $modules = ['hrm dashboard', 'employee', 'employee profile', 'department', 'designation', 'branch', 'document type', 'document', 'payslip type', 'allowance', 'commission', 'allowance option', 'loan option', 'deduction option', 'loan', 'saturation deduction', 'other payment', 'overtime', 'set salary', 'pay slip', 'company policy', 'goal tracking', 'goal type', 'event', 'meeting', 'training', 'trainer', 'training type', 'award', 'award type', 'resignation', 'travel', 'promotion', 'complaint', 'warning', 'termination', 'termination type', 'job application', 'job application note', 'job onBoard', 'job category', 'job', 'job stage', 'custom question', 'interview schedule', 'estimation', 'holiday', 'transfer', 'announcement', 'leave', 'leave type', 'attendance'];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign HRM related Permission to Roles') }}</h6>
                                <table class="table table-striped mb-0" id="">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox"
                                                    class="form-check-input align-middle custom_align_middle"
                                                    name="hrm_checkall" id="hrm_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td><input type="checkbox"
                                                        class="form-check-input align-middle ischeck hrm_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        id="{{ str_replace(' ', '', $module) }}"></td>
                                                <td><label class="ischeck hrm_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        for="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Add', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('move ' . $module, (array) $permissions))
                                                            @if ($key = array_search('move ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Move', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Manage', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Edit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Show', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('send ' . $module, (array) $permissions))
                                                            @if ($key = array_search('send ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Send', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('create payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income vs expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income vs expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income VS Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('loss & profit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('loss & profit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Loss & Profit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('tax ' . $module, (array) $permissions))
                                                            @if ($key = array_search('tax ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Tax', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('invoice ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invoice ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Invoice', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('bill ' . $module, (array) $permissions))
                                                            @if ($key = array_search('bill ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Bill', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('duplicate ' . $module, (array) $permissions))
                                                            @if ($key = array_search('duplicate ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Duplicate', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('balance sheet ' . $module, (array) $permissions))
                                                            @if ($key = array_search('balance sheet ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Balance Sheet', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('ledger ' . $module, (array) $permissions))
                                                            @if ($key = array_search('ledger ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Ledger', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('trial balance ' . $module, (array) $permissions))
                                                            @if ($key = array_search('trial balance ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input hrm_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Trial Balance', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="pills-contact-tab">
                    @php
                        $modules = ['account dashboard', 'proposal', 'invoice', 'bill', 'revenue', 'payment', 'proposal product', 'invoice product', 'bill product', 'goal', 'credit note', 'debit note', 'bank account', 'bank transfer', 'transaction', 'customer', 'vender', 'constant custom field', 'assets', 'chart of account', 'journal entry', 'report'];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign Account related Permission to Roles') }}</h6>
                                <table class="table table-striped mb-0" id="">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox"
                                                    class="form-check-input align-middle custom_align_middle"
                                                    name="account_checkall" id="account_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td><input type="checkbox"
                                                        class="form-check-input align-middle ischeck account_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        id="{{ str_replace(' ', '', $module) }}"></td>
                                                <td><label class="ischeck account_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        for="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Add', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('move ' . $module, (array) $permissions))
                                                            @if ($key = array_search('move ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Move', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Manage', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Edit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Show', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif


                                                        @if (in_array('send ' . $module, (array) $permissions))
                                                            @if ($key = array_search('send ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Send', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('create payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('delete payment ' . $module, (array) $permissions))
                                                            @if ($key = array_search('delete payment ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Delete Payment', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('income vs expense ' . $module, (array) $permissions))
                                                            @if ($key = array_search('income vs expense ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Income VS Expense', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('loss & profit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('loss & profit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Loss & Profit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('tax ' . $module, (array) $permissions))
                                                            @if ($key = array_search('tax ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Tax', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('invoice ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invoice ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Invoice', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('bill ' . $module, (array) $permissions))
                                                            @if ($key = array_search('bill ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Bill', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('duplicate ' . $module, (array) $permissions))
                                                            @if ($key = array_search('duplicate ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Duplicate', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('balance sheet ' . $module, (array) $permissions))
                                                            @if ($key = array_search('balance sheet ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Balance Sheet', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('ledger ' . $module, (array) $permissions))
                                                            @if ($key = array_search('ledger ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Ledger', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('trial balance ' . $module, (array) $permissions))
                                                            @if ($key = array_search('trial balance ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input account_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Trial Balance', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="consultant1" role="tabpanel" aria-labelledby="pills-contact-tab">
                    @php
                        $modules = ['consultant'];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign Consultant related Permission to Roles') }}</h6>
                                <table class="table table-striped mb-0" id="">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox"
                                                    class="form-check-input align-middle custom_align_middle"
                                                    name="consultant_checkall" id="consultant_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td><input type="checkbox"
                                                        class="form-check-input align-middle ischeck consultant_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        id="{{ str_replace(' ', '', $module) }}"></td>
                                                <td><label class="ischeck consultant_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        for="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input consultant_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input consultant_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Add', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input consultant_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input consultant_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Create', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input consultant_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Edit', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('invite ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invite ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input consultant_checkall
                                                                                                                                isscheck_' . str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'Invite', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input consultant_checkall isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                                    {{ Form::label('permission' . $key, 'Show', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="subContractor" role="tabpanel" aria-labelledby="pills-contact-tab">
                    @php
                        $modules = ['sub contractor'];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (!empty($permissions))
                                <h6 class="my-3">{{ __('Assign Sub Contractor related Permission to Roles') }}</h6>
                                <table class="table table-striped mb-0" id=""
                                    aria-describedby="edit sub contractor">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox"
                                                    class="form-check-input
                                             align-middle custom_align_middle"
                                                    name="sub_contractor_checkall" id="sub_contractor_checkall">
                                            </th>
                                            <th>{{ __('Module') }} </th>
                                            <th>{{ __('Permissions') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                        class="form-check-input align-middle
                                                 ischeck sub_contractor_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        id="{{ str_replace(' ', '', $module) }}">
                                                </td>
                                                <td>
                                                    <label class="ischeck sub_contractor_checkall"
                                                        data-id="{{ str_replace(' ', '', $module) }}"
                                                        for="{{ str_replace(' ', '', $module) }}">
                                                        {{ ucfirst($module) }}
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="row ">
                                                        @if (in_array('view ' . $module, (array) $permissions))
                                                            @if ($key = array_search('view ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input
                                                                                                                                     sub_contractor_checkall isscheck_' .
                                                                            str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('add ' . $module, (array) $permissions))
                                                            @if ($key = array_search('add ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input
                                                                                                                                     sub_contractor_checkall isscheck_' .
                                                                            str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'Add', ['class' => 'custom-control-label']) }}<br>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if (in_array('manage ' . $module, (array) $permissions))
                                                            @if ($key = array_search('manage ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input
                                                                                                                                     sub_contractor_checkall isscheck_' .
                                                                            str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'View', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('create ' . $module, (array) $permissions))
                                                            @if ($key = array_search('create ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input
                                                                                                                                      sub_contractor_checkall isscheck_' .
                                                                            str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'Create', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('edit ' . $module, (array) $permissions))
                                                            @if ($key = array_search('edit ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input
                                                                                                                                     sub_contractor_checkall isscheck_' .
                                                                            str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'Edit', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('invite ' . $module, (array) $permissions))
                                                            @if ($key = array_search('invite ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input
                                                                                                                                     sub_contractor_checkall isscheck_' .
                                                                            str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'Invite', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (in_array('show ' . $module, (array) $permissions))
                                                            @if ($key = array_search('show ' . $module, $permissions))
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    {{ Form::checkbox('permissions[]', $key, $role->permission, [
                                                                        'class' =>
                                                                            'form-check-input sub_contractor_checkall
                                                                                                                                     isscheck_' . str_replace(' ', '', $module),
                                                                        'id' => 'permission' . $key,
                                                                    ]) }}
                                                                    {{ Form::label('permission' . $key, 'Show', ['class' => 'custom-control-label']) }}
                                                                    <br>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary" id="edit_role">
</div>

{{ Form::close() }}

<script>
    $(document).ready(function() {
        var user = $(".isscheck_user");
        var count_user = 1;
        user.filter((e) => {
            if (!user[e].checked) {
                count_user--;
            }
        });
        if (count_user == 1) {
            $("#user").prop('checked', true);
        }

        var role = $(".isscheck_role");
        var count_role = 1;
        role.filter((e) => {
            if (!role[e].checked) {
                count_role--;
            }
        });
        if (count_role == 1) {
            $("#role").prop('checked', true);
        }

        var client = $(".isscheck_client");
        var count_client = 1;
        client.filter((e) => {
            if (!client[e].checked) {
                count_client--;
            }
        });
        if (count_client == 1) {
            $("#client").prop('checked', true);
        }

        var productservice = $(".isscheck_productservice");
        var count_productservice = 1;
        productservice.filter((e) => {
            if (!productservice[e].checked) {
                count_productservice--;
            }
        });
        if (count_productservice == 1) {
            $("#productservice").prop('checked', true);
        }

        var constantunit = $(".isscheck_constantunit");
        var count_constantunit = 1;
        constantunit.filter((e) => {
            if (!constantunit[e].checked) {
                count_constantunit--;
            }
        });
        if (count_constantunit == 1) {
            $("#constantunit").prop('checked', true);
        }
        var constanttax = $(".isscheck_constanttax");
        var count_constanttax = 1;
        constanttax.filter((e) => {
            if (!constanttax[e].checked) {
                count_constanttax--;
            }
        });
        if (count_constanttax == 1) {
            $("#constanttax").prop('checked', true);
        }


        var constantcategory = $(".isscheck_constantcategory");
        var count_constantcategory = 1;
        constantcategory.filter((e) => {
            if (!constantcategory[e].checked) {
                count_constantcategory--;
            }
        });
        if (count_constantcategory == 1) {
            $("#constantcategory").prop('checked', true);
        }

        var companysettings = $(".isscheck_companysettings");
        var count_companysettings = 1;
        companysettings.filter((e) => {
            if (!companysettings[e].checked) {
                count_companysettings--;
            }
        });
        if (count_companysettings == 1) {
            $("#companysettings").prop('checked', true);
        }


        var language = $(".isscheck_language");
        var count_language = 1;
        language.filter((e) => {
            if (!language[e].checked) {
                count_language--;
            }
        });
        if (count_language == 1) {
            $("#language").prop('checked', true);
        }
        var permission = $(".isscheck_permission");
        var count_permission = 1;
        permission.filter((e) => {
            if (!permission[e].checked) {
                count_permission--;
            }
        });
        if (count_permission == 1) {
            $("#permission").prop('checked', true);
        }

        var lead = $(".isscheck_lead");
        var count_lead = 1;
        lead.filter((e) => {
            if (!lead[e].checked) {
                count_lead--;
            }
        });
        if (count_lead == 1) {
            $("#lead").prop('checked', true);
        }

        var pipeline = $(".isscheck_pipeline");
        var count_pipeline = 1;
        pipeline.filter((e) => {
            if (!pipeline[e].checked) {
                count_pipeline--;
            }
        });
        if (count_pipeline == 1) {
            $("#pipeline").prop('checked', true);
        }

        var leadstage = $(".isscheck_leadstage");
        var count_leadstage = 1;
        leadstage.filter((e) => {
            if (!leadstage[e].checked) {
                count_leadstage--;
            }
        });
        if (count_leadstage == 1) {
            $("#leadstage").prop('checked', true);
        }

        var source = $(".isscheck_source");
        var count_source = 1;
        source.filter((e) => {
            if (!source[e].checked) {
                count_source--;
            }
        });
        if (count_source == 1) {
            $("#source").prop('checked', true);
        }

        var label = $(".isscheck_label");
        var count_label = 1;
        label.filter((e) => {
            if (!label[e].checked) {
                count_label--;
            }
        });
        if (count_label == 1) {
            $("#label").prop('checked', true);
        }


        var stage = $(".isscheck_stage");
        var count_stage = 1;
        stage.filter((e) => {
            if (!stage[e].checked) {
                count_stage--;
            }
        });
        if (count_stage == 1) {
            $("#stage").prop('checked', true);
        }
        var task = $(".isscheck_task");
        var count_task = 1;
        task.filter((e) => {
            if (!task[e].checked) {
                count_task--;
            }
        });
        if (count_task == 1) {
            $("#task").prop('checked', true);
        }
        var formbuilder = $(".isscheck_formbuilder");
        var count_formbuilder = 1;
        formbuilder.filter((e) => {
            if (!formbuilder[e].checked) {
                count_formbuilder--;
            }
        });
        if (count_formbuilder == 1) {
            $("#formbuilder").prop('checked', true);
        }
        var formresponse = $(".isscheck_formresponse");
        var count_formresponse = 1;
        formresponse.filter((e) => {
            if (!formresponse[e].checked) {
                count_formresponse--;
            }
        });
        if (count_formresponse == 1) {
            $("#formresponse").prop('checked', true);
        }
        var contract = $(".isscheck_contract");
        var count_contract = 1;
        contract.filter((e) => {
            if (!contract[e].checked) {
                count_contract--;
            }
        });
        if (count_contract == 1) {
            $("#contract").prop('checked', true);
        }
        var contracttype = $(".isscheck_contracttype");
        var count_contracttype = 1;
        contracttype.filter((e) => {
            if (!contracttype[e].checked) {
                count_contracttype--;
            }
        });
        if (count_contracttype == 1) {
            $("#contracttype").prop('checked', true);
        }
        var projectdashboard = $(".isscheck_projectdashboard");
        var count_projectdashboard = 1;
        projectdashboard.filter((e) => {
            if (!projectdashboard[e].checked) {
                count_projectdashboard--;
            }
        });
        if (count_projectdashboard == 1) {
            $("#projectdashboard").prop('checked', true);
        }
        var project = $(".isscheck_project");
        var count_project = 1;
        project.filter((e) => {
            if (!project[e].checked) {
                count_project--;
            }
        });
        if (count_project == 1) {
            $("#project").prop('checked', true);
        }
        var milestone = $(".isscheck_milestone");
        var count_milestone = 1;
        milestone.filter((e) => {
            if (!milestone[e].checked) {
                count_milestone--;
            }
        });
        if (count_milestone == 1) {
            $("#milestone").prop('checked', true);
        }
        var grantchart = $(".isscheck_grantchart");
        var count_grantchart = 1;
        grantchart.filter((e) => {
            if (!grantchart[e].checked) {
                count_grantchart--;
            }
        });
        if (count_grantchart == 1) {
            $("#grantchart").prop('checked', true);
        }
        var directions = $(".isscheck_directions");
        var count_directions = 1;
        directions.filter((e) => {
            if (!directions[e].checked) {
                count_directions--;
            }
        });
        if (count_directions == 1) {
            $("#directions").prop('checked', true);
        }
        var projectspecification = $(".isscheck_projectspecification");
        var count_projectspecification = 1;
        projectspecification.filter((e) => {
            if (!projectspecification[e].checked) {
                count_projectspecification--;
            }
        });
        if (count_projectspecification == 1) {
            $("#projectspecification").prop('checked', true);
        }
        var procurementmaterial = $(".isscheck_procurementmaterial");
        var count_procurementmaterial = 1;
        procurementmaterial.filter((e) => {
            if (!procurementmaterial[e].checked) {
                count_procurementmaterial--;
            }
        });
        if (count_procurementmaterial == 1) {
            $("#procurementmaterial").prop('checked', true);
        }
        var vochange = $(".isscheck_vochange");
        var count_vochange = 1;
        vochange.filter((e) => {
            if (!vochange[e].checked) {
                count_vochange--;
            }
        });
        if (count_vochange == 1) {
            $("#vochange").prop('checked', true);
        }
        var rfi = $(".isscheck_rfi");
        var count_rfi = 1;
        rfi.filter((e) => {
            if (!rfi[e].checked) {
                count_rfi--;
            }
        });
        if (count_rfi == 1) {
            $("#rfi").prop('checked', true);
        }
        var concrete = $(".isscheck_concrete");
        var count_concrete = 1;
        concrete.filter((e) => {
            if (!concrete[e].checked) {
                count_concrete--;
            }
        });
        if (count_concrete == 1) {
            $("#concrete").prop('checked', true);
        }

        var projectstage = $(".isscheck_projectstage");
        var count_projectstage = 1;
        projectstage.filter((e) => {
            if (!projectstage[e].checked) {
                count_projectstage--;
            }
        });
        if (count_projectstage == 1) {
            $("#projectstage").prop('checked', true);
        }

        var timesheet = $(".isscheck_timesheet");
        var count_timesheet = 1;
        timesheet.filter((e) => {
            if (!timesheet[e].checked) {
                count_timesheet--;
            }
        });
        if (count_timesheet == 1) {
            $("#timesheet").prop('checked', true);
        }
        var expense = $(".isscheck_expense");
        var count_expense = 1;
        expense.filter((e) => {
            if (!expense[e].checked) {
                count_expense--;
            }
        });
        if (count_expense == 1) {
            $("#expense").prop('checked', true);
        }
        var projecttask = $(".isscheck_projecttask");
        var count_projecttask = 1;
        projecttask.filter((e) => {
            if (!projecttask[e].checked) {
                count_projecttask--;
            }
        });
        if (count_projecttask == 1) {
            $("#projecttask").prop('checked', true);
        }
        var activity = $(".isscheck_activity");
        var count_activity = 1;
        activity.filter((e) => {
            if (!activity[e].checked) {
                count_activity--;
            }
        });
        if (count_activity == 1) {
            $("#activity").prop('checked', true);
        }
        var CRMactivity = $(".isscheck_CRMactivity");
        var count_CRMactivity = 1;
        CRMactivity.filter((e) => {
            if (!CRMactivity[e].checked) {
                count_CRMactivity--;
            }
        });
        if (count_CRMactivity == 1) {
            $("#CRMactivity").prop('checked', true);
        }
        var projecttaskstage = $(".isscheck_projecttaskstage");
        var count_projecttaskstage = 1;
        projecttaskstage.filter((e) => {
            if (!projecttaskstage[e].checked) {
                count_projecttaskstage--;
            }
        });
        if (count_projecttaskstage == 1) {
            $("#projecttaskstage").prop('checked', true);
        }
        var bugreport = $(".isscheck_bugreport");
        var count_bugreport = 1;
        bugreport.filter((e) => {
            if (!bugreport[e].checked) {
                count_bugreport--;
            }
        });
        if (count_bugreport == 1) {
            $("#bugreport").prop('checked', true);
        }
        var bugstatus = $(".isscheck_bugstatus");
        var count_bugstatus = 1;
        bugstatus.filter((e) => {
            if (!bugstatus[e].checked) {
                count_bugstatus--;
            }
        });
        if (count_bugstatus == 1) {
            $("#bugstatus").prop('checked', true);
        }
        var hrmdashboard = $(".isscheck_hrmdashboard");
        var count_hrmdashboard = 1;
        hrmdashboard.filter((e) => {
            if (!hrmdashboard[e].checked) {
                count_hrmdashboard--;
            }
        });
        if (count_hrmdashboard == 1) {
            $("#hrmdashboard").prop('checked', true);
        }
        var employee = $(".isscheck_employee");
        var count_employee = 1;
        employee.filter((e) => {
            if (!employee[e].checked) {
                count_employee--;
            }
        });
        if (count_employee == 1) {
            $("#employee").prop('checked', true);
        }
        var employeeprofile = $(".isscheck_employeeprofile");
        var count_employeeprofile = 1;
        employeeprofile.filter((e) => {
            if (!employeeprofile[e].checked) {
                count_employeeprofile--;
            }
        });
        if (count_employeeprofile == 1) {
            $("#employeeprofile").prop('checked', true);
        }
        var department = $(".isscheck_department");
        var count_department = 1;
        department.filter((e) => {
            if (!department[e].checked) {
                count_department--;
            }
        });
        if (count_department == 1) {
            $("#department").prop('checked', true);
        }
        var designation = $(".isscheck_designation");
        var count_designation = 1;
        designation.filter((e) => {
            if (!designation[e].checked) {
                count_designation--;
            }
        });
        if (count_designation == 1) {
            $("#designation").prop('checked', true);
        }
        var branch = $(".isscheck_branch");
        var count_branch = 1;
        branch.filter((e) => {
            if (!branch[e].checked) {
                count_branch--;
            }
        });
        if (count_branch == 1) {
            $("#branch").prop('checked', true);
        }
        var documenttype = $(".isscheck_documenttype");
        var count_documenttype = 1;
        documenttype.filter((e) => {
            if (!documenttype[e].checked) {
                count_documenttype--;
            }
        });
        if (count_documenttype == 1) {
            $("#documenttype").prop('checked', true);
        }
        var document = $(".isscheck_document");
        var count_document = 1;
        document.filter((e) => {
            if (!document[e].checked) {
                count_document--;
            }
        });
        if (count_document == 1) {
            $("#document").prop('checked', true);
        }
        var paysliptype = $(".isscheck_paysliptype");
        var count_paysliptype = 1;
        paysliptype.filter((e) => {
            if (!paysliptype[e].checked) {
                count_paysliptype--;
            }
        });
        if (count_paysliptype == 1) {
            $("#paysliptype").prop('checked', true);
        }
        var allowance = $(".isscheck_allowance");
        var count_allowance = 1;
        allowance.filter((e) => {
            if (!allowance[e].checked) {
                count_allowance--;
            }
        });
        if (count_allowance == 1) {
            $("#allowance").prop('checked', true);
        }
        var commission = $(".isscheck_commission");
        var count_commission = 1;
        commission.filter((e) => {
            if (!commission[e].checked) {
                count_commission--;
            }
        });
        if (count_commission == 1) {
            $("#commission").prop('checked', true);
        }
        var allowanceoption = $(".isscheck_allowanceoption");
        var count_allowanceoption = 1;
        allowanceoption.filter((e) => {
            if (!allowanceoption[e].checked) {
                count_allowanceoption--;
            }
        });
        if (count_allowanceoption == 1) {
            $("#allowanceoption").prop('checked', true);
        }
        var loanoption = $(".isscheck_loanoption");
        var count_loanoption = 1;
        loanoption.filter((e) => {
            if (!loanoption[e].checked) {
                count_loanoption--;
            }
        });
        if (count_loanoption == 1) {
            $("#loanoption").prop('checked', true);
        }
        var deductionoption = $(".isscheck_deductionoption");
        var count_deductionoption = 1;
        deductionoption.filter((e) => {
            if (!deductionoption[e].checked) {
                count_deductionoption--;
            }
        });
        if (count_deductionoption == 1) {
            $("#deductionoption").prop('checked', true);
        }
        var loan = $(".isscheck_loan");
        var count_loan = 1;
        loan.filter((e) => {
            if (!loan[e].checked) {
                count_loan--;
            }
        });
        if (count_loan == 1) {
            $("#loan").prop('checked', true);
        }
        var saturationdeduction = $(".isscheck_saturationdeduction");
        var count_saturationdeduction = 1;
        saturationdeduction.filter((e) => {
            if (!saturationdeduction[e].checked) {
                count_saturationdeduction--;
            }
        });
        if (count_saturationdeduction == 1) {
            $("#saturationdeduction").prop('checked', true);
        }
        var otherpayment = $(".isscheck_otherpayment");
        var count_otherpayment = 1;
        otherpayment.filter((e) => {
            if (!otherpayment[e].checked) {
                count_otherpayment--;
            }
        });
        if (count_otherpayment == 1) {
            $("#otherpayment").prop('checked', true);
        }
        var saturationdeduction = $(".isscheck_saturationdeduction");
        var count_saturationdeduction = 1;
        saturationdeduction.filter((e) => {
            if (!saturationdeduction[e].checked) {
                count_saturationdeduction--;
            }
        });
        if (count_saturationdeduction == 1) {
            $("#saturationdeduction").prop('checked', true);
        }
        var overtime = $(".isscheck_overtime");
        var count_overtime = 1;
        overtime.filter((e) => {
            if (!overtime[e].checked) {
                count_overtime--;
            }
        });
        if (count_overtime == 1) {
            $("#overtime").prop('checked', true);
        }
        var setsalary = $(".isscheck_setsalary");
        var count_setsalary = 1;
        setsalary.filter((e) => {
            if (!setsalary[e].checked) {
                count_setsalary--;
            }
        });
        if (count_setsalary == 1) {
            $("#setsalary").prop('checked', true);
        }
        var payslip = $(".isscheck_payslip");
        var count_payslip = 1;
        payslip.filter((e) => {
            if (!payslip[e].checked) {
                count_payslip--;
            }
        });
        if (count_payslip == 1) {
            $("#payslip").prop('checked', true);
        }
        var companypolicy = $(".isscheck_companypolicy");
        var count_companypolicy = 1;
        companypolicy.filter((e) => {
            if (!companypolicy[e].checked) {
                count_companypolicy--;
            }
        });
        if (count_companypolicy == 1) {
            $("#companypolicy").prop('checked', true);
        }
        var appraisal = $(".isscheck_appraisal");
        var count_appraisal = 1;
        appraisal.filter((e) => {
            if (!appraisal[e].checked) {
                count_appraisal--;
            }
        });
        if (count_appraisal == 1) {
            $("#appraisal").prop('checked', true);
        }
        var goaltracking = $(".isscheck_goaltracking");
        var count_goaltracking = 1;
        goaltracking.filter((e) => {
            if (!goaltracking[e].checked) {
                count_goaltracking--;
            }
        });
        if (count_goaltracking == 1) {
            $("#goaltracking").prop('checked', true);
        }
        var goaltype = $(".isscheck_goaltype");
        var count_goaltype = 1;
        goaltype.filter((e) => {
            if (!goaltype[e].checked) {
                count_goaltype--;
            }
        });
        if (count_goaltype == 1) {
            $("#goaltype").prop('checked', true);
        }
        var indicator = $(".isscheck_indicator");
        var count_indicator = 1;
        indicator.filter((e) => {
            if (!indicator[e].checked) {
                count_indicator--;
            }
        });
        if (count_indicator == 1) {
            $("#indicator").prop('checked', true);
        }
        var event = $(".isscheck_event");
        var count_event = 1;
        event.filter((e) => {
            if (!event[e].checked) {
                count_event--;
            }
        });
        if (count_event == 1) {
            $("#event").prop('checked', true);
        }
        var meeting = $(".isscheck_meeting");
        var count_meeting = 1;
        meeting.filter((e) => {
            if (!meeting[e].checked) {
                count_meeting--;
            }
        });
        if (count_meeting == 1) {
            $("#meeting").prop('checked', true);
        }
        var training = $(".isscheck_training");
        var count_training = 1;
        training.filter((e) => {
            if (!training[e].checked) {
                count_training--;
            }
        });
        if (count_training == 1) {
            $("#training").prop('checked', true);
        }
        var trainer = $(".isscheck_trainer");
        var count_trainer = 1;
        trainer.filter((e) => {
            if (!trainer[e].checked) {
                count_trainer--;
            }
        });
        if (count_trainer == 1) {
            $("#trainer").prop('checked', true);
        }
        var trainingtype = $(".isscheck_trainingtype");
        var count_trainingtype = 1;
        trainingtype.filter((e) => {
            if (!trainingtype[e].checked) {
                count_trainingtype--;
            }
        });
        if (count_trainingtype == 1) {
            $("#trainingtype").prop('checked', true);
        }
        var award = $(".isscheck_award");
        var count_award = 1;
        award.filter((e) => {
            if (!award[e].checked) {
                count_award--;
            }
        });
        if (count_award == 1) {
            $("#award").prop('checked', true);
        }
        var awardtype = $(".isscheck_awardtype");
        var count_awardtype = 1;
        awardtype.filter((e) => {
            if (!awardtype[e].checked) {
                count_awardtype--;
            }
        });
        if (count_awardtype == 1) {
            $("#awardtype").prop('checked', true);
        }
        var resignation = $(".isscheck_resignation");
        var count_resignation = 1;
        resignation.filter((e) => {
            if (!resignation[e].checked) {
                count_resignation--;
            }
        });
        if (count_resignation == 1) {
            $("#resignation").prop('checked', true);
        }
        var travel = $(".isscheck_travel");
        var count_travel = 1;
        travel.filter((e) => {
            if (!travel[e].checked) {
                count_travel--;
            }
        });
        if (count_travel == 1) {
            $("#travel").prop('checked', true);
        }
        var promotion = $(".isscheck_promotion");
        var count_promotion = 1;
        promotion.filter((e) => {
            if (!promotion[e].checked) {
                count_promotion--;
            }
        });
        if (count_promotion == 1) {
            $("#promotion").prop('checked', true);
        }
        var complaint = $(".isscheck_complaint");
        var count_complaint = 1;
        complaint.filter((e) => {
            if (!complaint[e].checked) {
                count_complaint--;
            }
        });
        if (count_complaint == 1) {
            $("#complaint").prop('checked', true);
        }
        var warning = $(".isscheck_warning");
        var count_warning = 1;
        warning.filter((e) => {
            if (!warning[e].checked) {
                count_warning--;
            }
        });
        if (count_warning == 1) {
            $("#warning").prop('checked', true);
        }
        var termination = $(".isscheck_termination");
        var count_termination = 1;
        termination.filter((e) => {
            if (!termination[e].checked) {
                count_termination--;
            }
        });
        if (count_termination == 1) {
            $("#termination").prop('checked', true);
        }
        var terminationtype = $(".isscheck_terminationtype");
        var count_terminationtype = 1;
        terminationtype.filter((e) => {
            if (!terminationtype[e].checked) {
                count_terminationtype--;
            }
        });
        if (count_terminationtype == 1) {
            $("#terminationtype").prop('checked', true);
        }
        var jobapplication = $(".isscheck_jobapplication");
        var count_jobapplication = 1;
        jobapplication.filter((e) => {
            if (!jobapplication[e].checked) {
                count_jobapplication--;
            }
        });
        if (count_jobapplication == 1) {
            $("#jobapplication").prop('checked', true);
        }
        var jobapplicationnote = $(".isscheck_jobapplicationnote");
        var count_jobapplicationnote = 1;
        jobapplicationnote.filter((e) => {
            if (!jobapplicationnote[e].checked) {
                count_jobapplicationnote--;
            }
        });
        if (count_jobapplicationnote == 1) {
            $("#jobapplicationnote").prop('checked', true);
        }
        var jobonBoard = $(".isscheck_jobonBoard");
        var count_jobonBoard = 1;
        jobonBoard.filter((e) => {
            if (!jobonBoard[e].checked) {
                count_jobonBoard--;
            }
        });
        if (count_jobonBoard == 1) {
            $("#jobonBoard").prop('checked', true);
        }
        var jobcategory = $(".isscheck_jobcategory");
        var count_jobcategory = 1;
        jobcategory.filter((e) => {
            if (!jobcategory[e].checked) {
                count_jobcategory--;
            }
        });
        if (count_jobcategory == 1) {
            $("#jobcategory").prop('checked', true);
        }
        var job = $(".isscheck_job");
        var count_job = 1;
        job.filter((e) => {
            if (!job[e].checked) {
                count_job--;
            }
        });
        if (count_job == 1) {
            $("#job").prop('checked', true);
        }
        var jobstage = $(".isscheck_jobstage");
        var count_jobstage = 1;
        jobstage.filter((e) => {
            if (!jobstage[e].checked) {
                count_jobstage--;
            }
        });
        if (count_jobstage == 1) {
            $("#jobstage").prop('checked', true);
        }
        var customquestion = $(".isscheck_customquestion");
        var count_customquestion = 1;
        customquestion.filter((e) => {
            if (!customquestion[e].checked) {
                count_customquestion--;
            }
        });
        if (count_customquestion == 1) {
            $("#customquestion").prop('checked', true);
        }
        var interviewschedule = $(".isscheck_interviewschedule");
        var count_interviewschedule = 1;
        interviewschedule.filter((e) => {
            if (!interviewschedule[e].checked) {
                count_interviewschedule--;
            }
        });
        if (count_interviewschedule == 1) {
            $("#interviewschedule").prop('checked', true);
        }
        var estimation = $(".isscheck_estimation");
        var count_estimation = 1;
        estimation.filter((e) => {
            if (!estimation[e].checked) {
                count_estimation--;
            }
        });
        if (count_estimation == 1) {
            $("#estimation").prop('checked', true);
        }
        var holiday = $(".isscheck_holiday");
        var count_holiday = 1;
        holiday.filter((e) => {
            if (!holiday[e].checked) {
                count_holiday--;
            }
        });
        if (count_holiday == 1) {
            $("#holiday").prop('checked', true);
        }
        var transfer = $(".isscheck_transfer");
        var count_transfer = 1;
        transfer.filter((e) => {
            if (!transfer[e].checked) {
                count_transfer--;
            }
        });
        if (count_transfer == 1) {
            $("#transfer").prop('checked', true);
        }
        var announcement = $(".isscheck_announcement");
        var count_announcement = 1;
        announcement.filter((e) => {
            if (!announcement[e].checked) {
                count_announcement--;
            }
        });
        if (count_announcement == 1) {
            $("#announcement").prop('checked', true);
        }
        var leave = $(".isscheck_leave");
        var count_leave = 1;
        leave.filter((e) => {
            if (!leave[e].checked) {
                count_leave--;
            }
        });
        if (count_leave == 1) {
            $("#leave").prop('checked', true);
        }
        var leavetype = $(".isscheck_leavetype");
        var count_leavetype = 1;
        leavetype.filter((e) => {
            if (!leavetype[e].checked) {
                count_leavetype--;
            }
        });
        if (count_leavetype == 1) {
            $("#leavetype").prop('checked', true);
        }
        var attendance = $(".isscheck_attendance");
        var count_attendance = 1;
        attendance.filter((e) => {
            if (!attendance[e].checked) {
                count_attendance--;
            }
        });
        if (count_attendance == 1) {
            $("#attendance").prop('checked', true);
        }
        var accountdashboard = $(".isscheck_accountdashboard");
        var count_accountdashboard = 1;
        accountdashboard.filter((e) => {
            if (!accountdashboard[e].checked) {
                count_accountdashboard--;
            }
        });
        if (count_accountdashboard == 1) {
            $("#accountdashboard").prop('checked', true);
        }
        var proposal = $(".isscheck_proposal");
        var count_proposal = 1;
        proposal.filter((e) => {
            if (!proposal[e].checked) {
                count_proposal--;
            }
        });
        if (count_proposal == 1) {
            $("#proposal").prop('checked', true);
        }
        var invoice = $(".isscheck_invoice");
        var count_invoice = 1;
        invoice.filter((e) => {
            if (!invoice[e].checked) {
                count_invoice--;
            }
        });
        if (count_invoice == 1) {
            $("#invoice").prop('checked', true);
        }
        var bill = $(".isscheck_bill");
        var count_bill = 1;
        bill.filter((e) => {
            if (!bill[e].checked) {
                count_bill--;
            }
        });
        if (count_bill == 1) {
            $("#bill").prop('checked', true);
        }
        var revenue = $(".isscheck_revenue");
        var count_revenue = 1;
        revenue.filter((e) => {
            if (!revenue[e].checked) {
                count_revenue--;
            }
        });
        if (count_revenue == 1) {
            $("#revenue").prop('checked', true);
        }
        var payment = $(".isscheck_payment");
        var count_payment = 1;
        payment.filter((e) => {
            if (!payment[e].checked) {
                count_payment--;
            }
        });
        if (count_payment == 1) {
            $("#payment").prop('checked', true);
        }
        var proposalproduct = $(".isscheck_proposalproduct");
        var count_proposalproduct = 1;
        proposalproduct.filter((e) => {
            if (!proposalproduct[e].checked) {
                count_proposalproduct--;
            }
        });
        if (count_proposalproduct == 1) {
            $("#proposalproduct").prop('checked', true);
        }
        var invoiceproduct = $(".isscheck_invoiceproduct");
        var count_invoiceproduct = 1;
        invoiceproduct.filter((e) => {
            if (!invoiceproduct[e].checked) {
                count_invoiceproduct--;
            }
        });
        if (count_invoiceproduct == 1) {
            $("#invoiceproduct").prop('checked', true);
        }
        var goal = $(".isscheck_goal");
        var count_goal = 1;
        goal.filter((e) => {
            if (!goal[e].checked) {
                count_goal--;
            }
        });
        if (count_goal == 1) {
            $("#goal").prop('checked', true);
        }
        var creditnote = $(".isscheck_creditnote");
        var count_creditnote = 1;
        creditnote.filter((e) => {
            if (!creditnote[e].checked) {
                count_creditnote--;
            }
        });
        if (count_creditnote == 1) {
            $("#creditnote").prop('checked', true);
        }
        var debitnote = $(".isscheck_debitnote");
        var count_debitnote = 1;
        debitnote.filter((e) => {
            if (!debitnote[e].checked) {
                count_debitnote--;
            }
        });
        if (count_debitnote == 1) {
            $("#debitnote").prop('checked', true);
        }
        var bankaccount = $(".isscheck_bankaccount");
        var count_bankaccount = 1;
        bankaccount.filter((e) => {
            if (!bankaccount[e].checked) {
                count_bankaccount--;
            }
        });
        if (count_bankaccount == 1) {
            $("#bankaccount").prop('checked', true);
        }
        var banktransfer = $(".isscheck_banktransfer");
        var count_banktransfer = 1;
        banktransfer.filter((e) => {
            if (!banktransfer[e].checked) {
                count_banktransfer--;
            }
        });
        if (count_banktransfer == 1) {
            $("#banktransfer").prop('checked', true);
        }
        var customer = $(".isscheck_customer");
        var count_customer = 1;
        customer.filter((e) => {
            if (!customer[e].checked) {
                count_customer--;
            }
        });
        if (count_customer == 1) {
            $("#customer").prop('checked', true);
        }
        var vender = $(".isscheck_vender");
        var count_vender = 1;
        vender.filter((e) => {
            if (!vender[e].checked) {
                count_vender--;
            }
        });
        if (count_vender == 1) {
            $("#vender").prop('checked', true);
        }
        var transaction = $(".isscheck_transaction");
        var count_transaction = 1;
        transaction.filter((e) => {
            if (!transaction[e].checked) {
                count_transaction--;
            }
        });
        if (count_transaction == 1) {
            $("#transaction").prop('checked', true);
        }
        var deal = $(".isscheck_deal");
        var count_deal = 1;
        deal.filter((e) => {
            if (!deal[e].checked) {
                count_deal--;
            }
        });
        if (count_deal == 1) {
            $("#deal").prop('checked', true);
        }
        var constantcustomfield = $(".isscheck_constantcustomfield");
        var count_constantcustomfield = 1;
        constantcustomfield.filter((e) => {
            if (!constantcustomfield[e].checked) {
                count_constantcustomfield--;
            }
        });
        if (count_constantcustomfield == 1) {
            $("#constantcustomfield").prop('checked', true);
        }
        var assets = $(".isscheck_assets");
        var count_assets = 1;
        assets.filter((e) => {
            if (!assets[e].checked) {
                count_assets--;
            }
        });
        if (count_assets == 1) {
            $("#assets").prop('checked', true);
        }
        var chartofaccount = $(".isscheck_chartofaccount");
        var count_chartofaccount = 1;
        chartofaccount.filter((e) => {
            if (!chartofaccount[e].checked) {
                count_chartofaccount--;
            }
        });
        if (count_chartofaccount == 1) {
            $("#chartofaccount").prop('checked', true);
        }
        var journalentry = $(".isscheck_journalentry");
        var count_journalentry = 1;
        journalentry.filter((e) => {
            if (!journalentry[e].checked) {
                count_journalentry--;
            }
        });
        if (count_journalentry == 1) {
            $("#journalentry").prop('checked', true);
        }
        var report = $(".isscheck_report");
        var count_report = 1;
        report.filter((e) => {
            if (!report[e].checked) {
                count_report--;
            }
        });

        var diary = $(".diary_checkall");
        var count_diary = 1;
        diary.filter((e) => {
            if (!diary[e].checked) {
                count_diary--;
            }
        });
        if (count_diary == 1) {
            $("#diary_checkall").prop('checked', true);
        }

        var consultant = $(".consultant_checkall");
        var count_consultant = 1;
        consultant.filter((e) => {
            if (!consultant[e].checked) {
                count_consultant--;
            }
        });
        if (count_consultant == 1) {
            $("#consultant").prop('checked', true);
        }

        var sub_contractort = $(".sub_contractor_checkall");
        var count_sub_contractor = 1;
        sub_contractort.filter((e) => {
            if (!sub_contractort[e].checked) {
                count_sub_contractor--;
            }
        });
        if (count_sub_contractor == 1) {
            $("#subContractor").prop('checked', true);
        }

        $("#staff_checkall").click(function() {
            $('.staff_checkall').not(this).prop('checked', this.checked);
        });
        $("#crm_checkall").click(function() {
            $('.crm_checkall').not(this).prop('checked', this.checked);
        });
        $("#project_checkall").click(function() {
            $('.project_checkall').not(this).prop('checked', this.checked);
        });
        $("#hrm_checkall").click(function() {
            $('.hrm_checkall').not(this).prop('checked', this.checked);
        });
        $("#account_checkall").click(function() {
            $('.account_checkall').not(this).prop('checked', this.checked);
        });
        $("#consultant_checkall").click(function() {
            $('.consultant_checkall').not(this).prop('checked', this.checked);
        });
        $("#sub_contractor_checkall").click(function() {
            $('.sub_contractor_checkall').not(this).prop('checked', this.checked);
        });
        $("#diary_checkall").click(function() {
            $('.diary_checkall').not(this).prop('checked', this.checked);
        });
        $(".ischeck").click(function() {
            var ischeck = $(this).data('id');
            $('.isscheck_' + ischeck).prop('checked', this.checked);
        });

          //form submit after button disable starts
        $(document).on('submit', 'form', function() {
          $('#edit_role').attr('disabled', 'disabled');
        });
        //form submit after button disable ends

    });
</script>
