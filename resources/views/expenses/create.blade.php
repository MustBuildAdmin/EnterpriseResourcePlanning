{{ Form::open(['route' => ['projects.expenses.store',$project->id],'id' => 'create_expense','enctype' => 'multipart/form-data']) }}
<div class="modal-body">

<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            {{ Form::label('name', __('Name'),['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('name', null, ['class' => 'form-control','required'=>'required']) }}
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            {{ Form::label('date', __('Date'),['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::date('date', null, ['class' => 'form-control','required'=>'required']) }}
        </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="form-group">
          {{Form::label('amount',__('Amount'),['class'=>'form-label'])}}<span class="text-danger">*</span>
          <div class="form-group price-input input-group search-form">
              <span class="input-group-text bg-transparent">{{\Auth::user()->currencySymbol()}}</span>
              {{Form::number('amount',null,array('class'=>'form-control','required' => 'required','min' => '0'))}}
          </div>
      </div>

    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            {{ Form::label('task_id', __('Task'),['class' => 'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select" name="task_id" id="task_id" required>
                <option value="0"  disabled selected>Choose Task</option>
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            {{ Form::label('description', __('Description'),['class' => 'form-label']) }}<br>
            {{ Form::textarea('description', null, ['class' => 'form-control','rows' => '1','data-toggle' => 'autosize','Placeholder'=>__('This textarea will autosize while you type')]) }}
        </div>
    </div>


    <div class="col-12 col-md-12">
        {{Form::label('attachment',__('Attachment'),['class'=>'form-label'])}}
        <div class="choose-file form-group">
            <label for="attachment" class="form-label">
                <input type="file" class="form-control" name="attachment" id="attachment" data-filename="attachment_create">
            </label>
            {{-- <p class="attachment_create"></p> --}}
        </div>
    </div>


</div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{ Form::close() }}

