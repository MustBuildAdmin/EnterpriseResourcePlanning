
@include('new_layouts.header')
@include('accounting.side-menu')



<div class="row">
  <div class="col-md-6">
      <h2>{{__('Manage Product-Service & Income-Expense Category')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

  @can('create constant category')
            <a  class="btn btn-sm btn-primary floatrght" href="#" data-url="{{ route('product-category.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" title="{{__('Create')}}" data-title="{{__('Create New Category')}}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan

  </div>
</div>





    <div class="row">
        <div class="col-3">
            @include('layouts.account_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{__('Category')}}</th>
                                <th> {{__('Type')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="font-style">{{ $category->name }}</td>
                                    <td class="font-style">
                                        {{ __(\App\Models\ProductServiceCategory::$categoryType[$category->type]) }}
                                    </td>
                                    <td class="Action">


                                    <div class="col-md-6 floatleft ">

                                        @can('edit constant category')
                                            <div class="action-btn ms-2">
                                                <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-url="{{ route('product-category.edit',$category->id) }}" data-ajax-popup="true" data-title="{{__('Edit Product Category')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        @endcan

                                        </div>

                                        <div class="col-md-6 floatleft">
                                        @can('delete constant category')
                                                <div class="action-btn  ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['product-category.destroy', $category->id],'id'=>'delete-form-'.$category->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$category->id}}').submit();">
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
 

    @include('new_layouts.footer')