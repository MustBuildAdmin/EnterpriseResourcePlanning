@include('new_layouts.header')
<style>
.dropdown-toggle::after {
    display: none;
    position: absolute;
    top: 50%;
    right: 20px;
}

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

    .ts-dropdown {
        z-index: 2000;
    }

    .user-card-dropdown::after {
        display: none;
    }

    .p-2.col-example {

        background: #FFFFFF;
    }

    .row row-cards{
        background: #FFFFFF;
    }
</style>
<div class="container-fluid ">
    <div class="card mt-5 p-4">
        <div class="card-header">
            <h3>Organization</h3>
            <div class="card-actions w-50">
                <div class="row">
                    <div class="col-5">
                        <div class="mb-3">
                            <div class="row g-2">

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="row row-cards">
            @forelse($organizationList as $user)
                <div class="col-md-6 col-lg-3">
                    <div class="card">

                    @php
                        $profile = \App\Models\Utility::get_file('uploads/avatar/');
                    @endphp

                        <div class="card-body p-4 text-center">
                            <?php  $short=substr($user->company_name, 0, 2);?>
                            @if ($user->color_code != null || $user->color_code != '')
                                @php $color_co=$user->color_code; @endphp
                            @else
                                @php $color_co =Utility::rndRGBColorCode(); @endphp
                            @endif
                            @if (!empty($user->avatar))
                            <img src="{{ !empty($user->avatar) ? $profile . $user->avatar :
                            asset(Storage::url(' uploads/avatar/avatar.png ')) }}"
                            class="avatar avatar-xl mb-3 rounded" alt="">
                            @else
                            <div class="avatar avatar-xl mb-3 user-initial"
                            style='background-color:{{ $color_co }}'>
                            {{ strtoupper($short) }}
                            </div>
                            @endif
                            <h3 class="m-0 mb-1">
                                <a href="{{ route('organization_projects',$user->id) }}">
                                    {{ $user->company_name}}
                                </a>
                            </h3>
                          
                            <div class="mt-3">
                                <span class="badge bg-purple-lt"> {{ ucfirst($user->type) }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a data-bs-toggle="tooltip" data-copy_email="{{ $user->email }}"
                                title="{{ $user->email }}" href="#"
                                class="card-btn"><!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z">
                                    </path>
                                    <path d="M3 7l9 6l9 -6"></path>
                                </svg>
                                Email</a>
                            <a data-bs-toggle="tooltip" data-copy_phone="{{ $user->phone }}"
                                class="card-btn"><!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                    </path>
                                </svg>
                                Call</a>
                        </div>

                    </div>
                </div>
            @empty
                No Organization found
            @endforelse



        </div>
        <div class="d-flex mt-4">
            <ul class="pagination ms-auto">
                {!! $organizationList->links() !!}
            </ul>
        </div>
    </div>
</div>

@include('new_layouts.footer')
    
