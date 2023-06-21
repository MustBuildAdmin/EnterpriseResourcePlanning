@foreach($project->users as $user)
    <li class="list-group-item px-0">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-auto mb-3 mb-sm-0">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded-circle avatar-sm me-3">
{{--                        <img src="@if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif " alt="kal" class="img-user">--}}
                        <img @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif  alt="image" >

                    </div>
                    <div class="div">
                        <h5 class="m-0">{{ $user->name }}</h5>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-auto text-sm-end d-flex align-items-center">
                <div class="action-btn bg-danger ms-2">
                    {!! Form::open(['method' => 'DELETE', 'route' => ['projects.user.destroy',  [$project->id,$user->id]]]) !!}
                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </li>
@endforeach
