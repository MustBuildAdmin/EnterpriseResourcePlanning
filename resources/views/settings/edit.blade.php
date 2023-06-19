@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1 class="d-inline">{{__('Role')}} </h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Update Role')}} </h4>
                    </div>

                    {{Form::model($role,array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
                    <div class="card-body">
                        <div class="form-group">
                            {{Form::label('name',__('Name'))}}
                            {{Form::text('name',null,array('class'=>'form-control'))}}
                            @error('name')
                            <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            @if(!empty($permissions))
                                <h6>{{__('Assign Permission to Roles')}} </h6>
                                <table class="table table-striped mb-0" id="dataTable-1">
                                    <thead>
                                    <tr>
                                        <th>{{__('Module')}} </th>
                                        <th>{{__('Permissions')}} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $modules=['user','language','account'];
                                    @endphp
                                    @foreach($modules as $module)
                                        <tr>
                                            <td>{{ ucfirst($module) }}</td>
                                            <td>
                                                @if(in_array('manage '.$module,(array) $permissions))
                                                    @if($key = array_search('manage '.$module,$permissions))
                                                        <div class="form-check form-check-inline">
                                                            {{Form::checkbox('permissions[]',$key,$role->permission, ['id' =>'permission'.$key])}}
                                                            {{Form::label('permission'.$key,'Manage')}}<br>
                                                        </div>
                                                    @endif
                                                @endif
                                                @if(in_array('create '.$module,(array) $permissions))
                                                    @if($key = array_search('create '.$module,$permissions))
                                                        <div class="form-check form-check-inline">
                                                            {{Form::checkbox('permissions[]',$key,$role->permission, ['id' =>'permission'.$key])}}
                                                            {{Form::label('permission'.$key,'Create')}}<br>
                                                        </div>
                                                    @endif
                                                @endif
                                                @if(in_array('edit '.$module,(array) $permissions))
                                                    @if($key = array_search('edit '.$module,$permissions))
                                                        <div class="form-check form-check-inline">
                                                            {{Form::checkbox('permissions[]',$key,$role->permission, ['id' =>'permission'.$key])}}
                                                            {{Form::label('permission'.$key,'Edit')}}<br>
                                                        </div>
                                                    @endif
                                                @endif
                                                @if(in_array('delete '.$module,(array) $permissions))
                                                    @if($key = array_search('delete '.$module,$permissions))
                                                        <div class="form-check form-check-inline">
                                                            {{Form::checkbox('permissions[]',$key,$role->permission, ['id' =>'permission'.$key])}}
                                                            {{Form::label('permission'.$key,'Delete')}}<br>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                            @error('permissions')
                            <span class="invalid-permissions" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
                        <a href="{{ route('roles.index') }}" class="btn btn-danger">{{__('Cancel')}} </a>
                    </div>
                    {{Form::close()}}

                </div>
            </div>
        </div>
    </section>
@endsection
<script>

</script>
