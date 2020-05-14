<!-- Operation Modal Start -->
<form method="POST" id="unitForm">
  @csrf
<div class="modal fade" id="unitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">         
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ></h4>
            </div>
            <div class="modal-body">    
              <div class="form-group">
                  <label>Unit Name</label>
                  <input type="text" class="form-control" name="unit_name_lm" id="unit_name_lm" placeholder="Unit Name">
                  <h6 class="text-danger">
                    <strong id="name-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label>Unit Code</label>
                  <input type="text" class="form-control" name="unit_name_sm" id="unit_name_sm" placeholder="Unit Code">
                  <h6 class="text-danger">
                    <strong id="code-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label>Unites</label>
                  <input type="number" class="form-control" name="unit_unit" id="unit_unit" placeholder="Unite">
                  <h6 class="text-danger">
                    <strong id="unit-error"></strong>
                  </h6>
              </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" name="unit_id" id="unit_id">
                <input type="submit" name="add_unitBtn" id="add_unitBtn" class="btn btn-primary" value="Create"/>
                <input type="submit" name="edit_unitBtn" id="edit_unitBtn" class="btn btn-primary" value="Update"/>
                <button type="button" class="btn btn-default" name="closBtn" id="closBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</form>
<!-- Operation Modal End-->
