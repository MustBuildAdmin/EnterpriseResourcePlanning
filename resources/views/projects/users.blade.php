<style>
    .user-initial {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #e0e0e0;
  color: #333;
  font-size: 24px;
  text-align: center;
  line-height: 50px;
}
</style>

@foreach($project->users as $user)
@if($user->type!='company')
<li class="list-group-item px-0">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-auto mb-3 mb-sm-0">
                <div class="d-flex align-items-center">
                    
{{--                        <img alt="" src="@if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}"
@else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif " alt="kal" class="img-user">--}}
                        @if($user->avatar)
                            <img  src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}"
                            alt="image" class="user-initial">
                        @else
                            <?php  $short=substr($user->name, 0, 1);?>
                            <span class="user-initial">{{strtoupper($short)}}</span>
                        @endif
                
                    <div class="div" style='margin-left: 10px;'>
                        <h5 class="m-0">{{ $user->name }}</h5>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-auto text-sm-end d-flex align-items-center">
                <div class="action-btn bg-danger ms-2">
                    {!! Form::open(['method' => 'DELETE',
                        'route' => ['projects.user.destroy',  [$project->id,$user->id]]]) !!}
                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip"
                    title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
</li>
@endif
@endforeach
