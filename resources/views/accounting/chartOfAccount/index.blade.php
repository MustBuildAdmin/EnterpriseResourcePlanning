@include('new_layouts.header')
@include('accounting.side-menu')

<div class="row">

<div class="row">
  <div class="col-md-6">
     <h2>{{__('Manage Chart of Accounts')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

       @can('create chart of account')
                <a href="#" data-url="{{ route('chart-of-account.create') }}" data-bs-toggle="tooltip" title="{{__('Create')}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Account')}}" class="floatrght mb-3 btn btn-sm btn-primary">
                    <i class="ti ti-plus"></i>
                </a>
        @endcan

  </div>
</div>

    <div class="row">
        @foreach($chartAccounts as $type=>$accounts)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6>{{$type}}</h6>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th> {{__('Code')}}</th>
                                    <th> {{__('Name')}}</th>
                                    <th> {{__('Type')}}</th>
                                    <th> {{__('Balance')}}</th>
                                    <th> {{__('Status')}}</th>
                                    <th width="10%"> {{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($accounts as $account)

                                    <tr>
                                        <td>{{ $account->code }}</td>
                                        <td><a href="{{route('report.ledger')}}?account={{$account->id}}">{{ $account->name }}</a></td>
                                        <td>{{!empty($account->subType)?$account->subType->name:'-'}}</td>
                                        <td>
                                            @if(!empty($account->balance()) && $account->balance()['netAmount']<0)
                                                {{__('Dr').'. '.\Auth::user()->priceFormat(abs($account->balance()['netAmount']))}}
                                            @elseif(!empty($account->balance()) && $account->balance()['netAmount']>0)
                                                {{__('Cr').'. '.\Auth::user()->priceFormat($account->balance()['netAmount'])}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($account->is_enabled==1)
                                                <span class="badge bg-success p-2 px-3 rounded">{{__('Enabled')}}</span>
                                            @else
                                                <span class="badge bg-danger p-2 px-3 rounded">{{__('Disabled')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                      <div class="ms-2" style="display:flex;gap:10px;">
                                        <a href="{{route('report.ledger')}}?account={{$account->id}}" class="mx-3 btn btn-sm align-items-center backgroundnone" data-bs-toggle="tooltip" title="{{__('View')}}" data-original-title="{{__('Ledger Summary')}}">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            @can('edit chart of account')
                                                <div class="action-btn ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-url="{{ route('chart-of-account.edit',$account->id) }}" data-ajax-popup="true" data-title="{{__('Edit Account')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('delete chart of account')
                                                <div class="action-btn ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['chart-of-account.destroy', $account->id],'id'=>'delete-form-'.$account->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$account->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan
                                      </div>
                                  </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
{{-- @push('script-page') --}}
<script>
    $(document).on('change', '#type', function () {
        var type = $(this).val();
        $.ajax({
            url: '{{route('charofAccount.subType')}}',
            type: 'POST',
            data: {
                "type": type, "_token": "{{ csrf_token() }}",
            },
            success: function (data) {
                $('#sub_type').empty();
                $.each(data, function (key, value) {
                    $('#sub_type').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    });

</script>
{{-- @endpush --}}
@include('new_layouts.footer')
