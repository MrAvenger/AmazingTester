<div id="Modal_Organization_Edit" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header" id="edit_tittle">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_organization" method="POST">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="name" class="form-label">Название:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="name-addon">@</span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Название"
                                    aria-label="Название" aria-describedby="name-addon" require>
                            </div>
                        </div>
                    </div>
                    <div id="result_form" class="col-12"></div>
                </form>
                <div class="modal-footer" id="buttons_edit_organization">
                </div>
            </div>
        </div>
    </div>
</div>