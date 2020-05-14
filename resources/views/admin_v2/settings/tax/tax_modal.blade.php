<!-- Operation Modal Start -->
<form method="POST" id="taxForm">
  @csrf
<div class="modal fade" id="taxModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">         
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ></h4>
            </div>
            <div class="modal-body">    
              <div class="form-group select-tax">
                  <label>Selects Tax</label>
                  <select class="form-control" name="tax_id" id="tax_id" style="width: 100%;" >
                      <option selected="selected" value="0">Select Tax</option>
                      <option value="1">CGST</option>
                      <option value="2">SGST</option>
                      <option value="3">IGST</option>
                      <option value="4">UGST</option>                  
                  </select>
                  <h6 class="text-danger">
                    <strong id="tax-select-error"></strong>
                  </h6>
              </div>         
              <div class="form-group">
                  <label>Tax Code</label>
                  <input type="text" class="form-control" name="tax_name" id="tax_name" placeholder="Tax Name">
                  <h6 class="text-danger">
                    <strong id="name-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label>Tax Rate</label>
                  <input type="text" class="form-control" name="tax_rate" id="tax_rate" placeholder="Tax Code">
                  <h6 class="text-danger">
                    <strong id="rate-error"></strong>
                  </h6>
              </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" name="tax_type_id" id="tax_type_id">
                <input type="submit" name="add_taxBtn" id="add_taxBtn" class="btn btn-primary" value="Create"/>
                <input type="submit" name="edit_taxBtn" id="edit_taxBtn" class="btn btn-primary" value="Update"/>
                <button type="button" class="btn btn-default" name="closBtn" id="closBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</form>
<!-- Operation Modal End-->
