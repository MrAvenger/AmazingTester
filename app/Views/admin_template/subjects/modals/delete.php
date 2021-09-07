<div id="Modal_Subject_Delete" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление категории</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Вы точно хотите удалить выбранный предмет? Тесты связанные с данным предметом (у организации) также будут удалены!</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delete_id">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" onclick="delete_subjects()" class="btn btn-primary">Удалить</button>
            </div>
        </div>
    </div>
</div>