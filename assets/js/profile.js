$(document).ready(function(){
    getorgs();
    getgroup_class(my_account['organization_id']);
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
            if(item.id==my_account['id']){
                opt.selected=true;
            }
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

function getgroup_class(orgval){
    let value_org=0;
    var org=document.getElementById('org');
    if(orgval!=null){
      value_org=orgval;
    }
    else{
      value_org=org.value;
    }
    $.ajax({
        url: 'users/get_group_class',         /* Куда пойдет запрос */
        method: 'post',
        data:{org_id:value_org},             /* Метод передачи (post или get) */
          success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
            if(data!=null){
              $("#dop_info_group").html('<div class="col-sm-6"><label for="course" class="form-label">Укажите группу/класс:</label><div class="input-group mb-3"><span class="input-group-text" id="group-class-addon"><i class="fas fa-user-friends"></i></span><select id="group_class" name="group_class" class="form-select" aria-label="Default select example" aria-describedby="group-class-addon"><option selected value=null>Не указано</option></select></div></div>');
              group_class_select = document.getElementById('group_class');
              data.forEach(function(item, i, data) {
                var opt = document.createElement('option');
                opt.value = item.id;
                if(item.id==my_account['group_or_class_id']){
                    opt.selected=true;
                }
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

function showHidePwd() {
    var input = form_profile.password;
    var eye=document.getElementById("eye_reg");
    if (input.type === "password") {
        input.type = "text";
        eye.className = "far fa-eye";

    } else {
        input.type = "password";
        eye.className = "far fa-eye-slash";

    }     
}
