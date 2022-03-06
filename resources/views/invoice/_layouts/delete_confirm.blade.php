<style>
    .modal-backdrop.fade.show {
        z-index: 0;
    }

    .modal-dialog {
        z-index: 1;
    }

    .modal.fade * {
        color: black;
    }
</style>
<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content" id="content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Delete Parmanently</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure about this ?</p>
                <div id="user_has_tasks">
                    Empty tasks
                </div>
                <div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  