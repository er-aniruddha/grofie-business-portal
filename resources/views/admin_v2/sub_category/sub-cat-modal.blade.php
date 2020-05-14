
<!-- Operation Modal Start -->
<form method="POST" id="sub_catForm" enctype="multipart/form-data">
  @csrf
<div class="modal fade" id="sub_catModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">         
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ></h4>
            </div>
            <div class="modal-body">             
              <div class="form-group">
                  <label>Sub-Category Name</label>
                  <input type="text" class="form-control" name="sub_cat_name" id="sub_cat_name" placeholder="Categroy Name">
                  <h6 class="text-danger">
                    <strong id="name-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label>Sub-Category Description</label>
                  <input type="text" class="form-control" name="sub_cat_description" id="sub_cat_description" placeholder="Enter text">
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
              <!-- This from group for show -->
              <div class="form-group _cat_name_show">
                <label>Category</label>
                <input type="text" class="form-control" name="category_name" id="category_name">
              </div>
              <div class="form-group _cat_name_input">
                <label>Category</label>
                <select class="form-control" name="category_id" id="category_id" style="width: 100%;" >
                  <option selected="selected" value="0">Select Category</option>
                  @if ( $categories)
                  @foreach( $categories as  $category)
                  @if($category->publication_status == 1)
                  <option value="{{ $category->category_id}}" >{{ $category->category_name}}</option>
                  @else
                  <option value="{{ $category->category_id}}" disabled="disabled">
                    {{ $category->category_name}}</option>
                  @endif  
                  @endforeach
                  @endif
                </select>  
                <h6 class="text-danger">
                  <strong id="category-error"></strong>
                </h6> 
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
                <input type="hidden" name="sub_cat_id" id="sub_cat_id" />
                <input type="hidden" name="image_update" id="image-update">    
                <input type="submit" name="add_sub_catBtn" id="add_sub_catBtn" class="btn btn-primary" value="Create"/>
                <input type="submit" name="edit_sub_catBtn" id="edit_sub_catBtn" class="btn btn-primary" value="Update"/>
                <button type="button" class="btn btn-default" name="closBtn" id="closBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</form>
<!-- Operation Modal End-->
