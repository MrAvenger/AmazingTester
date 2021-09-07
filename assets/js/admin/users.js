$(document).ready(function () {
  $("#table_users").dataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json",
    },
    columns: [
      { searchable: true },
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
    ],
    //AllowPaging="false"
  });
  storage();
  getorgs();
});
function storage() {
  var html = [];
  var t = $("#table_users").DataTable();
  $.ajax({
    url: "storage_users" /* Куда пойдет запрос */,
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
  document.getElementById("form_edit_user").reset();
  $("#class_group_div").html("");
  $("#edit_tittle").html(
    '<h5 class="modal-title">Создание пользователя</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
  );
  $("#buttons_edit_user").html(
    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button><button type="button" onclick="add_user()" class="btn btn-primary">Добавить</button>'
  );
}

function add_user() {
  var html = '<div class="alert alert-danger" role="alert">';
  $.ajax({
    url: "add_user" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: $("#form_edit_user").serialize(),
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data == true) {
        $("#Modal_User_Edit").modal("hide");
        storage();
        getorgs();
        $.toast({
          heading: "Успех",
          text: "Успешное создание нового пользователя.",
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
        text: "Произошла ошибка при создании пользователя",
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
  document.getElementById("form_edit_user").reset();
  $.ajax({
    url: "get_user" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: { id: id },
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      //$('#Modal_User_Delete').modal('hide');
      if (data != null) {
        document.getElementById("first_name").value = data.first_name;
        document.getElementById("last_name").value = data.last_name;
        document.getElementById("middle_name").value = data.middle_name;
        document.getElementById("email").value = data.email;
        document.getElementById("role").value = data.role;
        fields_for_role();
        document.getElementById("sex").value = data.gender;
        document.getElementById("org").value = data.organization_id;
        getgroup_class(data.group_or_class_id);
        $("#edit_tittle").html(
          '<h5 class="modal-title">Изменение данных пользователя</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
        );
        $("#buttons_edit_user").html(
          '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button><button type="button" onclick="edit_user(' +
            data.id +
            ')" class="btn btn-primary">Изменить</button>'
        );
      }
    },
    dataType: "json",
  });
}

function edit_user(id) {
  var html = '<div class="alert alert-danger" role="alert">';
  $.ajax({
    url: "edit_user/" + id /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: $("#form_edit_user").serialize(),
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data == true) {
        $("#Modal_User_Edit").modal("hide");
        storage();
        $.toast({
          heading: "Успех",
          text: "Успешное изменение данных пользователя.",
          showHideTransition: "slide",
          icon: "success",
          position: "top-left",
        });
      } else if (data == false) {
        $.toast({
          heading: "Ошибка",
          text: "Вы не изменить себе роль!",
          showHideTransition: "fade",
          icon: "error",
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
        text: "Произошла ошибка при изменении данных пользователя",
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

function delete_user() {
  $.ajax({
    url: "delete_users" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: { id: document.getElementById("delete_id").value },
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data == true) {
        $("#Modal_User_Delete").modal("hide");
        storage();
        $.toast({
          heading: "Успех",
          text: "Успешное удаление пользователя.",
          showHideTransition: "slide",
          icon: "success",
          position: "top-left",
        });
      } else {
        $("#Modal_User_Delete").modal("hide");
        $.toast({
          heading: "Ошибка",
          text: "Вы не можете удалить свой аккаунт, являясь администратором!",
          showHideTransition: "fade",
          icon: "error",
          position: "top-left",
        });
      }
    },
    dataType: "json",
  });
}

function activate_user(id) {
  $.ajax({
    url: "activate_user/" + id /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data == true) {
        storage();
        $.toast({
          heading: "Успех",
          text: "Успешное изменение статуса пользователя.",
          showHideTransition: "slide",
          icon: "success",
          position: "top-left",
        });
      } else if (data == false) {
        $.toast({
          heading: "Ошибка",
          text: "Вы не можете изменить статус своего аккаунта!",
          showHideTransition: "fade",
          icon: "error",
          position: "top-left",
        });
      }
    },
    error: function (response) {
      // Данные не отправлены
      $.toast({
        heading: "Ошибка",
        text: "Ошибка изменения статуса!",
        showHideTransition: "fade",
        icon: "error",
        position: "top-left",
      });
    },
    dataType: "json",
  });
}

function getorgs() {
  selectOrg = document.getElementById("org");
  document.getElementById("org").innerHTML = "";
  var optnew = document.createElement("option");
  optnew.innerHTML = "Не указано";
  optnew.value = -1;
  //optnew.value=-1;
  selectOrg.appendChild(optnew);
  $.ajax({
    url: "../users/getorgs" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data != null) {
        data.forEach(function (item, i, data) {
          var opt = document.createElement("option");
          opt.value = item.id;
          opt.innerHTML = item.name;
          selectOrg.appendChild(opt);
        });
      }
    },
    error: function (response) {
      // Данные не отправлены
      alert("Ошибка получения учебных организаций");
    },
    dataType: "json",
  });
}

function getgroup_class(class_group) {
  org = document.getElementById("org");
  let edit_class_group = class_group;
  $("#class_group_div").html(
    '<div class="col-sm-6"><label for="group_class" class="form-label">Укажите группу/класс:</label><div class="input-group mb-3"><span class="input-group-text" id="group-class-addon"><i class="fas fa-user-friends"></i></span><select id="group_class" name="group_class" class="form-select" aria-label="Default select example" aria-describedby="group-class-addon"><option selected value="-1">Не указано</option></select></div></div>'
  );
  $.ajax({
    url: "../users/get_group_class" /* Куда пойдет запрос */,
    method: "post",
    data: { org_id: org.value } /* Метод передачи (post или get) */,
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data != null) {
        group_class_select = document.getElementById("group_class");
        data.forEach(function (item, i, data) {
          var opt = document.createElement("option");
          opt.value = item.id;
          opt.innerHTML = item.name;
          group_class.appendChild(opt);
        });
        if (class_group != null) {
          document.getElementById("group_class").value = edit_class_group;
        }
      }
    },
    error: function (response) {
      // Данные не отправлены
      alert("Ошибка получения учебных групп/классов");
    },
    dataType: "json",
  });
}

function fields_for_role() {
  role = document.getElementById("role");
  if (role.value == "Teacher") {
    $("#org_lable").html("Выберите учебное заведение");
    $("#class_group_div").html("");
  } else {
    $("#org_lable").html("Укажите место обучения");
  }
}
