$(document).ready(function () {
    $("#table_groups_classes").dataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json",
      },
      columns: [{ searchable: true }, null,null,null,null,null,null],
      //AllowPaging="false"
    });
    storage();
    getorgs();
  });
  
  function storage() {
    var html = [];
    var t = $("#table_groups_classes").DataTable();
    $.ajax({
      url: "../groups_classes/storage_groups_classes" /* Куда пойдет запрос */,
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
    document.getElementById("form_edit_group_classes").reset();
    $("#edit_tittle").html(
      '<h5 class="modal-title">Создание группы/класса</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
    );
    $("#buttons_edit_group_classes").html(
      '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button><button type="button" onclick="add_group_class()" class="btn btn-primary">Добавить</button>'
    );
  }
  
  function add_group_class() {
    var html = '<div class="alert alert-danger" role="alert">';
    org = document.getElementById("org");
    $.ajax({
      url: "../groups_classes/add_groups_classes" /* Куда пойдет запрос */,
      method: "post" /* Метод передачи (post или get) */,
      data: {name:document.getElementById("name").value, organization_id:org.value},
      success: function (data) {
        /* функция которая будет выполнена после успешного запроса.  */
        if (data == true) {
          $("#Modal_Group_Classes_Edit").modal("hide");
          storage();
          $.toast({
            heading: "Успех",
            text: "Успешное добавление новой группы/класса.",
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
    document.getElementById("form_edit_group_classes").reset();
    $.ajax({
      url: "../groups_classes/get_groups_classes" /* Куда пойдет запрос */,
      method: "post" /* Метод передачи (post или get) */,
      data: { id: id },
      success: function (data) {
        /* функция которая будет выполнена после успешного запроса.  */
        //$('#Modal_User_Delete').modal('hide');
        if (data != null) {
          document.getElementById("name").value = data.name;
          document.getElementById("org").value = data.organization_id;
          $("#edit_tittle").html(
            '<h5 class="modal-title">Изменение данных о группе/классе</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
          );
          $("#buttons_edit_group_classes").html(
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button><button type="button" onclick="edit_group_class(' +
              data.id +
              ')" class="btn btn-primary">Изменить</button>'
          );
        }
      },
      dataType: "json",
    });
  }
  
  function edit_group_class(id) {
    var html = '<div class="alert alert-danger" role="alert">';
    org = document.getElementById("org");
    $.ajax({
      url: "../groups_classes/edit_groups_classes/" + id /* Куда пойдет запрос */,
      method: "post" /* Метод передачи (post или get) */,
      data: {name:document.getElementById("name").value, organization_id:org.value},
      success: function (data) {
        /* функция которая будет выполнена после успешного запроса.  */
        if (data == true) {
          $("#Modal_Group_Classes_Edit").modal("hide");
          storage();
          $.toast({
            heading: "Успех",
            text: "Успешное изменение группы/класса.",
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
  
  function delete_groups_classes() {
    $.ajax({
      url: "../groups_classes/delete_groups_classes" /* Куда пойдет запрос */,
      method: "post" /* Метод передачи (post или get) */,
      data: { id: document.getElementById("delete_id").value },
      success: function (data) {
        /* функция которая будет выполнена после успешного запроса.  */
        $("#Modal_Group_Classes_Delete").modal("hide");
        storage();
        $.toast({
          heading: "Успех",
          text: "Успешное удаление группы/класса.",
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
      url: "../groups_classes/getorgs" /* Куда пойдет запрос */,
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