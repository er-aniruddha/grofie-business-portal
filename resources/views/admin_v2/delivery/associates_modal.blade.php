<!-- Operation Modal Start -->
<form method="POST" id="associateForm" enctype="multipart/form-data">
  @csrf
<div class="modal fade" id="associateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">         
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ></h4>
            </div>
            <div class="modal-body">             
              <div class="form-group">
                  <label for="f_name">First Name</label>
                  <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Brand Name">
                  <h6 class="text-danger">
                    <strong id="fname-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label type="text" for="s_name">Surname</label>
                  <input class="form-control" name="s_name" id="s_name" placeholder="Enter Surname">
                  <h6 class="text-danger">
                    <strong id="sname-error"></strong>
                  </h6>
              </div> 
              <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" maxlength="10" minlength="10" name="phone" id="phone" placeholder="Enter Phone Number">
                  <h6 class="text-danger">
                    <strong id="phone-error"></strong>
                  </h6>
              </div>  
              <div class="form-group">
                  <label for="email">Email ID</label>
                  <input type="email"  class="form-control" name="email" id="email" placeholder="Enter Email">
                  <h6 class="text-danger">
                    <strong id="email-error"></strong>
                  </h6>
              </div>  
              <div class="form-group">
                <div class="verify">
                  <label>Verification</label>
                  <button class="btn btn-success btn-circle" id="verify-active"><i class="fa fa-check"></i></button>  
                  <button class="btn btn-danger btn-circle" id="verify-deactive"><i class="fa fa-times"></i></button>
                </div>                
              </div>
                   
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="del_asso_id" />  
                <input type="submit" name="add_del_asso_btn" id="add_del_asso_btn" class="btn btn-primary" value="Create"/>
                <input type="submit" name="edit_del_asso_btn" id="edit_del_asso_btn" class="btn btn-primary" value="Update"/>
                <button type="button" class="btn btn-default" name="closBtn" id="closBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</form>
<!-- Operation Modal End-->
