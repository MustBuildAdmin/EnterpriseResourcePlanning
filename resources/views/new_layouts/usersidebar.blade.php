<div class="col-3 d-none d-md-block border-end">
<div class="card-body">
    <div class="list-group list-group-transparent">
        <a href="{{ route('my-info') }}"  class="{{request()->route()->uri =='my-info' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('MyInfo') }} </a>
        <a href="{{ route('my-leave') }}"  class="{{request()->route()->uri =='my-leave' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('MyLeave') }} </a>
        <a href="{{ route('my-payslip') }}"  class="{{request()->route()->uri =='my-payslip' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('MyPayslip') }} </a>
        <a href="{{ route('my-performance') }}"  class="{{request()->route()->uri =='my-performance' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('MyPerformance') }} </a>
        <a href="{{ route('my-goals') }}"  class="{{request()->route()->uri =='my-goals' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Mygoals') }} </a>
        <a href="{{ route('my-relief') }}"  class="{{request()->route()->uri =='my-relief' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Myrelief') }} </a>
        <a href="{{ route('my-appraisal') }}"  class="{{request()->route()->uri =='my-appraisal' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Myappraisal') }} </a>

    </div>
</div>
</div>