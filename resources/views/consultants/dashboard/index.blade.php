@include('new_layouts.header')
<style>
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
</style>
<div class="container-fluid ">
    <div class="card mt-5 p-4">
        <div class="card-header">
            <h3>Companies</h3>
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
            @forelse($users as $user)
                <div class="col-md-6 col-lg-3">
                    <div class="card">


                        <div class="card-body p-4 text-center">
                            <span class="avatar avatar-xl mb-3 rounded"
                                style="background-image: url(./static/avatars/000m.jpg)"></span>
                                @php $short = substr($user->name, 0, 1); @endphp
                                @php $short_lname = substr($user->lname, 0, 1); @endphp
                            <h3 class="m-0 mb-1"><a href="#"> {{ strtoupper($short) }}{{ strtoupper($short_lname) }}</a></h3>
                            @php
                            $name = strlen($user->name) > 20 ? substr($user->name, 0, 19) . '...' : $user->name; 
                            @endphp
                            <div class="text-secondary">{{$name}}</div>
                            <div class="mt-3">
                                <span class="badge bg-purple-lt"> {{ ucfirst($user->type)  }}</span>
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
                No Companies found
            @endforelse



        </div>
        <div class="d-flex mt-4">
            <ul class="pagination ms-auto">
                {!! $users->links() !!}
            </ul>
        </div>
    </div>
</div>

</div>
</div>
