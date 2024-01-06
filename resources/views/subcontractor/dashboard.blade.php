@include('new_layouts.header')
<style>


   

    .avatar.avatar-xl.mb-3.user-initial {
        border-radius: 50%;
        color: #FFF;
    }

    .avatar-xl {
        --tblr-avatar-size: 6.2rem;
    }

    html,
    body {
        height: 100%;
        padding: 0px;
        margin: 0px;
        overflow: scroll;
    }


    

    .p-2.col-example {

        background: #FFFFFF;
    }

    .row row-cards{
        background: #FFFFFF;
    }
</style>

@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp
<div class="container-fluid ">
  
    <div class="card mt-5 p-4">
        <div class="card-header">
           <h3>{{ __('Organisation') }}</h3>
          
        </div>
        <div class="row row-cards mt-2">
           @forelse($users as $user)
           <div class="col-md-6 col-lg-2">
              <div class="card">
                 <div class="ms-auto lh-1 p-2">
                    @if ($user->color_code != null || $user->color_code != '')
                    @php $color_co=$user->color_code; @endphp
                    @else
                    @php $color_co =Utility::rndRGBColorCode(); @endphp
                    @endif
                  
                 </div>
                 @php $short=substr($user->name, 0, 1); @endphp
                 @php $short_lname=substr($user->lname, 0, 1); @endphp
                 <div class="card-body p-2 text-center">
                    @if (!empty($user->avatar))
                    <img src="{{ !empty($user->avatar) ? $profile . $user->avatar :
                       asset(Storage::url(' uploads/avatar/avatar.png ')) }}"
                       class="avatar avatar-xl mb-3 rounded" alt="">
                    @else
                    <div class="avatar avatar-xl mb-3 user-initial"
                       style='background-color:{{ $color_co }}'>
                       {{ strtoupper($short) }}{{ strtoupper($short_lname) }}
                    </div>
                    @endif
                    @php
                    $name=strlen($user->name) > 20 ? substr($user->name,0,19)."..." : $user->name;
                    $lname=strlen($user->lname) > 20 ? substr($user->lname,0,19)."..." : $user->lname;
                    @endphp
                    <h3 class="m-0 mb-1"><a href="{{ route('construction_main',['id' => Crypt::encrypt($user->id)]) }}">{{ $name }} {{ $lname }}</a></h3>
                    {{--
                    <div class="text-secondary">UI Designer</div>
                    --}}
                    <div class="mt-3">
                       <span class="badge bg-purple-lt">
                       {{ucfirst($user->type)}}
                       </span>
                    </div>
                 </div>
                 <div class="d-flex">
                    <a data-bs-toggle="tooltip"
                       title="{{ $user->email }}" class="card-btn"
                       href="https://mail.google.com/mail/?view=cm&fs=1&to={{$user->email}}">
                       <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                       <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24"
                          height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                          fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path
                             d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2
                             2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z">
                          </path>
                          <path d="M3 7l9 6l9 -6"></path>
                       </svg>
                       {{ __('Email') }}
                    </a>
                    <a data-bs-toggle="tooltip"
                       title="{{ $user->phone }}" class="card-btn" href="tel:{{ $user->phone }}">
                       <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                       <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24"
                          height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                          fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path
                             d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1
                             -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                          </path>
                       </svg>
                       {{ __('Call') }}
                    </a>
                 </div>
              </div>
           </div>
           @empty
           <div class="empty">
              <p class="empty-title"> {{ __('Invite a Sub Contractor') }}</p>
              <p class="empty-subtitle text-secondary">
                 {{ __(Config::get('constants.NOSUB')) }}
              </p>
              <div class="empty-action">
                 <a class="btn btn-primary" data-bs-toggle="modal" data-size="lg"
                    data-url="{{ route('subcontractor.invite_sub_contractor') }}" data-ajax-popup="true"
                    data-bs-toggle="tooltip" title="{{ __('Invite Sub Contractor') }}"
                    data-bs-original-title="{{ __('Invite Sub Contractor') }}">
                 {{ __('Invite a Sub Contractor') }}
                 </a>
              </div>
           </div>
           @endforelse
           <div class="d-flex mt-4">
              <ul class="pagination ms-auto">
                 {!! $users->links() !!}
              </ul>
           </div>
        </div>
     </div>
</div>
</div>
</div>
@include('new_layouts.footer')

