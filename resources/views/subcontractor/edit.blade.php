@if(\Auth::user()->type == 'super admin')
    @php $url='subContractor.update' @endphp
@else
    @php $url='subContractor.update_subContractor' @endphp
@endif
{{ Form::model($vender, array('route' => array($url, $vender->id) , 'method' => 'PUT',
'enctype'=>"multipart/form-data")) }}
<div class="modal-body">

    <h6 class="sub-title">{{ __('Basic Info') }}</h6>
    <div class="row">
        @if ($vender->color_code!=null || $vender->color_code!='')
            @php $colorcor = $vender->color_code; @endphp
        @else
            @php $colorcor = $colorco; @endphp
        @endif

        <input type="hidden" name="color_code" value="{{ $colorcor }}">
        <input type="hidden" name="password" value="{{$vender->password}}">
        
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <span><i class="ti ti-address-card"></i></span>
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
                    {{ Form::hidden('email', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('lnamelabel',__('Last Name'),array('class'=>'form-label')) }}
                <span style='color:red;'>*</span>
                <div class="form-icon-user">
                    {{Form::text('lname',null,array('class'=>'form-control','required'=>'required',
                    'placeholder'=>'Last Name'))}}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('contact', __('Contact'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <span><i class="ti ti-mobile-alt"></i></span>
                    {{Form::text('contact',$vender->phone,array('id'=>'phone','class'=>'form-control',
                    'Placeholder'=>'(00) 0000-0000','required'=>'required','maxlength' => 16,
                    'oninput'=>"numeric(this)",'data-mask'=>"(00) 0000-0000",'data-mask-visible'=>"true"))}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('tax_number', __('Tax Number'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <span><i class="ti ti-crosshairs"></i></span>
                    {{ Form::text('tax_number', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="form-group">
                {{Form::label('avatar',__('Profile Image'),array('class'=>'form-label')) }}
                <div class="form-icon-user">
                    <input type="file" class="form-control document_setup" id="avatar"  name="avatar"
                     accept="image/*, .png, .jpeg, .jpg">
                </div>
                <span class="show_document_error" style="color:red;"></span>
            </div>
        </div>
        @if (!$customFields->isEmpty())
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif
    </div>
    <h6 class="sub-title">{{ __('Billing Address') }}</h6>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('billing_name', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_country', __('Country'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <select class="form-control country" name="billing_country" id='billing_country'
                        placeholder="Select Country">
                        <option value="">{{ __('Select Country ...') }}</option>
                        @foreach ($countrylist as $key => $value)
                            <option value="{{ $value->iso2 }}"
                                @if ($vender->billing_country == $value->iso2) selected @endif>
                                {{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_state', __('State'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <select class="form-control country" name="billing_state" id='billing_state'
                        placeholder="Select State">
                        <option value="">{{ __('Select State ...') }}</option>
                        @foreach ($statelist as $key => $value)
                            <option value="{{ $value->iso2 }}"
                                @if ($vender->billing_state == $value->iso2) selected @endif>
                                {{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_city', __('City'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('billing_city', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_phone', __('Phone'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{Form::text('billing_phone',null,array('class'=>'form-control',
                    'Placeholder'=>'(00) 0000-0000','maxlength' => 16,'required'=>'required',
                    'oninput'=>"numeric(this)",'data-mask'=>"(00) 0000-0000",'data-mask-visible'=>"true"))}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_zip', __('Zip Code'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('billing_zip', null, ['class' => 'form-control',
                    'placeholder' => __('Enter User Email')]) }}
                </div>
            </div>
        </div>
            <div class="form-group">
                {{ Form::label('billing_address', __('Address'), ['class' => 'form-label']) }}
                <div class="input-group">
                    {{ Form::textarea('billing_address', null, ['class' => 'form-control', 'rows' => 3]) }}
                </div>
            </div>
        </div>
    </div>

    @if (App\Models\Utility::getValByName('shipping_display') == 'on')
        <div class="col-md-12 text-end">
        </div>
        <h6 class="sub-title">{{ __('Shipping Address') }}</h6>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_name', __('Name'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_name', null, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_country', __('Country'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        <select class="form-control" name="shipping_country" id='shipping_country'
                            placeholder="Select Country">
                            <option value="">{{ __('Select Country ...') }}</option>
                            @foreach ($countrylist as $key => $value)
                                <option value="{{ $value->iso2 }}"
                                    @isset($vender->shipping_country)
                                    @if ($vender->shipping_country == $value->iso2) selected @endif @endisset>
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_state', __('State'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        <select class="form-control " name="shipping_state" id='shipping_state'
                            placeholder="Select Country">
                            <option value="">{{ __('Select State ...') }}</option>
                            @foreach ($sellerstatelist as $key => $value)
                                <option value="{{ $value->iso2 }}"
                                     @if ($vender->shipping_state == $value->iso2) selected @endif>
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_city', __('City'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_city', null, ['class' => 'form-control', 'required' => 'required']) }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_phone', __('Phone'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{Form::text('shipping_phone',null,array('class'=>'form-control',
                        'Placeholder'=>'(00) 0000-0000','maxlength' => 16,'required'=>'required',
                        'oninput'=>"numeric(this)",'data-mask'=>"(00) 0000-0000",'data-mask-visible'=>"true"))}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_zip', __('Zip Code'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_zip', null, ['class' => 'form-control',
                        'placeholder' => __('Enter User Email')]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('shipping_address', __('Address'), ['class' => 'form-label']) }}
                    <div class="input-group">
                        {{ Form::textarea('shipping_address', null, ['class' => 'form-control', 'rows' => 3]) }}
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>

{{ Form::close() }}
