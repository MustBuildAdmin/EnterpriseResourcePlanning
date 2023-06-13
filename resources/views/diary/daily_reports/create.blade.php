@include('new_layouts.header')
@include('construction_project.side-menu')



<h2>Contractor's daily construction report</h2>

<div class="maindailyreport">
    <div class="row">
         




    <div class="row row-cards">
                <div class="col-12">
                  <form class="card">
                    <div class="card-body">
                     
                      <div class="row row-cards">
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Daily Report No</label>
                            <label class="form-label form-control disabledmode">Daily Report No</label>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Contractor Name</label>
                            <input type="text" class="form-control" placeholder="Username" value="">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" placeholder="Email">
                          </div>
                        </div>

           

                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            <label class="form-label form-control disabledmode">construction report</label>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                          <div class="mb-3">
                            <label class="form-label">weather</label>
                            <div class="dropdownrpt">
                                <select name="reporting_to[]" id='choices-multiple1' class='chosen-select' required multiple>
                                        <option value="" disabled>Select your option</option>
                                        <option value="">Clear</option>
                                        <option value="">Dusty</option>
                                        <option value="">Muddy</option>
                                        <option value="">Windy</option>
                                        <option value="">Cool</option>
                                        <option value="">Fog</option>
                                        <option value="">Warm</option>
                                        <option value="">Rain</option>
                                        <option value="">Cold</option>
                                        <option value="">Hot</option>
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Site conditions</label>
                            <div class="dropdownrpt">
                                <select name="reporting_to[]" id='choices-multiple1' class='chosen-select' required multiple>
                                        <option value="" disabled>Select your option</option>
                                        <option value="">Clear</option>
                                        <option value="">Dusty</option>
                                        <option value="">Muddy</option>
                                        <option value="">Windy</option>
                                        <option value="">Cool</option>
                                        <option value="">Fog</option>
                                        <option value="">Warm</option>
                                        <option value="">Rain</option>
                                        <option value="">Cold</option>
                                        <option value="">Hot</option>
                                </select>
                            </div>
                          </div>
                        </div>



                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Day</label>
                            <label class="form-label form-control disabledmode">Monday</label>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Temparture (Maximum)</label>
                            <input type="text" class="form-control" placeholder="Maximum" value="">
                          </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Minimum</label>
                            <input type="email" class="form-control" placeholder="Minimum">
                          </div>
                        </div>

                        <div class="col-sm-6 col-md-2">
                          <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                                    <select class="form-control addbutton" required>
                                            <option value="" disabled selected>Select your option</option>
                                            <option value="">Fahrenheit</option>
                                            <option value="">Celsius</option>
                                    </select>
                          </div>
                        </div>

                        <div class="card-footer text-end">
                         &nbsp;
                        </div>

                    <div class="col-md-12 l-section">

                        <h2>Contractors Personnel</h2>
                        <br/>


                        


                        <table class="table tableadd form">
                           
                        <thead>
                        <tr>
                            <tr>
                            <th>Posistion</th>
                            <th>No Of Person per Posistion</th>
                            <th></th>
                            <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr id="addRow">
                            <td class="col-xs-3">
                                <input class="form-control addMain" type="text" placeholder="Enter Posistion Name" />
                            </td>
                            
                            <td class="col-xs-3">
                                <input class="form-control addPrefer" type="text" placeholder="Enter NO OF PERSON PER POSISTION" />
                            </td>
                            <td class="col-xs-5">
                            <select class="form-control addbutton addCommon" required>
                                            <option value="" disabled selected>Select your option</option>
                                            <option value="">Direct Manpower</option>
                                            <option value="">InDirect Manpower</option>
                                    </select>
                            </td>
                            <td class="col-xs-1 text-center">
                                <!-- <span class="c-link"><i class="bttoncreate fa fa-edit  js-toggleForm"></i></span> -->

                                <span class="addBtn bttoncreate">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </td>
                            </tr>

                        </tbody>
                        </table>
                        
                        </div>






                    <div class="card-footer text-end">
                      &nbsp;
                    </div>
                  </form>
                </div>


                        <div class="row totalcount">
                             <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <label class="form-label">Total Indirect Manpower:  45</label>
                                    </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <label class="form-label">Total Direct Manpower:  45</label>
                                    </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <label class="form-label">Total Contractor's Manpower: 22</label>
                                    </div>
                                </div>
                            </div>
                            

                            <br/>


                <div class="col-md-12 l-section">

                        <h2>Sub Contractors</h2>
                        <br/>


                        <table class="table tableadd form">
                        <thead>
                            <tr>
                            <th>Posistion Name</th>
                            <th>No Of Person per Posistion</th>
                            <th></th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="addRow2">
                            <td class="col-xs-3">
                                <input class="form-control addMain2" type="text" placeholder="Enter Posistion Name" />
                            </td>
                            
                            <td class="col-xs-3">
                                <input class="form-control addPrefer2" type="text" placeholder="Enter NO OF PERSON PER POSISTION" />
                            </td>
                            <td class="col-xs-5">
                            <select class="form-control addbutton addCommon2" required>
                                            <option value="" disabled selected>Select your option</option>
                                            <option value="">Direct</option>
                                            <option value="">InDirect</option>
                                    </select>
                            </td>
                            <td class="col-xs-1 text-center">
                                <span class="addBtn2 bttoncreate">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </td>
                            </tr>

                        </tbody>
                        </table>

                        <div class="card-footer text-end">
                          &nbsp;
                        </div>
                        
                        </div>


                        <div class="row totalcount">
                             <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <label class="form-label">Total Indirect Manpower:  45</label>
                                    </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <label class="form-label">Total Direct Manpower:  45</label>
                                    </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <label class="form-label">Total Contractor's Manpower: 22</label>
                                    </div>
                                </div>
                            </div>
                            
                            

                            <br/>
 

                        <div class="col-md-12 l-section">

                            <h2>Major Equipment on Project</h2>
                            <br/>


                            <table class="table tableadd form">
                            <thead>
                                <tr>
                                <th>Equipment Name</th>
                                <th>No Of Equipment</th>
                                <th></th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="addRow3">
                                <td class="col-xs-3">
                                    <input class="form-control addMain3" type="text" placeholder="Enter Equipment Name" />
                                </td>
                                
                                <td class="col-xs-3">
                                    <input class="form-control addPrefer3" type="text" placeholder="Enter NO OF PERSON PER POSISTION" />
                                </td>
                                <td class="col-xs-5">
                                <select class="form-control addbutton addCommon3" required>
                                                <option value="" disabled selected>Select your option</option>
                                                <option value="">Direct</option>
                                                <option value="">InDirect</option>
                                        </select>
                                </td>
                                <td class="col-xs-1 text-center">
                                    <span class="addBtn3 bttoncreate">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </td>
                                </tr>

                            </tbody>
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
                                {{Form::label('Remarks',__('Remarks'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                <textarea class="form-control" rows="5" style="height: 200px;"></textarea>
                            </div>

                            <div class="col-md-12">
                                {{Form::label('Prepared By',__('Prepared By'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                <input class="form-control" type="textbox" />
                            </div>

                            <div class="col-md-12">
                                {{Form::label('Title',__('Title'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                <input class="form-control" type="textbox" />
                            </div>

                            <br/>

                            <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                            </div>

                </div>


</div>




                <hr/>




              </div>



    </div>


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


                                    
  function formatRows(main, prefer, common) {
    return '<tr><td class="col-md-3"><input placeholder="Enter POSISTION Name" type="text" value="' +main+ '" class="form-control editable" disabled/></td>' +
            '<td class="col-md-3"><input placeholder="Enter NO OF PERSON PER POSISTION" type="text" value="' +prefer+ '" class="form-control editable" disabled/></td>' +
            '<td class="col-md-3"><select placeholder="Please select your option" type="text" value="' +common+ '" class="form-control editable"  disabled/> <option value="" disabled="" selected="">Select your option</option> <option value="">Direct</option><option value="">InDirect</option> </select></td>' +
            '<td class="col-md-1 text-center"><a class="bttoncreate c-link js-toggleForm" onClick="formedit(this)"><img class="imageedit" src="assets/images/icons/edit.png"/> </a>' +
            '<a class="bttoncreate" href="#" onClick="deleteRow(this)"> <i class="ti ti-trash text-white" aria-hidden="true" /></a></td></tr>';
    };


    

    function deleteRow(trash) {
    $(trash).closest('tr').remove();
    };

    function addRow() {
    var main = $('.addMain').val();
    var preferred = $('.addPrefer').val();
    var common = $('.addCommon').val();
    $(formatRows(main,preferred,common)).insertAfter('#addRow');
    $(input).val('');  
    }

    $('.addBtn').click(function()  {
    addRow();
    });


    function addRow2() {
    var main = $('.addMain2').val();
    var preferred = $('.addPrefer2').val();
    var common = $('.addCommon2').val();
    $(formatRows(main,preferred,common)).insertAfter('#addRow2');
    $(input).val('');  
    }

    $('.addBtn2').click(function()  {
    addRow2();
    });



    function addRow3() {
    var main = $('.addMain3').val();
    var preferred = $('.addPrefer3').val();
    var common = $('.addCommon3').val();
    $(formatRows(main,preferred,common)).insertAfter('#addRow3');
    $(input).val('');  
    }

    $('.addBtn3').click(function()  {
    addRow3();
    });


  



    var form_ele = '.form';

// make eveything disabled
var disableFormEdit = function(selector){	
  $(selector).removeClass('form--enabled').addClass('form--disabled');
	$(selector + ' input, ' + selector + ' select, ' + selector + ' button').prop('disabled', true);
}


// make eveything enabled
var enableFormEdit = function(selector){	
	$(selector + ' input, ' + selector + ' select, ' + selector + ' button ').prop('disabled', false);
  $(selector).removeClass('form--disabled').addClass('form--enabled');
}


disableFormEdit(form_ele);


function formedit () {

  //  alert("hi");

    $('.form').removeClass('form--disabled').addClass('form--enabled');
    $('.form' + ' input, ' + selector + ' select, ' + selector + ' button ').prop('disabled', false);

}


$('.js-toggleForm').click(function(){
   // get the status of form
  var form_status = $(form_ele).hasClass('form--disabled') ? 'disabled' : 'enabled';
  



  // check if disabled or enabled
  switch (form_status){
    case 'disabled':
      enableFormEdit(form_ele);
      $(this).text('undo')
      break;
    case 'enabled':
      disableFormEdit(form_ele);
      $(this).text('click to edit')
      break;
  }
});


  </script>
