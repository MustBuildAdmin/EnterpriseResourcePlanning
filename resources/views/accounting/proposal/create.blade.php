@include('new_layouts.header')
@include('accounting.side-menu')

<div class="row">
  <div class="col-md-6">
     <h2>{{__('Manage Proposals')}}</h2>
  </div>
  
  <div class="row">
      {{ Form::open(array('url' => 'proposal','class'=>'w-100')) }}
      <style>
        input {
            margin : 0px;
        }
        .item {
            margin-top: 13px;
        }
        .issue-date, .proposal-number {
            margin-top : 5px;
        }

      </style>
      <div class="col-12">
          <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
          <div class="card">
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-3">
                          <div class="form-group" id="customer-box">
                              {{ Form::label('customer_id', __('Customer'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                              {{ Form::select('customer_id', $customers,$customerId, array('class' => 'form-select','id'=>'customer','data-url'=>route('proposal.customer'),'required'=>'required')) }}
                          </div>
                      </div>
                      <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('issue_date', __('Issue Date'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                                {{Form::date('issue_date',null,array('class'=>'form-control issue-date','required'=>'required'))}}
                            </div>
                      </div>
                      <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('category_id', __('Category'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                                {{ Form::select('category_id', $category,null, array('class' => 'form-select','required'=>'required')) }}
                            </div>
                      </div>
                      <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('proposal_number', __('Proposal Number'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                                <input type="text" class="form-control proposal-number" value="{{$proposal_number}}" readonly>
                            </div>
                      </div>
                      <input type='hidden' name='user_id' id='user_id' value='0'>
                      <input type='hidden' name='indiangst' id='indiangst' value='0'>
                      <input type='hidden' name='stategst' id='stategst' value='0'>
                      @if(!$customFields->isEmpty())
                            <div class="col-md-6">
                                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                    @include('customFields.formBuilder')
                                </div>
                            </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      <div class="col-12">
          <h5 class="d-inline-block mb-4">{{__('Product & Services')}}</h5>
          <div class="card repeater">
              <div class="item-section py-2">
                  <div class="d-flex align-items-center float-end me-2">
                      <a href="#" data-repeater-create="" class="btn btn-primary mb-2" data-bs-toggle="modal" data-target="#add-bank">
                          <i class="ti ti-plus"></i> {{__('Add item')}}
                      </a>
                  </div>

                  <div class="card-body mt-3">
                  <div class="table-responsive">
                      <table class="table mb-0" data-repeater-list="items">
                          <thead>
                          <tr>
                              <th>{{__('Items')}}</th>
                              <th>{{__('Quantity')}}</th>
                              <th>{{__('Price')}} </th>
                              <th>{{__('Tax')}} (%)</th>
                              <th>{{__('Discount')}}</th>
                              <th class="text-end">{{__('Amount')}} <br>
                                  <small class="text-danger font-weight-bold">{{__('before tax & discount')}}</small>
                              </th>
                              <th></th>
                          </tr>
                          </thead>
                          <tbody class="ui-sortable" data-repeater-item>
                          <tr>
                              <td width="25%" class="form-group pt-0">
                                  {{ Form::select('item', $product_services,'', array('class' => 'form-control item'  ,'data-url'=>route('proposal.product'),'required'=>'required')) }}
                              </td>
                              <td>
                                  <div class="form-group price-input input-group search-form">
                                      {{ Form::text('quantity','', array('class' => 'form-control quantity','required'=>'required','placeholder'=>__('Qty'),'required'=>'required')) }}
                                      <span class="unit input-group-text bg-transparent"></span>
                                  </div>
                              </td>
                              <td>
                                  <div class="form-group price-input input-group search-form">
                                      {{ Form::text('price','', array('class' => 'form-control price','required'=>'required','placeholder'=>__('Price'),'required'=>'required')) }}
                                      <span class="input-group-text bg-transparent">{{\Auth::user()->currencySymbol()}}</span>
                                  </div>
                              </td>
                              <td>
                                  <div class="form-group">
                                      <div class="input-group">
                                          <div class="taxes"></div>
                                          {{ Form::hidden('tax','', array('class' => 'form-control tax')) }}
                                          {{ Form::hidden('itemTaxPrice','', array('class' => 'form-control itemTaxPrice')) }}
                                          {{ Form::hidden('itemTaxRate','', array('class' => 'form-control itemTaxRate')) }}
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="form-group price-input input-group search-form">
                                      {{ Form::text('discount','', array('class' => 'form-control discount','required'=>'required','placeholder'=>__('Discount'))) }}
                                      <span class="input-group-text bg-transparent">{{\Auth::user()->currencySymbol()}}</span>
                                  </div>
                              </td>
                              <td class="text-end amount">
                                  0.00
                              </td>
                              <td>
                                  <a href="#" class="ti ti-trash text-white text-danger" data-repeater-delete></a>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <div class="form-group">
                                      {{ Form::textarea('description', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Description')]) }}
                                  </div>
                              </td>
                              <td colspan="5"></td>
                          </tr>
                          </tbody>
                          <tfoot>
                          <tr class="border-none">
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td></td>
                              <td><strong>{{__('Sub Total')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                              <td class="text-end subTotal">0.00</td>
                              <td></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td></td>
                              <td><strong>{{__('Discount')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                              <td class="text-end totalDiscount">0.00</td>
                              <td></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td></td>
                              <td><strong>{{__('Tax')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                              <td class="text-end totalTax">0.00</td>
                              <td></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td class="blue-text border-none"><strong>{{__('Total Amount')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                              <td class="text-end totalAmount blue-text border-none"></td>
                              <td></td>
                          </tr>
                          </tfoot>
                      </table>
                  </div>
              </div>
              </div>
          </div>

          <div class="modal-footer">
              <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("proposal.index")}}';" class="btn btn-light">
              <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
          </div>
          {{ Form::close() }}
      </div>
  </div>
</div>
@include('new_layouts.footer')
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
  <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
  <script>
      var selector = "body";
      if ($(selector + " .repeater").length) {
          var $dragAndDrop = $("body .repeater tbody").sortable({
              handle: '.sort-handler'
          });
          var $repeater = $(selector + ' .repeater').repeater({
              initEmpty: false,
              defaultValues: {
                  'status': 1
              },
              show: function () {
                  $(this).slideDown();
                  var file_uploads = $(this).find('input.multi');
                  if (file_uploads.length) {
                      $(this).find('input.multi').MultiFile({
                          max: 3,
                          accept: 'png|jpg|jpeg',
                          max_size: 2048
                      });
                  }
                  $('.select2').select2();
              },
              hide: function (deleteElement) {
                  if (confirm('Are you sure you want to delete this element?')) {
                      $(this).slideUp(deleteElement);
                      $(this).remove();

                      var inputs = $(".amount");
                      var subTotal = 0;
                      for (var i = 0; i < inputs.length; i++) {
                          subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                      }
                      $('.subTotal').html(subTotal.toFixed(2));
                      $('.totalAmount').html(subTotal.toFixed(2));
                  }
              },
              ready: function (setIndexes) {
                  $dragAndDrop.on('drop', setIndexes);
              },
              isFirstItemUndeletable: true
          });
          var value = $(selector + " .repeater").attr('data-value');
          if (typeof value != 'undefined' && value.length != 0) {
              value = JSON.parse(value);
              $repeater.setList(value);
          }

      }

      $(document).on('change', '#customer', function () {
          $('#customer_detail').removeClass('d-none');
          $('#customer_detail').addClass('d-block');
          $('#customer-box').removeClass('d-block');
        //   $('#customer-box').addClass('d-none');
          var id = $(this).val();
          var url = $(this).data('url');
          $.ajax({
              url: url,
              type: 'POST',
              headers: {
                  'X-CSRF-TOKEN': jQuery('#token').val()
              },
              data: {
                  'id': id
              },
              cache: false,
              success: function (data) {
                  if (data != '') {
                      $('#customer_detail').html(data);
                  } else {
                      $('#customer-box').removeClass('d-none');
                      $('#customer-box').addClass('d-block');
                      $('#customer_detail').removeClass('d-block');
                      $('#customer_detail').addClass('d-none');
                  }
              },

          });
      });

      $(document).on('click', '#remove', function () {
          $('#customer-box').removeClass('d-none');
          $('#customer-box').addClass('d-block');
          $('#customer_detail').removeClass('d-block');
          $('#customer_detail').addClass('d-none');
      })


      $(document).on('change', '.item', function () {


          var iteams_id = $(this).val();
          var url = $(this).data('url');
          var el = $(this);
          $.ajax({
              url: url,
              type: 'POST',
              headers: {
                  'X-CSRF-TOKEN': jQuery('#token').val()
              },
              data: {
                  'product_id': iteams_id
              },
              cache: false,
              success: function (data) {
                  var item = JSON.parse(data);

                  $(el.parent().parent().find('.quantity')).val(1);
                  $(el.parent().parent().find('.price')).val(item.product.sale_price);
                  var taxes = '';
                  var tax = [];

                  var totalItemTaxRate = 0;
                  if (item.taxes == 0) {
                      taxes += '-';
                  } else {
                      for (var i = 0; i < item.taxes.length; i++) {
                          taxes += '<span class="badge  badge bg-primary mt-1 mr-2">' + item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' + '</span>';
                          tax.push(item.taxes[i].id);
                          totalItemTaxRate += parseFloat(item.taxes[i].rate);
                      }
                  }

                  var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (item.product.sale_price * 1));

                  $(el.parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));
                  $(el.parent().parent().find('.itemTaxRate')).val(totalItemTaxRate.toFixed(2));
                  $(el.parent().parent().find('.taxes')).html(taxes);
                  $(el.parent().parent().find('.tax')).val(tax);
                  $(el.parent().parent().find('.unit')).html(item.unit);
                  $(el.parent().parent().find('.discount')).val(0);
                  $(el.parent().parent().find('.amount')).html(item.totalAmount);


                  var inputs = $(".amount");
                  var subTotal = 0;
                  for (var i = 0; i < inputs.length; i++) {
                      subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                  }
                  $('.subTotal').html(subTotal.toFixed(2));


                  var totalItemPrice = 0;
                  var priceInput = $('.price');
                  for (var j = 0; j < priceInput.length; j++) {
                      totalItemPrice += parseFloat(priceInput[j].value);
                  }

                  var totalItemTaxPrice = 0;
                  var itemTaxPriceInput = $('.itemTaxPrice');
                  for (var j = 0; j < itemTaxPriceInput.length; j++) {
                      totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                  }

                  $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                  $('.totalAmount').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));
              },
          });
      });


      $(document).on('keyup', '.quantity', function () {

          var quntityTotalTaxPrice = 0;

          var el = $(this).parent().parent().parent().parent();
          var quantity = $(this).val();
          var price = $(el.find('.price')).val();
          var discount = $(el.find('.discount')).val();

          var totalItemPrice = (quantity * price);
          var amount = (totalItemPrice);
          $(el.find('.amount')).html(amount);

          var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
          var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
          $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));


          var totalItemTaxPrice = 0;
          var itemTaxPriceInput = $('.itemTaxPrice');
          for (var j = 0; j < itemTaxPriceInput.length; j++) {
              totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
          }


          var inputs = $(".amount");
          var subTotal = 0;
          for (var i = 0; i < inputs.length; i++) {
              subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
          }
          $('.subTotal').html(subTotal.toFixed(2));
          $('.totalTax').html(totalItemTaxPrice.toFixed(2));

          $('.totalAmount').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));


      })

      $(document).on('keyup', '.price', function () {
          var el = $(this).parent().parent().parent().parent();
          var price = $(this).val();
          var quantity = $(el.find('.quantity')).val();
          var discount = $(el.find('.discount')).val();
          var totalItemPrice = (quantity * price);

          var amount = (totalItemPrice);
          $(el.find('.amount')).html(amount);


          var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
          var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
          $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));


          var totalItemTaxPrice = 0;
          var itemTaxPriceInput = $('.itemTaxPrice');
          for (var j = 0; j < itemTaxPriceInput.length; j++) {
              totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
          }


          var inputs = $(".amount");
          var subTotal = 0;
          for (var i = 0; i < inputs.length; i++) {
              subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
          }
          $('.totalTax').html(totalItemTaxPrice.toFixed(2));

          $('.subTotal').html(subTotal.toFixed(2));
          $('.totalAmount').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));

      })

      $(document).on('keyup', '.discount', function () {
          var el = $(this).parent().parent().parent().parent();
          var discount = $(this).val();
          var price = $(el.find('.price')).val();

          var quantity = $(el.find('.quantity')).val();
          var totalItemPrice = (quantity * price);

          var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
          var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
          $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));


          var totalItemTaxPrice = 0;
          var itemTaxPriceInput = $('.itemTaxPrice');
          for (var j = 0; j < itemTaxPriceInput.length; j++) {
              totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
          }


          var totalItemDiscountPrice = 0;
          var itemDiscountPriceInput = $('.discount');

          for (var k = 0; k < itemDiscountPriceInput.length; k++) {

              totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
          }

          var amount = (totalItemPrice);
          $(el.find('.amount')).html(amount);

          var inputs = $(".amount");
          var subTotal = 0;
          for (var i = 0; i < inputs.length; i++) {
              subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
          }
          $('.subTotal').html(subTotal.toFixed(2));
          $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));
          $('.totalTax').html(totalItemTaxPrice.toFixed(2));

          $('.totalAmount').html((parseFloat(subTotal) - parseFloat(totalItemDiscountPrice) + parseFloat(totalItemTaxPrice)).toFixed(2));
      })

      var customerId = '{{$customerId}}';
      if (customerId > 0) {
          $('#customer').val(customerId).change();
      }

  </script>