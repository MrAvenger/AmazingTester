<div id="Modal_Subject_Edit" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header" id="edit_tittle">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_subject" method="POST">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="name" class="form-label">Название:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="name-addon">@</span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Название"
                                    aria-label="Название" aria-describedby="name-addon" require>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" id="old_image" name="old_image">
                            <label for="image" class="form-label">Изображение:</label>
                            <div class="input-group mb-6">
                                <div class="form-file">
                                    <input type="file" class="form-file-input" name="file" onchange="showFile(this)"
                                        id="file">
                                    <label class="form-file-label" for="customFile">
                                        <span id="span_name_file" class="form-file-text">Выберите файл...</span>
                                        <span class="form-file-button">Выбрать</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="edit_user_div" class="row mb-3">
                        <div id="org_select_name" class="col-sm-6">
                            <label id="org_lable" for="org" class="form-label">Выберите организацию</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="org-addon"><i class="far fa-building"></i></span>
                                <select onchange="getgroup_class()" id="org" name="org" class="form-select"
                                    aria-label="Default select example" aria-describedby="org-addon"></select>
                            </div>
                        </div>
                        <div id="class_group_div" class="col-sm-6">

                        </div>
                    </div>
                    <div id="result_form" class="col-12"></div>
                </form>
                <div class="modal-footer" id="buttons_edit_subject">
                </div>
            </div>
        </div>
    </div>
</div>