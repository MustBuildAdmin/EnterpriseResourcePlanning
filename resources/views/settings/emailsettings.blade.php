@include('new_layouts.header')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                        {{ __('Admin Settings') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="row g-0">
                    @include('new_layouts.sidebar')
                        <div class="col d-flex flex-column">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($EmailTemplates as $EmailTemplate)
                                        <div class="col-lg-4 col-md-6 col-sm-6 form-group emaildiv">
                                            <div class="list-group ">
                                                <div class="list-group-item form-switch form-switch-right emailtemplates">
                                                    <label class="form-label" >{{ $EmailTemplate->name }}</label>
                                                    <input class="form-check-input email-template-checkbox" id="email_tempalte_{{!empty($EmailTemplate->template)?$EmailTemplate->template->id:''}}" type="checkbox"
                                                        @if(!empty($EmailTemplate->template)?$EmailTemplate->template->is_active:0 == 1) checked="checked" @endif type="checkbox" value="{{!empty($EmailTemplate->template)?$EmailTemplate->template->is_active:1}}"
                                                        data-url="{{route('status.email.language',[!empty($EmailTemplate->template)?$EmailTemplate->template->id:''])}}" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')
<script type="text/javascript">

        $(document).on("click", ".email-template-checkbox", function () {
            var chbox = $(this);
            $.ajax({
                url: chbox.attr('data-url'),
                data: {_token: $('meta[name="csrf-token"]').attr('content'), status: chbox.val()},
                type: 'PUT',
                success: function (response) {
                    if (response.is_success) {
                        show_toastr('success', response.success, 'success');
                        if (chbox.val() == 1) {
                            $('#' + chbox.attr('id')).val(0);
                        } else {
                            $('#' + chbox.attr('id')).val(1);
                        }
                    } else {
                        show_toastr('Error', response.error, 'error');
                    }
                },
                error: function (response) {
                    response = response.responseJSON;
                    if (response.is_success) {
                        show_toastr('Error', response.error, 'error');
                    } else {
                        show_toastr('Error', response, 'error');
                    }
                }
            })
        });

    </script>
<style>
.emailtemplates {
    display: flex;
    flex-direction: row;
    justify-content:space-between;
}
.email-template-checkbox{
    margin-left:0px !important;
}
.emaildiv {
    margin-bottom: 10px;
}
</style>