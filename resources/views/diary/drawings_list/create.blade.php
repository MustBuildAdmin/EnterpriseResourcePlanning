@include('new_layouts.header') @include('construction_project.side-menu') <h2>CONTRACTOR AS-BUILT DRAWINGS LIST</h2>
<div class="maindailyreport Drawingsreport">
  <div class="row">
    <div class="row row-cards">
      <div class="col-12">
        <form class="card">
          <div class="card-body">
            <div class="row row-cards">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Issued by</label>
                  <input type="Text" class="form-control" placeholder="Issued by">
                  <!-- <select name="reporting_to[]" id='choices-multiple1' class='chosen-select' required>
                    <option value="" disabled>Select your option</option>
                    <option value="">Maincontractor</option>
                    <option value="">Structural Co Pte Ltd</option>
                  </select> -->
                </div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">Drawing SI No</label>
                  <input type="Text" class="form-control" placeholder="Drawing SI No">
                </div>
              </div>


              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">Drawing Reference</label>
                  <input type="Text" class="form-control" placeholder="Drawing Reference">
                </div>
              </div>


              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">Drawing No</label>
                  <label class="form-label form-control disabledmode">A/xx-001</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">Drawing Views</label>
                  <input type="Text" class="form-control" placeholder="Drawing Views">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Drawing Description</label>
                  <input type="Text" class="form-control" placeholder="Drawing Description">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Issue Date</label>
                  <input type="Date" class="form-control" placeholder="Issue Date">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Scale</label>
                  <input type="Text" class="form-control" placeholder="Scale">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Size</label>
                  <input type="Text" class="form-control" placeholder="Size">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Revision</label>
                  <select  class='form-control' required>
                    <option value="" disabled selected="selected">Select your option</option>
                    <option value="">1</option>
                    <option value="">2</option>
                    <option value="">3</option>
                    <option value="">4</option>
                    <option value="">5</option>
                    <option value="">6</option>
                    <option value="">7</option>
                    <option value="">8</option>
                    <option value="">9</option>
                  </select>
                </div>
              </div>
              <div class="card-footer text-end"> &nbsp; </div>
        </form>
      </div>
      <!-- <div class="col-md-4 form-group"><label name="document" for="" class="form-label">{{__('Document')}} <span style='color:red;'>*</span></label><div class="choose-file "><label for="document" class="form-label"><input name="inputimage" type="file" class="form-control" name="document" id="document" data-filename="document_create" required>.
                                    {{-- <img id="image" class="mt-3" style="width:25%;"/> --}}
                                    <br><span class="show_document_file" style="color:green;"></span></label></div></div><div class="col-md-4 form-group"><label name="document" for="" class="form-label">{{__('Document')}} <span style='color:red;'>*</span></label><div class="choose-file "><label for="document" class="form-label"><input name="inputimage" type="file" class="form-control" name="document" id="document" data-filename="document_create" required>.
                                    {{-- <img id="image" class="mt-3" style="width:25%;"/> --}}
                                    <br><span class="show_document_file" style="color:green;"></span></label></div></div> -->
      <!-- <div class="col-md-12">
                                {{Form::label('Remarks',__('Remarks'),array('class'=>'form-label')) }}<span style='color:red;'>*</span><textarea class="form-control" rows="5" style="height: 200px;"></textarea></div> -->
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<hr />
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
<script src="{{asset('js/jquery-ui.min.js')}}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="{{asset('js/jquery.repeater.min.js')}}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
