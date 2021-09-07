$(document).ready(function(){
    getorgs();
})

  function getorgs(){
    selectOrg = document.getElementById('org');
    $.ajax({
    url: 'users/getorgs',         /* Куда пойдет запрос */
    method: 'post',             /* Метод передачи (post или get) */
      success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
        if(data!=null){
          data.forEach(function(item, i, data) {
            var opt = document.createElement('option');
            opt.value = item.id;
            opt.innerHTML = item.name;
            selectOrg.appendChild(opt);
          });
        }
      },
      error: function(response) { // Данные не отправлены
          alert('Ошибка получения учебных организаций');
        },
      dataType: "json"
    });
  }

  function fields_for_role(){
    role = document.getElementById('role');
    if(role.value=="Teacher"){
        $("#org_select_name").html('<label for="org" class="form-label">Выберите учебное заведение или укажите вручную</label><div class="input-group mb-3"><span class="input-group-text" id="org-addon"><i class="far fa-building"></i></span><select id="org" name="org" onchange="addorg()" class="form-select" aria-label="Default select example" aria-describedby="org-addon"><option value=null selected>Другое</option></select></div>');
        addorg();
        getorgs();
    }
    else{
        $("#org_select_name").html('<label for="org" class="form-label">Укажите место обучения</label><div class="input-group mb-3"><span class="input-group-text" id="org-addon"><i class="far fa-building"></i></span><select id="org" onchange="addorg()" name="org" class="form-select" aria-label="Default select example" aria-describedby="org-addon"><option value=null selected>Другое</option></select></div>');
        getorgs();
    }
  }

  function addorg(){
    org = document.getElementById('org'); 
    role = document.getElementById('role');
    if(org.value=="null"&&role.value=="Teacher"){
        $("#org_select_name").append('<div id="input_for_new_org" class="col-sm-6"><label for="new_org_name" class="form-label">Ваша учебная организация:</label><div class="input-group mb-3"><span class="input-group-text" id="new_org_name_addon-addon">@</span><input type="text" class="form-control" id="new_org_name" name="new_org_name" placeholder="Наименование организации" aria-label="Наименование организации" aria-describedby="new_org_name_addon"></div></div>');
    }
    else if(org.value!="null"&&role.value=="User"){
        $("#input_for_new_org").remove();
        $.ajax({
            url: 'users/get_group_class',         /* Куда пойдет запрос */
            method: 'post',
            data:{org_id:org.value},             /* Метод передачи (post или get) */
              success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
                if(data!=null){
                  $("#reg_user_dop_info").html('<div class="col-sm-6"><label for="course" class="form-label">Укажите группу/класс:</label><div class="input-group mb-3"><span class="input-group-text" id="group-class-addon"><i class="fas fa-user-friends"></i></span><select id="group_class" name="group_class" class="form-select" aria-label="Default select example" aria-describedby="group-class-addon"><option selected value=null>Не указано</option></select></div></div>');
                  group_class_select = document.getElementById('group_class');
                  data.forEach(function(item, i, data) {
                    var opt = document.createElement('option');
                    opt.value = item.id;
                    opt.innerHTML = item.name;
                    group_class.appendChild(opt);
                  });
                }
              },
              error: function(response) { // Данные не отправлены
                  alert('Ошибка получения учебных групп/классов');
                },
            dataType: "json"
        });
    }
    else{
        $("#reg_user_dop_info").html('');
        $("#input_for_new_org").remove();
    }
  }

  function showHidePwd() {
    var input = form_reg.password;
    var eye=document.getElementById("eye_reg");
    if (input.type === "password") {
        input.type = "text";
        eye.className = "far fa-eye";

    } else {
        input.type = "password";
        eye.className = "far fa-eye-slash";

    }     
  }