<div id="Modal_Group_Classes_Edit" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header" id="edit_tittle">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_group_classes" method="POST">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="name" class="form-label">Название:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="name-addon">@</span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Название"
                                    aria-label="Название" aria-describedby="name-addon" require>
                            </div>
                        </div>
                        <div id="org_select_name" class="col-sm-6">
                            <label id="org_lable" for="org" class="form-label">Выберите организацию</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="org-addon"><i class="far fa-building"></i></span>
                                <select id="org" name="org" class="form-select"
                                aria-label="Default select example" aria-describedby="org-addon"></select>
                            </div>
                        </div>
                    </div>
                    <div id="result_form" class="col-12"></div>
                </form>
                <div class="modal-footer" id="buttons_edit_group_classes">
                </div>
            </div>
        </div>
    </div>
</div>