{{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group ">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                {{ Form::text('name', null, [
                    'class' => 'form-control font-style',
                    'disabled' => 'disabled',
                    'maxlength' => 35,
                    'placeholder' => __('Enter User Name'),
                ]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                {{ Form::email('email', null, [
                    'class' => 'form-control',
                    'disabled' => 'disabled',
                    'placeholder' => __('Enter User Email'),
                ]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group ">
                {{ Form::label('name', __('Phone'), ['class' => 'form-label']) }}
                <input type="text" class="form-control" value="{{ $user->phone }}" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('email', __('Address'), ['class' => 'form-label']) }}
                <textarea class="form-control" disabled>{{ $user->address }}</textarea>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
