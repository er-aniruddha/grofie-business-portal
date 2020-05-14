<!-- Confirm Modal -->
<form method="POST" id="confirmform">
  @csrf
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title"></h2>
            </div>
            <div class="modal-body">
                Are you sure you want to remove this data?
                <h6 class="text-danger">
                    <strong id="del-error"></strong>
                </h6>
            </div>
            
            <input type="hidden" name="id" id="id">
            <div class="modal-footer">
              <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger"></button>
              <button type="button" class="btn btn-default" name="closBtn" id="closBtn" data-dismiss="modal">NO</button>
            </div>
        </div>
    </div>
</div>
</form>
<!-- Confirm modal -->