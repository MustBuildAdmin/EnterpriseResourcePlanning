@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp

<div class="container-xl">
    <div class="row row-cards">
        @forelse($users as $user)
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    @if ($user->color_code != null || $user->color_code != '')
                        @php $color_co =$user->color_code; @endphp
                    @else
                        @php $color_co =Utility::rndRGBColorCode(); @endphp
                    @endif
                    <div class="card-body p-4 text-center">
                        <?php $short = substr($user->name, 0, 1); ?>
                        <?php $short_lname = substr($user->lname, 0, 1); ?>
                        @if (!empty($user->avatar))
                            <img src="{{ !empty($user->avatar)
                                ? $profile . \Auth::user()->avatar
                                : asset(Storage::url(' uploads/avatar/avatar.png ')) }}"
                                class="avatar avatar-xl mb-3 rounded" alt="">
                        @else
                            <div class="avatar avatar-xl mb-3 user-initial" style='background-color:{{ $color_co }}'>
                                {{ strtoupper($short) }}{{ strtoupper($short_lname) }}
                            </div>
                        @endif
                        <?php $name = strlen($user->name) > 20 ? substr($user->name, 0, 19) . '...' : $user->name; ?>
                        <h3 class="m-0 mb-1">
                            <a href="#">{{ $name }}</a>
                        </h3>
                    </div>
                    @if (\Auth::user()->type != 'super admin')
                        <div class="d-flex">
                            <a data-bs-toggle="tooltip" data-copy_email="{{ $user->email }}"
                                title="{{ $user->email }}" href="#" class="card-btn"
                                onclick="copyToClipboard(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg> {{ __('Email') }}
                            </a>
                            <a data-bs-toggle="tooltip" data-copy_phone="{{ $user->phone }}"
                                title="{{ $user->phone }}" class="card-btn" onclick="copyToClipboardphone(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15
                                    -15a2 2 0 0 1 2 -2" />
                                </svg> {{ __('Mobile') }}
                            </a>
                        </div>
                    @else
                        <div class="row justify-content-between align-items-center"></div>
                    @endif
                </div>
            </div>
        @empty
        @endforelse
    </div>
