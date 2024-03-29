
@include('new_layouts.header')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<style>
    tr.highlighted {
  padding-top: 10px;
  padding-bottom:10px
}
.user-initial {
    width: 35px !important;
    height: 35px;
    border-radius: 50%;
    background-color: #e0e0e0;
    color: #333;
    font-size: 24px;
    text-align: center;
    line-height: 35px;
    display: grid;
}
</style>
@php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
    <div class="page-wrapper">
        @include('construction_project.side-menu')
        <div class="container-fluid">
            <div class="p-4">
                <div class="card">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{__('Revision Task Progress')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active show" id="tabs-home-7" role="tabpanel">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        {{__('Revision Task Progress Information')}}
                                                    </h4>
                                                </div>
    
                                                <div class="table-responsive">
                                                    <table class="table" id="example2"
                                                     aria-describedby="revison working progress list">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">{{__('Task ID')}}</th>
                                                            <th scope="col">{{__('Task Name')}}</th>
                                                            <th scope="col">{{__('User Name')}}</th>
                                                            <th scope="col">{{__('created_at')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($result as $key => $value)
                                                            <tr>
                                                                <td>{{$value->task_id}}</td>
                                                                <td>{{$value->task_name}}</td>
                                                                @php
                                                                    $user_db = DB::table('users')
                                                                                ->where('id',$value->user_id)
                                                                                ->first();
                                                                @endphp
                                
                                                            @if($user_db)
                                                            <td>
                                                                <div class="avatar-group">
                                                                    @if($user_db->avatar)
                                                                        <span class='avatar avatar-sm'>
                                                                            <img alt='avatar'
                                                                             class="img-fluid rounded-circle"
                                                                             data-original-title="{{ $user_db!=null ?
                                                                             $user_db->name:""}}"
                                                                            @if($user_db->avatar)
                                                                                src="{{$profile.$user_db->avatar}}"
                                                                            @else
                                                                                src="{{
                                                                                    asset(Config::get('constants.URL'))
                                                                                    }}"
                                                                            @endif
                                                                        title="{{$user_db != null ?$user_db->name :""}}"
                                                                        class="hweb">
                                                                        </span>
                                                                    @else
                                                                        <?php  $short=substr($user_db->name, 0, 1);?>
                                                                        <span class="user-initial">
                                                                            {{strtoupper($short)}}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            @else
                                                            <td>{{ __('Not Assigned') }}</td>
                                                            @endif
                                                                <td>{{$value->created_at}}</td>
                                                            @empty
                                                                
                                                            @endforelse
                                
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        new DataTable('#example2', {
            pagingType: 'full_numbers',
            aaSorting: [],
            "language": {
                "sLengthMenu": "{{ __('Show _MENU_ Records') }}",
                "sZeroRecords": "{{ __('No data available in table') }}",
                "sEmptyTable": "{{ __('No data available in table') }}",
                "sInfo": "{{ __('Showing records _START_ to _END_ of a total of _TOTAL_ records') }}",
                "sInfoFiltered": "{{ __('filtering of a total of _MAX_ records') }}",
                "sSearch": "{{ __('Search') }}:",
                "oPaginate": {
                    "sFirst": "{{ __('First') }}",
                    "sLast": "{{ __('Last') }}",
                    "sNext": "{{ __('Next') }}",
                    "sPrevious": "{{ __('Previous') }}"
                },
            }
        });
    });
</script>
