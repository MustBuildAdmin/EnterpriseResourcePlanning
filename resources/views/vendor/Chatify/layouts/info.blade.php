
@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp

{{-- user info and avatar --}}
@if(!empty(\Auth::user()->avatar))
{{--    <div class="avatar av-l" style="background-image: url('{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'.Auth::user()->avatar) }}');">--}}
{{--        --}}
{{--    </div>--}}
    <div class="avatar av-l" style="background-image: url('{{ $profile.'/'.Auth::user()->avatar }}');">
    </div>
@else
    <div class="avatar av-l"
         style="background-image: url('{{ asset('/storage/'.config('chatify.user_avatar.folder').'/avatar.png') }}');">
    </div>
@endif
<p class="info-name">{{ config('chatify.name') }}</p>
<div class="messenger-infoView-btns">
    {{-- <a href="#" class="default"><i class="ti ti-camera"></i> default</a> --}}
    <a href="#" class="danger delete-conversation"><i class="ti ti-trash"></i> {{__('Delete Conversation')}}</a>
</div>
{{-- shared photos --}}
<div class="messenger-infoView-shared">
    <p class="messenger-title">{{__('shared photos')}}</p>
    <div class="shared-photos-list"></div>
</div>
