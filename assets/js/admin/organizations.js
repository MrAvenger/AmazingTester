$(document).ready(function () {
  $("#table_organizations").dataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json",
    },
    columns: [{ searchable: true }, null,null],
    //AllowPaging="false"
  });
  storage();
});

function storage() {
  var html = [];
  var t = $("#table_organizations").DataTable();
  $.ajax({
    url: "../organizations/storage_organizations" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      var arr = data;
      t.clear().draw();
      arr.forEach(function (item, i, arr) {
        t.row.add(item).draw(false);
      });
    },
    dataType: "json",
  });
}

function add_open() {
  $("#result_form").html("");
  document.getElementById("form_edit_organization").reset();
  $("#edit_tittle").html(
    '<h5 class="modal-title">Создание организации</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
  );
  $("#buttons_edit_organization").html(
    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button><button type="button" onclick="add_organization()" class="btn btn-primary">Добавить</button>'
  );
}

function add_organization() {
  var html = '<div class="alert alert-danger" role="alert">';
  $.ajax({
    url: "../organizations/add_organization" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: {name:document.getElementById("name").value},
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data == true) {
        $("#Modal_Organization_Edit").modal("hide");
        storage();
        $.toast({
          heading: "Успех",
          text: "Успешное добавление новой организации.",
          showHideTransition: "slide",
          icon: "success",
          position: "top-left",
        });
      } else {
        html += data + "</div>";
        $("#result_form").html(html);
      }
    },
    error: function (response) {
      // Данные не отправлены
      $.toast({
        heading: "Ошибка",
        text: "Произошла ошибка при добавлении",
        showHideTransition: "fade",
        icon: "error",
        position: "top-left",
      });
    },
    dataType: "json",
  });
}

function edit_open(id) {
  $("#result_form").html("");
  document.getElementById("form_edit_organization").reset();
  $.ajax({
    url: "../organizations/get_organization" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: { id: id },
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      //$('#Modal_User_Delete').modal('hide');
      if (data != null) {
        document.getElementById("name").value = data.name;
        $("#edit_tittle").html(
          '<h5 class="modal-title">Изменение данных о организации</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
        );
        $("#buttons_edit_organization").html(
          '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button><button type="button" onclick="edit_organization(' +
            data.id +
            ')" class="btn btn-primary">Изменить</button>'
        );
      }
    },
    dataType: "json",
  });
}

function edit_organization(id) {
  var html = '<div class="alert alert-danger" role="alert">';
  $.ajax({
    url: "../organizations/edit_organization/" + id /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: {name:document.getElementById("name").value},
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data == true) {
        $("#Modal_Organization_Edit").modal("hide");
        storage();
        $.toast({
          heading: "Успех",
          text: "Успешное изменение организации.",
          showHideTransition: "slide",
          icon: "success",
          position: "top-left",
        });
      } else {
        html += data + "</div>";
        $("#result_form").html(html);
      }
    },
    error: function (response) {
      // Данные не отправлены
      $.toast({
        heading: "Ошибка",
        text: "Произошла ошибка при изменении данных",
        showHideTransition: "fade",
        icon: "error",
        position: "top-left",
      });
    },
    dataType: "json",
  });
}

function delete_open(id) {
  document.getElementById("delete_id").value = id;
}

function delete_organizations() {
  $.ajax({
    url: "../organizations/delete_organizations" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: { id: document.getElementById("delete_id").value },
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      $("#Modal_Organization_Delete").modal("hide");
      storage();
      $.toast({
        heading: "Успех",
        text: "Успешное удаление организации.",
        showHideTransition: "slide",
        icon: "success",
        position: "top-left",
      });
    },
  });
}
