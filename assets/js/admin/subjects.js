$(document).ready(function () {
  $("#table_subjects").dataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json",
    },
    columns: [{ searchable: true }, null, null, null, null, null, null, null, null],
    //AllowPaging="false"
  });
  storage();
  getorgs();
});
function storage() {
  var html = [];
  var t = $("#table_subjects").DataTable();
  $.ajax({
    url: "../subjects/storage_subjects" /* Куда пойдет запрос */,
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
  showFile();
  $("#result_form").html("");
  document.getElementById("form_edit_subject").reset();
  $("#class_group_div").html("");
  $("#edit_tittle").html(
    '<h5 class="modal-title">Создание уч.предмета</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
  );
  $("#buttons_edit_subject").html(
    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button><button type="button" onclick="add_subject()" class="btn btn-primary">Добавить</button>'
  );
}

function add_subject() {
  var html = '<div class="alert alert-danger" role="alert">';
  var fd = new FormData();
  var files = $("#file")[0].files;
  var name = $("#name").val();
  var selectGroup = document.getElementById("group_class");
  if (files.length > 0) {
    fd.append("file", files[0]);
    fd.append("name", name);
    if (selectGroup != null) {
      fd.append("group_or_class_id", selectGroup.value);
    }
    $.ajax({
      url: "../subjects/add_subject" /* Куда пойдет запрос */,
      method: "post" /* Метод передачи (post или get) */,
      data: fd,
      contentType: false,
      processData: false,
      success: function (data) {
        /* функция которая будет выполнена после успешного запроса.  */
        if (data == true) {
          $("#Modal_Subject_Edit").modal("hide");
          storage();
          $.toast({
            heading: "Успех",
            text: "Успешное добавление нового предмета.",
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
  } else {
    alert("Не выбран файл");
  }
}

function edit_open(id) {
  showFile();
  $("#result_form").html("");
  document.getElementById("form_edit_subject").reset();
  $.ajax({
    url: "../subjects/get_subject" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: { id: id },
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      //$('#Modal_User_Delete').modal('hide');
      if (data != null) {
        document.getElementById("form_edit_subject").reset();
        document.getElementById("name").value = data.name;
        document.getElementById("org").value = data.organization_id;
        getgroup_class(data.group_or_class_id);
        $("#edit_tittle").html(
          '<h5 class="modal-title">Изменение данных о уч.предмете</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
        );
        $("#buttons_edit_subject").html(
          '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button><button type="button" onclick="edit_subject(' +
            data.id +
            ')" class="btn btn-primary">Изменить</button>'
        );
      }
    },
    dataType: "json",
  });
}

function edit_subject(id) {
  var html = '<div class="alert alert-danger" role="alert">';
  var fd = new FormData();
  var files = $("#file")[0].files;
  var name = $("#name").val();
  var selectGroup = document.getElementById("group_class");
  if (files.length > 0) {
    fd.append("file", files[0]);
    fd.append("name", name);
    if (selectGroup != null) {
      fd.append("group_or_class_id", selectGroup.value);
    }
  } else {
    fd.append("file", null);
    fd.append("name", name);
    if (selectGroup != null) {
      fd.append("group_or_class_id", selectGroup.value);
    }
  }
  $.ajax({
    url: "../subjects/edit_subject/" + id /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: fd,
    contentType: false,
    processData: false,
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      if (data == true) {
        $("#Modal_Subject_Edit").modal("hide");
        storage();
        $.toast({
          heading: "Успех",
          text: "Успешное изменение предмета.",
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

function delete_subjects() {
  $.ajax({
    url: "../subjects/delete_subjects" /* Куда пойдет запрос */,
    method: "post" /* Метод передачи (post или get) */,
    data: { id: document.getElementById("delete_id").value },
    success: function (data) {
      /* функция которая будет выполнена после успешного запроса.  */
      $("#Modal_Subject_Delete").modal("hide");
      storage();
      $.toast({
        heading: "Успех",
        text: "Успешное удаление предмета.",
        showHideTransition: "slide",
        icon: "success",
        position: "top-left",
      });
    },
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
      $.toast({
        heading: "Ошибка",
        text: "Ошибка получения учебных организаций",
        showHideTransition: "fade",
        icon: "error",
        position: "top-left",
      });
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
      $.toast({
        heading: "Ошибка",
        text: "Ошибка получения учебных групп/классов",
        showHideTransition: "fade",
        icon: "error",
        position: "top-left",
      });
    },
    dataType: "json",
  });
}

function showFile(input) {
  if (input != null) {
    let file = input.files[0];
    $("#span_name_file").html(file.name);
  } else {
    $("#span_name_file").html("Выберите файл...");
  }
  // alert(`File name: ${file.name}`); // например, my.png
  // alert(`Last modified: ${file.lastModified}`); // например, 1552830408824
}
