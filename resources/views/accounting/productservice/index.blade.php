@include('new_layouts.header')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">


<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<style>
.ms-2 {
    background: #fff  !important;
}

.ti.ti-caret-right.text-white {
    color: #000 !important;
    font-size: 18px;
}

</style>

@include('accounting.side-menu')
    <div class="row">
        <div class="col-md-6">
           <h2>{{__('Manage Product & Services')}}</h2>
        </div>
        <div class="col-md-6 float-end">
           @can('create leave')
              <a href="#" class="btn btn-sm btn-primary mb-3 floatrght" data-size="lg" data-url="{{ route('leave.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Leave')}}" >
                  <i class="ti ti-plus"></i>
              </a>
           @endcan
              <!-- <a href="#" data-size="md"  data-bs-toggle="tooltip" title="{{__('Import')}}" data-url="{{ route('productservice.file.import') }}" data-ajax-popup="true" data-title="{{__('Import product CSV file')}}" class="floatrght gapbtn btn btn-sm btn-primary">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="{{route('productservice.export')}}" data-bs-toggle="tooltip" title="{{__('Export')}}" class="gapbtn floatrght btn btn-sm btn-primary">
            <i class="ti ti-file-export"></i>
        </a> -->
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 {{isset($_GET['category'])?'show':''}}" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['productservice.index'], 'method' => 'GET', 'id' => 'product_service']) }}
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('category', __('Category'),['class'=>'form-label']) }}
                                    {{ Form::select('category', $category, null, ['class' => 'form-select','id'=>'choices-multiple', 'required' => 'required']) }}
                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary"
                                   onclick="document.getElementById('product_service').submit(); return false;"
                                   data-bs-toggle="tooltip" title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('productservice.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                   title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-arrow-back"></i></span>
                                </a>
                            </div>

                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table datatable bill">
            <thead>
            <tr>
                <th>{{__('Name')}}</th>
                <th>{{__('Sku')}}</th>
                <th>{{__('Sale Price')}}</th>
                <th>{{__('Purchase Price')}}</th>
                <th>{{__('Tax')}}</th>
                <th>{{__('Category')}}</th>
                <th>{{__('Unit')}}</th>
                <th>{{__('Quantity')}}</th>
                <th>{{__('Type')}}</th>
                <th style="width:15%">{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($productServices as $productService)
                <tr class="font-style">
                    <td>{{ $productService->name}}</td>
                    <td>{{ $productService->sku }}</td>
                    <td>{{ \Auth::user()->priceFormat($productService->sale_price) }}</td>
                    <td>{{  \Auth::user()->priceFormat($productService->purchase_price )}}</td>
                    <td>
                        @if(!empty($productService->tax_id))
                            @php
                                $taxes=\Utility::tax($productService->tax_id);
                            @endphp

                            @foreach($taxes as $tax)
                                {{ !empty($tax)?$tax->name:''  }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ !empty($productService->category)?$productService->category->name:'' }}</td>
                    <td>{{ !empty($productService->unit())?$productService->unit()->name:'' }}</td>
                    <td>{{$productService->quantity}}</td>
                    <td>{{ $productService->type }}</td>

                    @if(Gate::check('edit product & service') || Gate::check('delete product & service'))
                        <td>
                            <!-- <div class="ms-2">
                                <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-url="{{ route('productservice.detail',$productService->id) }}"
                                   data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Warehouse Details')}}" data-title="{{__('Warehouse Details')}}">
                                    <i class="ti ti-eye text-white"></i>
                                </a>
                            </div> -->

                            @can('edit product & service')
                                <div class="ms-2">
                                    <a href="#" class="mx-3 btn btn-sm  align-items-center backgroundnone" data-url="{{ route('productservice.edit',$productService->id) }}" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Product Edit')}}">
                                        <i class="ti ti-pencil text-white"></i>
                                    </a>
                                </div>
                            @endcan
                            @can('delete product & service')
                                <div class="ms-2">
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['productservice.destroy', $productService->id],'id'=>'delete-form-'.$productService->id]) !!}
                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                    {!! Form::close() !!}
                                </div>
                            @endcan
                        </td>
                    @endif
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    </div>
    </div>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
@include('new_layouts.footer')
