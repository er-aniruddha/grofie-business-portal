<!-- Operation Modal Start -->
<!-- <form method="POST" action="{{route('store.create')}}"> -->
<form method="POST" id="storeForm">
  @csrf
<div class="modal fade" id="storeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">         
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ></h4>
            </div>
            <div class="modal-body">   
                     
              <div class="form-group">
                  <label>Store Name</label>
                  <input type="text" class="form-control" name="store_name" id="store_name" placeholder="Store Name">
                  <h6 class="text-danger">
                    <strong id="name-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label>City</label>
                  <input type="text" class="form-control" name="city" id="city" placeholder="City Name">
                  <h6 class="text-danger">
                    <strong id="city-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label>address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                  <h6 class="text-danger">
                    <strong id="address-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label>Lat</label>
                  <input type="text" class="form-control" name="lat" id="lat" placeholder="Lat">
                  <h6 class="text-danger">
                    <strong id="lat-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label>Long</label>
                  <input type="text" class="form-control" name="long" id="long" placeholder="Long">
                  <h6 class="text-danger">
                    <strong id="long-error"></strong>
                  </h6>
              </div>             
            </div>
            <div class="modal-footer">
               <input type="hidden" name="tax_type_id" id="tax_type_id">
                <input type="submit" name="add_storeBtn" id="add_storeBtn" class="btn btn-primary" value="Create"/>
                <input type="submit" name="edit_storeBtn" id="edit_storeBtn" class="btn btn-primary" value="Update"/>
                <button type="button" class="btn btn-default" name="closBtn" id="closBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</form>
<!-- Operation Modal End-->
