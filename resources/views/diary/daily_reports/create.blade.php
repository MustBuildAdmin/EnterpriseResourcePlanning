@include('new_layouts.header')
@include('construction_project.side-menu')



<h2>Contractor's daily construction report</h2>

<div class="maindivreport">
    <div class="row">
         

            <div class="form-group col-md-4">
                <div class="form-group">
                <div class="col-md-4 float-left">
                     {{ Form::label('reference', __('Daily Report No'),['class'=>'form-label']) }}
                </div>
                <div class="form-icon-user col-md-8 float-left">
                     {{ Form::text('MInTemp', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Daily Report No')]) }}
        
                </div>
            </div>
            </div> 

            <div class="form-group col-md-4">
                <div class="form-group">
                <div class="col-md-4 float-left">
                     {{ Form::label('reference', __('Contractor Name'),['class'=>'form-label']) }}
                </div>
                <div class="form-icon-user col-md-8 float-left">
                   {{ Form::text('MInTemp', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Contractor Name')]) }}
                </div>
            </div>
            </div> 
        

            <div class="form-group col-md-4">
                <div class="form-group">
                <div class="col-md-4 float-left">
                     {{ Form::label('reference', __('Date'),['class'=>'form-label']) }}
                </div>
                <div class="form-icon-user col-md-8 float-left">
                    {{ Form::date('MInTemp', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Date')]) }}
                </div>
            </div>
            </div> 


            <div class="form-group col-md-4">
                <div class="form-group">
                <div class="col-md-4 float-left">
                     {{ Form::label('reference', __('Project Name'),['class'=>'form-label']) }}
                </div>
                <div class="form-icon-user col-md-8 float-left">
                    {{ Form::text('MInTemp', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Project Name')]) }}
                </div>
            </div>
            </div>        


            <div class="form-group col-md-4">
                <div class="form-group">
                <div class="col-md-4 float-left">
                   {{Form::label('weather',__('weather'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                </div>
                <div class="form-icon-user col-md-8 float-left">
                    <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select' required multiple>
                        <option value="">{{ __('Select weather ...') }}</option>  
                              <option value="">Clear</option>
                              <option value="">Dust</option>
                              <option value="">windy</option>
                              <option value="">Rain</option>
                    </select>
                </div>
            </div>
            </div>


            <div class="form-group col-md-4">
                <div class="form-group">
                <div class="col-md-4 float-left">
                   {{Form::label('Site conditions',__('Site conditions'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                </div>
                <div class="form-icon-user col-md-8 float-left">
                    <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select' required multiple>
                        <option value="">{{ __('Select Site conditions ...') }}</option>  
                              <option value="">Clear</option>
                              <option value="">Dusty</option>
                              <option value="">Muddy</option>
                    </select>
                </div>
            </div>
            </div>

            <div class="form-group col-md-4">
                <div class="form-group">
                <div class="col-md-4 float-left">
                   {{Form::label('Day',__('Day'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                </div>
                <div class="form-icon-user col-md-8 float-left">
                    <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select' required multiple>
                        <option value="">{{ __('Select Day ...') }}</option>  
                              <option value="">Monday</option>
                              <option value="">Tuseday</option>
                              <option value="">wednesday</option>
                              <option value="">Thursday</option>
                    </select>
                </div>
            </div>
            </div>


            <div class="form-group col-md-4">
                <div class="form-group">
                <div class="col-md-4 float-left">
                   {{Form::label('Temparture',__('Temparture'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                </div>
                <div class="form-icon-user gapbtn  col-md-2 float-left">
                  {{ Form::text('Max Temp', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Max Temp')]) }}
                </div>
                <div class="form-icon-user col-md-2 float-left">
                  {{ Form::text('MIn Temp', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('MIn Temp')]) }}
                </div>
                <div class="form-icon-user col-md-3 float-left tempselect" style="">
                <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select' required multiple>
                        <option value="">{{ __('Select Day ...') }}</option>  
                              <option value="">Celicus</option>
                              <option value="">Fahrenheit</option>
                    </select>
                </div>
            </div>
            </div>


    </div>




    <div class="col-12">
            <!-- <h5 class="d-inline-block mb-4">{{__('Product & Services')}}</h5> -->
            <div class="card repeater">
                <div class="item-section py-2">

                    <div class="card-body mt-3">
                    <div class="table-responsive tablereport">
    

                    <table class="table mb-0" data-repeater-list="items">
                            <thead>
                            <tr>
                                <th>{{__('Contractor')}}
                                <a href="#" data-repeater-create="" class="addBtn floatrght btn btn-primary mb-2" data-bs-toggle="modal" data-target="#add-bank">
                                    <i class="ti ti-plus "></i>
                                </a>    
                                </th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="ui-sortable" data-repeater-item>
                            <tr>
                                 <td>
                                    <div class="form-group">
                                    
                                    <div class="col-md-7 float-left dropdowmselect">
                                        <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select selectbox' required multiple>
                                                <option value="">{{ __('Select Day ...') }}</option>  
                                                <option value="">Monday</option>
                                                <option value="">Tuseday</option>
                                                <option value="">wednesday</option>
                                                <option value="">Thursday</option>
                                        </select>
                                    </div>

                                    <div class="col-md-5 float-left">
                                        {{ Form::text('description', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Number')]) }}
                                    </div>

                                    </div>
                                 </td>

                                <!-- <td>
                                    <a href="#" class="ti ti-trash text-white text-danger" data-repeater-delete></a>
                                    <a href="#" class="ti ti-eye text-white text-danger" data-repeater-delete></a>
                                    <a href="#" class="ti ti-edit text-white text-danger" data-repeater-delete></a>
                                </td> -->
                            </tr>

                            </tbody>
                            <tfoot>

                            </tfoot>

                            
                          

                        </table>


                        <table class="table mb-0" data-repeater-list="items">
                            <thead>
                            <tr>
                                <th>{{__('Sub Contractor')}}

                                    <a href="#" data-repeater-create="" class="floatrght btn btn-primary mb-2" data-bs-toggle="modal" data-target="#add-bank">
                                        <i class="ti ti-plus"></i>
                                    </a>
                                </th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="ui-sortable" data-repeater-item>
                            <tr>
                                 <td>
                                    <div class="form-group">
                                    
                                    <div class="col-md-7 float-left dropdowmselect">
                                        <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select selectbox' required multiple>
                                                <option value="">{{ __('Select Day ...') }}</option>  
                                                <option value="">Monday</option>
                                                <option value="">Tuseday</option>
                                                <option value="">wednesday</option>
                                                <option value="">Thursday</option>
                                        </select>
                                    </div>

                                    <div class="col-md-5 float-left">
                                        {{ Form::text('description', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Number')]) }}
                                    </div>

                                    </div>
                                 </td>

                                <!-- <td>
                                    <a href="#" class="ti ti-trash text-white text-danger" data-repeater-delete></a>
                                    <a href="#" class="ti ti-eye text-white text-danger" data-repeater-delete></a>
                                    <a href="#" class="ti ti-edit text-white text-danger" data-repeater-delete></a>
                                </td> -->

                            </tr>

                            </tbody>
                            <tfoot>

                            </tfoot>

                            
                          

                        </table>

                        <table class="table mb-0" data-repeater-list="items">
                            <thead>
                            <tr>
                                <th>{{__('Major Equipment on project')}} 
                                
                                <a href="#" data-repeater-create="" class="floatrght btn btn-primary mb-2" data-bs-toggle="modal" data-target="#add-bank">
                                    <i class="ti ti-plus"></i>
                                </a>

                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="ui-sortable" data-repeater-item>
                            <tr>
                                 <td>
                                    <div class="form-group">
                                    
                                    <div class="col-md-7 float-left dropdowmselect">
                                        <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select selectbox' required multiple>
                                                <option value="">{{ __('Select Day ...') }}</option>  
                                                <option value="">Monday</option>
                                                <option value="">Tuseday</option>
                                                <option value="">wednesday</option>
                                                <option value="">Thursday</option>
                                        </select>
                                    </div>

                                    <div class="col-md-5 float-left">
                                        {{ Form::text('description', null, ['class'=>'form-control','rows'=>'1','placeholder'=>__('Number')]) }}
                                    </div>

                                    </div>
                                 </td>

<!-- 
                                <td>
                                    <a href="#" class="ti ti-trash text-white text-danger" data-repeater-delete></a>
                                    <a href="#" class="ti ti-eye text-white text-danger" data-repeater-delete></a>
                                    <a href="#" class="ti ti-edit text-white text-danger" data-repeater-delete></a>
                                </td> -->
                            </tr>

                            </tbody>
                            <tfoot>

                            </tfoot>

                            
                          

                        </table>




                    </div>


                    <div class="col-md-4 form-group">
                        <label name="document" for="" class="form-label">{{__('Document')}} <span style='color:red;'>*</span></label>
                        <div class="choose-file ">
                            <label for="document" class="form-label">
                                <input name="inputimage" type="file" class="form-control" name="document" id="document" data-filename="document_create" required>.
                                {{-- <img id="image" class="mt-3" style="width:25%;"/> --}}
                                <br>
                                <span class="show_document_file" style="color:green;"></span>
                            </label>
                        </div>
                    </div>


                    <div class="col-md-4 form-group">
                        <label name="document" for="" class="form-label">{{__('Document')}} <span style='color:red;'>*</span></label>
                        <div class="choose-file ">
                            <label for="document" class="form-label">
                                <input name="inputimage" type="file" class="form-control" name="document" id="document" data-filename="document_create" required>.
                                {{-- <img id="image" class="mt-3" style="width:25%;"/> --}}
                                <br>
                                <span class="show_document_file" style="color:green;"></span>
                            </label>
                        </div>
                    </div>


                    <div class="col-md-12">
                    {{Form::label('Temparture',__('Remarks'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                        {{ Form::textarea('description', null, ['class'=>'form-control','rows'=>'3','placeholder'=>__('Description')]) }}
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

@include('new_layouts.footer')

<script>
    $(document).ready(function() {
        $(".chosen-select").chosen();
    });
</script>
<style>
div#choices_multiple1_chosen {
    width: 100% !important;
}
</style>




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

   

      $(document).on('click', '#remove', function () {
          $('#customer-box').removeClass('d-none');
          $('#customer-box').addClass('d-block');
          $('#customer_detail').removeClass('d-block');
          $('#customer_detail').addClass('d-none');
      })



    document.getElementById('document').onchange = function () {
        $(".show_document_file").show();
        $(".show_document_file").html(this.files[0].name);
        // var src = URL.createObjectURL(this.files[0])
        // document.getElementById('image').src = src
    }

    $('.forms_doc').validate({
        rules: { inputimage: { required: true, accept: "png|jpeg|jpg|doc|pdf|exls", filesize: 100000  }},
    });

    jQuery.validator.addMethod("filesize", function(value, element, param) {
        var fileSize = element.files[0].size;
        var size = Math.round((fileSize / 1024));

        /* checking for less than or equals to 20MB file size */
        if (size <= 20*1024) {
            return true;
        } else {
            $(".show_document_file").hide();
            return false;
        }   
    }, "Invalid file size, please select a file less than or equal to 20mb size");

    jQuery.validator.addMethod("accept", function(value, element, param) {
        var extension = value.substr(value.lastIndexOf("."));
        var allowedExtensionsRegx = /(\.jpg|\.jpeg|\.png|\.doc|\.pdf|\.exls)$/i;
        var isAllowed = allowedExtensionsRegx.test(extension);

        if(isAllowed){
            return true;
        }else{
            $(".show_document_file").hide();
            return false;
        }
    }, "File must be png|jpeg|jpg|doc|pdf|exls");


  </script>
