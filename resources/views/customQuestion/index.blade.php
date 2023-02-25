@extends('layouts.admin')

@section('page-title')
    {{__('Manage Custom Question for interview')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Custom-Question')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
    @can('create custom question')
        <a href="#" data-size="lg" data-url="{{ route('custom-question.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Custom Question')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Question')}}</th>
                                <th>{{__('Is Required')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($questions as $question)
                                <tr>
                                    <td>{{ $question->question }}</td>
                                    <td>
                                        @if($question->is_required=='yes')
                                            <span class="badge bg-success p-2 px-3 rounded">{{\App\Models\CustomQuestion::$is_required[$question->is_required]}}</span>
                                        @else
                                            <span class="badge bg-danger p-2 px-3 rounded">{{\App\Models\CustomQuestion::$is_required[$question->is_required]}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('edit custom question')
                                        <div class="action-btn bg-primary ms-2">
                                            <a href="#" data-url="{{ route('custom-question.edit',$question->id) }}" data-size="lg" title="{{__('Edit')}}"  data-ajax-popup="true" data-title="{{__('Edit Custom Question')}}" class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                        </div>
                                            @endcan
                                        @can('delete custom question')
                                        <div class="action-btn bg-danger ms-2">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['custom-question.destroy', $question->id],'id'=>'delete-form-'.$question->id]) !!}

                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$question->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                            {!! Form::close() !!}
                                        </div>
                                        @endif
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
