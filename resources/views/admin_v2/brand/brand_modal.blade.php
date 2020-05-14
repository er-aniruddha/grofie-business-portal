<!-- Operation Modal Start -->
<form method="POST" id="brandform" enctype="multipart/form-data">
  @csrf
<div class="modal fade" id="brandModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">         
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ></h4>
            </div>
            <div class="modal-body">             
              <div class="form-group">
                  <label for="brand_name">Brand Name</label>
                  <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Brand Name">
                  <h6 class="text-danger">
                    <strong id="name-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label for="brand_description">Brand Description</label>
                  <input type="text" class="form-control" name="brand_description" id="brand_description" placeholder="Enter text">
                  <h6 class="text-danger">
                    <strong id="description-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-6">
                    <label for="image">Image</label>                  
                  <input type="file" name="image" id="image">                              
                  <h6 class="text-danger">
                    <strong id="image-error"></strong>
                  </h6>                    
                  </div>
                  <div class="col-lg-6">                    
                      <img class="img-thumbnail" id="show-img"/>                                
                  </div>
                </div>
              </div>
              <div class="form-group status">
                <label>Status</label>
                <label class="radio-inline">
                    <input type="radio" name="publication_status" id="publication_status" value="1">Active
                </label>
                <label class="radio-inline">
                    <input type="radio" name="publication_status" id="publication_status" value="2">Deactive
                </label>
                <h6 class="text-danger">
                  <strong id="status-error"></strong>
                </h6>               
              </div>
            
            </div>
            <div class="modal-footer">
                <input type="hidden" name="brand_id" id="brand_id" />
                <input type="hidden" name="image_update" id="image-update">    
                <input type="submit" name="add_brandBtn" id="add_brandBtn" class="btn btn-primary" value="Create"/>
                <input type="submit" name="edit_brandBtn" id="edit_brandBtn" class="btn btn-primary" value="Update"/>
                <button type="button" class="btn btn-default" name="closBtn" id="closBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</form>
<!-- Operation Modal End-->
