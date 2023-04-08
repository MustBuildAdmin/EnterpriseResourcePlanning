@include('new_layouts.header') 
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">
               
                {{__('Manage User')}}
         
            </h2>
            <div class="text-muted mt-1">1-18 of 413 people</div>
          </div>
          <!-- Page title actions -->
          <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
              <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user…"/>
              <a  href="#" data-size="lg" data-url="{{ route('users.create') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-primary">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                New user
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
      <div class="container-xl">
        <div class="row row-cards">
         
        @foreach($users as $user)
        
          <div class="col-md-6 col-lg-3">
            
            <div class="card">
                @if(Gate::check('edit user') || Gate::check('delete user'))
                <div class="card-header-right">
                    <div class="btn-group card-option">
                        @if($user->is_active==1)
                            <button type="button" class="btn dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end">

                                @can('edit user')
                                    <a href="#!" data-size="lg" data-url="{{ route('users.edit',$user->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit User')}}">
                                        <i class="ti ti-pencil"></i>
                                        <span>{{__('Edit')}}</span>
                                    </a>
                                @endcan

                                @can('delete user')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user['id']],'id'=>'delete-form-'.$user['id']]) !!}
                                    <a href="#!"  class="dropdown-item bs-pass-para">
                                        <i class="ti ti-archive"></i>
                                        <span> @if($user->delete_status!=0){{__('Delete')}} @else {{__('Restore')}}@endif</span>
                                    </a>

                                    {!! Form::close() !!}
                                @endcan

                                <a href="#!" data-url="{{route('users.reset',\Crypt::encrypt($user->id))}}" data-ajax-popup="true" data-size="md" class="dropdown-item" data-bs-original-title="{{__('Reset Password')}}">
                                    <i class="ti ti-adjustments"></i>
                                    <span>  {{__('Reset Password')}}</span>
                                </a>
                            </div>
                        @else
                            <a href="#" class="action-item"><i class="ti ti-lock"></i></a>
                        @endif

                    </div>
                </div>
            @endif
              <div class="card-body p-4 text-center">
                
                <span class="avatar avatar-xl mb-3 rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                <?php $name = strlen($user->name) > 20 ? substr($user->name,0,19)."..." : $user->name;?>
                <h3 class="m-0 mb-1"><a href="#">{{ $name }}</a></h3>
                <div class="text-muted text-center" data-bs-toggle="tooltip" title="{{__('Last Login')}}">{{ (!empty($user->last_login_at)) ? $user->last_login_at : '' }}</div>
                <div class="mt-3">
                  <span class="badge bg-purple-lt"> {{ ucfirst($user->type) }}</span>
                </div>
              </div>
              <div class="d-flex">
                <a data-bs-toggle="tooltip"  title="{{ $user->email }}" href="#" class="card-btn"><!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M3 7l9 6l9 -6" /></svg>
                  Email</a>
                <a data-bs-toggle="tooltip"  title="{{ $user->phone }}" class="card-btn"><!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                  Call</a>
              </div>
            </div>
          
          </div>
      
          @endforeach
         
    
          
        </div>
        <div class="d-flex mt-4">
          <ul class="pagination ms-auto">
            <li class="page-item disabled">
              <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                prev
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item">
              <a class="page-link" href="#">
                next <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
   
  </div>
@include('new_layouts.footer')