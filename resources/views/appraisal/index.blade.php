@extends('layouts.admin')
@section('page-title')
    {{__('Manage Appraisal')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Appraisal')}}</li>
@endsection
@push('css-page')
    <style>
        @import url({{ asset('css/font-awesome.css') }});
    </style>
@endpush
@push('script-page')
    <script src="{{ asset('js/bootstrap-toggle.js') }}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
            $("fieldset[id^='demo'] .stars").click(function () {
                alert($(this).val());
                $(this).attr("checked");
            });
        });

        $(document).ready(function () {
            var employee = $('#employee').val();
            getEmployee(employee);
        });

        $(document).on('change', 'select[name=branch]', function () {
            var branch = $(this).val();
            getEmployee(branch);
        });

        function getEmployee(did) {
            $.ajax({
                url: '{{route('branch.employee.json')}}',
                type: 'POST',
                data: {
                    "branch": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#employee').empty();
                    $('#employee').append('<option value="">{{__('Select Employee')}}</option>');
                    $.each(data, function (key, value) {
                        $('#employee').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }


    </script>
@endpush

@section('action-btn')
    <div class="float-end">
    @can('create appraisal')
       <a href="#" data-size="lg" data-url="{{ route('appraisal.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Appraisal')}}" class="btn btn-sm btn-primary">
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
                                <th>{{__('Branch')}}</th>
                                <th>{{__('Department')}}</th>
                                <th>{{__('Designation')}}</th>
                                <th>{{__('Employee')}}</th>
                                <th>{{ __('Target Rating') }}</th>
                                <th>{{__('Overall Rating')}}</th>
                                <th>{{__('Appraisal Date')}}</th>
                                @if( Gate::check('edit appraisal') ||Gate::check('delete appraisal') ||Gate::check('show appraisal'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($appraisals as $appraisal)

                                @php
                                    $designation=!empty($appraisal->employees->designation->id) ?  $appraisal->employees->designation->id : 0;
                                    $targetRating =  Utility::getTargetrating($designation,$competencyCount);
                                    if(!empty($appraisal->rating) && $appraisal->rating!='null' &&($competencyCount!=0))
                                    {
                                        $rating = json_decode($appraisal->rating,true);
                                        $starsum = array_sum($rating);
                                        $overallrating = $starsum/$competencyCount;
                                    }
                                    else{
                                        $overallrating = 0;
                                    }
                                @endphp

                                @php
                                    if(!empty($appraisal->rating) && $appraisal->rating!='null'){
                                        $rating = json_decode($appraisal->rating,true);
                                        $starsum = !empty($rating)?array_sum($rating):0;
                                        $overallrating = ($starsum!=0)? $starsum/count($rating):0;
                                    }
                                    else{
                                        $overallrating = 0;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ !empty($appraisal->branches)?$appraisal->branches->name:'' }}</td>
                                    <td>{{ !empty($appraisal->employees)?!empty($appraisal->employees->department)?$appraisal->employees->department->name:'':'' }}</td>
                                    <td>{{ !empty($appraisal->employees)?!empty($appraisal->employees->designation)?$appraisal->employees->designation->name:'':'' }}</td>
                                    <td>{{!empty($appraisal->employees)?$appraisal->employees->name:'' }}</td>

                                    <td >
                                        @for($i=1; $i<=5; $i++)
                                            @if($targetRating < $i)
                                                @if(is_float($targetRating) && (round($targetRating) == $i))
                                                    <i class="text-warning fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="fas fa-star"></i>
                                                @endif
                                            @else
                                                <i class="text-warning fas fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="theme-text-color">({{number_format($targetRating,1)}})</span>
                                    </td>


                                    <td>

                                        @for($i=1; $i<=5; $i++)
                                            @if($overallrating < $i)
                                                @if(is_float($overallrating) && (round($overallrating) == $i))
                                                    <i class="text-warning fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="fas fa-star"></i>
                                                @endif
                                            @else
                                                <i class="text-warning fas fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="theme-text-color">({{number_format($overallrating,1)}})</span>
                                    </td>
                                    <td>{{ $appraisal->appraisal_date}}</td>
                                    @if( Gate::check('edit appraisal') ||Gate::check('delete appraisal') ||Gate::check('show appraisal'))
                                        <td>
                                            @can('show appraisal')
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" data-url="{{ route('appraisal.show',$appraisal->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Appraisal Detail')}}" data-bs-toggle="tooltip" title="{{__('View')}}" data-original-title="{{__('View Detail')}}" class="mx-3 btn btn-sm align-items-center">
                                                    <i class="ti ti-eye text-white"></i></a>
                                            </div>
                                                @endcan
                                            @can('edit appraisal')
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="#" data-url="{{ route('appraisal.edit',$appraisal->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Appraisal')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}" class="mx-3 btn btn-sm align-items-center">
                                                <i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                                @endcan
                                            @can('delete appraisal')
                                            <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['appraisal.destroy', $appraisal->id],'id'=>'delete-form-'.$appraisal->id]) !!}
                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm-yes="document.getElementById('delete-form-{{$appraisal->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>
                                            @endcan
                                        </td>
                                    @endif
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
