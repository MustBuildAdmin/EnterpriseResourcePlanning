{{ Form::open(array('url' => 'clients')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::text('name', null, array('class' => 'form-control',
            'placeholder'=>__('Enter client Name'),'required'=>'required')) }}
        </div>
        <div class="form-group">
            {{ Form::label('email', __('E-Mail Address'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::email('email', null, array('class' => 'form-control',
            'placeholder'=>__('Enter Client Email'),'required'=>'required')) }}
        </div>
        <div class="form-group">
            {{ Form::label('password', __('Password'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{Form::password('password',array('class'=>'form-control',
            'placeholder'=>__('Enter User Password'),'required'=>'required','minlength'=>"6"))}}
            @error('password')
            <small class="invalid-password" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="row">
            <div class="form-group">
                {{ Form::label('gender', __('Gender'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                {!! Form::select('gender', $gender, 'null',array('class' => 'form-control select2',
                'required'=>'required')) !!}
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
            <div class="form-group">
                {{Form::label('country',__('Country'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <select class="form-control country" name="country" id='country'
                            placeholder="Select Country" required>
                        <option value="">{{ __('Select Country ...') }}</option>
                        @foreach($country as $key => $value)
                              <option value="{{$value->iso2}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                    {{-- {{Form::text('country',null,array('class'=>'form-control'))}} --}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('state',__('State'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <select class="form-control" name="state" id='state' required
                            placeholder="Select State" >
                        <option value="">{{ __('Select State ...') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('city',__('City'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                      {{Form::text('city',null,array('class'=>'form-control','required'=>'required'))}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('phone',__('Phone'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <input class="form-control" name="phone" type="number" id="phone"
                     maxlength="16" placeholder="+91 111 111 1111"  required>
                    {{-- {{Form::text('phone',null,array('class'=>'form-control'))}} --}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('zip',__('Zip Code'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    {{Form::text('zip',null,array('class'=>'form-control','required'=>'required'))}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('address',__('Address'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="">
                    {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3,'required'=>'required'))}}
                </div>
            </div>
    </div>
        @if(!$customFields->isEmpty())
            @include('custom_fields.formBuilder')
        @endif

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}


<script>

$(document).on("change", '#country', function () {
    var name=$(this).val();
    var settings = {
            "url": "https://api.countrystatecity.in/v1/countries/"+name+"/states",
            "method": "GET",
            "headers": {
                "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
            },
            };

            $.ajax(settings).done(function (response) {
                    $('#state').empty();
                    $('#state').append('<option value="">{{__('Select State ...')}}</option>');
                        $.each(response, function (key, value) {
                            $('#state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
                        });
        });
    });
</script>