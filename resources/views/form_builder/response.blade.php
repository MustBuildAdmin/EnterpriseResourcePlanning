@extends('layouts.admin')
@section('page-title')
    {{ $form->name.__("'s Response") }}
@endsection
@push('script-page')

@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('form_builder.index')}}">{{__('Form Builder')}}</a></li>
    <li class="breadcrumb-item">{{__('Response')}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            @if($form->response->count() > 0)
                            <tbody>
                            @php
                                $first = null;
                                $second = null;
                                $third = null;
                                $i = 0;
                            @endphp
                            @foreach ($form->response as $response)
                                @php
                                    $i++;
                                        $resp = json_decode($response->response,true);
                                        if(count($resp) == 1)
                                        {
                                            $resp[''] = '';
                                            $resp[' '] = '';
                                        }
                                        elseif(count($resp) == 2)
                                        {
                                            $resp[''] = '';
                                        }
                                        $firstThreeElements = array_slice($resp, 0, 3);

                                        $thead= array_keys($firstThreeElements);
                                        $head1 = ($first != $thead[0]) ? $thead[0] : '';
                                        $head2 = (!empty($thead[1]) && $second != $thead[1]) ? $thead[1] : '';
                                        $head3 = (!empty($thead[2]) && $third != $thead[2]) ? $thead[2] : '';
                                @endphp
                                @if(!empty($head1) || !empty($head2) || !empty($head3) && $head3 != ' ')
                                    <tr>
                                        <th>{{ $head1 }}</th>
                                        <th>{{ $head2 }}</th>
                                        <th>{{ $head3 }}</th>
                                        <th>#</th>
                                    </tr>
                                @endif
                                @php
                                    $first =  $thead[0];
                                    $second =  $thead[1];
                                    $third =  $thead[2];
                                @endphp
                                <tr>
                                    @foreach(array_values($firstThreeElements) as $ans)
                                        <td>{{$ans}}</td>
                                    @endforeach
                                    <td class="Action">
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('response.detail',$response->id) }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('View')}}" data-title="{{__('Response Detail')}}">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            @else
                                <tbody>
                                <tr>
                                    <td class="text-center">{{__('No data available in table')}}</td>
                                </tr>
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

