<?php namespace App\Controllers;
use App\Controllers\Email;
use App\Models\UserModel;
use App\Models\OrganizationModel;
use App\Models\SubjectsModel;
use App\Models\GroupClassModel;

class Admin extends BaseController
{
    public function index(){
        echo view('admin_template/head');
        echo view('admin_template/main/body');
		//echo view('admin_template/footer');
    }
    #######################################################

    public function users(){
        echo view('admin_template/head');
        echo view('admin_template/users/body');
        echo view('admin_template/users/modals/delete');
        echo view('admin_template/users/modals/edit');
		//echo view('admin_template/footer');
    }
    #######################################################

    public function organizations(){
        echo view('admin_template/head');
        echo view('admin_template/organizations/body');
        echo view('admin_template/organizations/modals/delete');
        echo view('admin_template/organizations/modals/edit');
		//echo view('admin_template/footer');
    }
    #######################################################

    public function subjects(){
        echo view('admin_template/head');
        echo view('admin_template/subjects/body');
        echo view('admin_template/subjects/modals/delete');
        echo view('admin_template/subjects/modals/edit');
		//echo view('admin_template/footer');
    }
    #######################################################

    public function groups_classes(){
        echo view('admin_template/head');
        echo view('admin_template/groups_classes/body');
        echo view('admin_template/groups_classes/modals/delete');
        echo view('admin_template/groups_classes/modals/edit');
		//echo view('admin_template/footer');
    }
    #######################################################

    public function storage_users(){
        $UserModel=new UserModel();
        $GroupClassModel=new GroupClassModel();
        $OrganizationModel=new OrganizationModel();
        $html=array();
        $t=array();
        //$html=$UserModel->findAll();
        $array=$UserModel->findAll();
        foreach($array as $item){
            $group=$GroupClassModel->where('id',$item['group_or_class_id'])->first();
            $org=$OrganizationModel->where('id',$item['organization_id'])->first();
            array_push($html,'<th scope="row">'.$item['id'].'</th>');
            array_push($html,'<td>'.$item['first_name'].'</td>');
            array_push($html,'<td>'.$item['last_name'].'</td>');
            array_push($html,'<td>'.$item['middle_name'].'</td>');
            array_push($html,'<td>'.$item['gender'].'</td>');
            array_push($html,'<td>'.$item['email'].'</td>');
            array_push($html,'<td>'.$org['name'].'</td>');
            array_push($html,'<td>'.$group['name'].'</td>');
            switch($item['role']){
                case 'User':{
                    array_push($html,'<td>Обучающийся</td>');
                }break;
                case 'Admin':{
                    array_push($html,'<td>Администратор</td>');
                }break;
                case 'Teacher':{
                    array_push($html,'<td>Преподаватель</td>');
                }
            }
            if($item['active_status']==1){
                array_push($html,'<button class="btn btn-success btn-rounded" onclick="activate_user('.$item['id'].')">Активирован</button>');
            }
            else{
                array_push($html,'<button class="btn btn-danger btn-rounded" onclick="activate_user('.$item['id'].')">Неактивирован</button>');
            }
            array_push($html,'<td>'.date("d.m.Y H:i:s",strtotime($item['created_at'])).'</td>');
            array_push($html,'<td>'.date("d.m.Y H:i:s",strtotime($item['updated_at'])).'</td>');
            array_push($html,'<button type="button" data-toggle="modal" data-target="#Modal_User_Edit" class="btn btn-primary btn-sm btn-floating"  onclick="edit_open('.$item['id'].')"> <i class="far fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm btn-floating" data-toggle="modal" data-target="#Modal_User_Delete" onclick="delete_open('.$item['id'].')"> <i class="fas fa-trash-alt"></i></button>');
            array_push($t,$html);
            $html=array();
        }
        return json_encode($t);
    }

    public function delete_users()
    {
        $session=session();
            if($_POST['id']==$session->id){
                return json_encode(false);
            }
            else{
                $UserModel=new UserModel();
                $UserModel->where('id',$_POST['id'])->delete();
                return json_encode(true);
            }
    }

    public function edit_user($id)
    {
        $UserModel=new UserModel();
        $user=$UserModel->where('id',$id)->first();
        $data=array();
        $rules = [
            'first_name' => [
                'rules'  => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Имя - обязательное поле!',
                    'min_length' => 'Имя - должно содержать не менее 3-х символов!',
                    'max_length' => 'Имя - должно содержать не более 50 символов!',
                ]
            ],
            'last_name' => [
                'rules'  => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Фамилия - обязательное поле!',
                    'min_length' => 'Фамилия - должна содержать не менее 3-х символов!',
                    'max_length' => 'Фамилия - должна содержать не более 50 символов!',
                ]
            ],
            'middle_name' => [
                'rules'  => 'max_length[50]',
                'errors' => [
                    'max_length' => 'Отчество - должно содержать не более 50-ти символов!',
                ]
            ],
        ];
        if($_POST['password']!=null){
            $rules['password']=[
                'rules'  => 'required|min_length[8]|max_length[200]|regex_match[/(?=^.{8,200}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?!.*\s).*$/]',
                'errors' => [
                    'required' => 'Пароль - обязательное поле!',
                    'min_length' => 'Минимальная длина пароля - не менее 8-ми символов!',
                    'max_length' => 'Максимальная длина пароля - не более 200-ти символов!',
                    'regex_match' => 'Пароль должен содержать минимум один строчный латинский символ и символ в верхнем регистре, а также цифру. Длина пароля от 8 до 200 символов (включительно).'
                ],
            ];
        }
        if($user!=null&&$_POST['email']!=$user['email']){
            $rules['email']=[
                'rules'  => 'required|min_length[3]|max_length[255]|valid_email|is_unique[users.email]',
                'errors' => [
                    'valid_email' => 'Проверьте адрес эл. почты!',
                    'required' => 'Email - обязательное поле!',
                    'min_length' => 'Минимальная длина адреса эл.почты - не менее 3-х символов!',
                    'max_length' => 'Максимальная длина адреса эл.почты - не более 255-ти символов!',
                    'is_unique' => 'Данный адрес эл.почты уже занят!',
                ],
            ];
        }
        else{
            $rules['email']=[
                'rules'  => 'required|min_length[3]|max_length[255]|valid_email',
                'errors' => [
                    'valid_email' => 'Проверьте адрес эл. почты!',
                    'required' => 'Email - обязательное поле!',
                    'min_length' => 'Минимальная длина адреса эл.почты - не менее 3-х символов!',
                    'max_length' => 'Максимальная длина адреса эл.почты - не более 255-ти символов!',
                ],
            ];
        }
        if(!$this->validate($rules)){
            $data=$this->validator->listErrors();            
        }
        else{

            if($this->request->getVar('org')==-1){
                $org=null;
                $group_class=null;
            }
            else if($this->request->getVar('group_class')==-1&&$this->request->getVar('org')!=-1){
                $group_class=null;
                $org=$this->request->getVar('org');
            }
            else{
                $org=$this->request->getVar('org');
                $group_class=$this->request->getVar('group_class');
            }

            $data=[
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'middle_name' => $_POST['middle_name'],
                'gender' => $_POST['sex'],
                'role' => $_POST['role'],
                'email' => $_POST['email'],
                'organization_id' => $org,
                'group_or_class_id' => $group_class,
                'updated_at' =>date('Y-m-d H:i:s'),
            ];
            if($_POST['password']!=null){
                $data['password']=$_POST['password'];
            }
            $session=session();
            if($id==$session->id){
                if($_POST['role']!='Admin'){
                    //$data='Вы не можете изменить себе роль!';
                    $data=false;
                }
                else{
                    $UserModel->update($id, $data);
                    $data=true;
                }
            }
            else{
                $UserModel->update($id, $data);
                $data=true;
            }
        }
        //$data=true;
        return json_encode($data);
    }

    public function add_user()
    {
        $UserModel=new UserModel();
        $data=array();
        $rules = [
            'first_name' => [
                'rules'  => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Имя - обязательное поле!',
                    'min_length' => 'Имя - должно содержать не менее 3-х символов!',
                    'max_length' => 'Имя - должно содержать не более 50 символов!',
                ]
            ],
            'last_name' => [
                'rules'  => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Фамилия - обязательное поле!',
                    'min_length' => 'Фамилия - должна содержать не менее 3-х символов!',
                    'max_length' => 'Фамилия - должна содержать не более 50 символов!',
                ]
            ],
            'middle_name' => [
                'rules'  => 'max_length[50]',
                'errors' => [
                    'max_length' => 'Отчество - должно содержать не более 50-ти символов!',
                ]
            ],
            'email'    => [
                'rules'  => 'required|min_length[3]|max_length[255]|valid_email|is_unique[users.email]',
                'errors' => [
                    'valid_email' => 'Проверьте адрес эл. почты!',
                    'required' => 'Email - обязательное поле!',
                    'min_length' => 'Минимальная длина адреса эл.почты - не менее 3-х символов!',
                    'max_length' => 'Максимальная длина адреса эл.почты - не более 255-ти символов!',
                    'is_unique' => 'Данный адрес эл.почты уже занят!',
                ]
            ],
            'password'    => [
                'rules'  => 'required|min_length[8]|max_length[200]|regex_match[/(?=^.{8,200}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?!.*\s).*$/]',
                'errors' => [
                    'required' => 'Пароль - обязательное поле!',
                    'min_length' => 'Минимальная длина пароля - не менее 8-ми символов!',
                    'max_length' => 'Максимальная длина пароля - не более 200-ти символов!',
                    'regex_match' => 'Пароль должен содержать минимум один строчный латинский символ и символ в верхнем регистре, а также цифру. Длина пароля от 8 до 200 символов (включительно).'
                ]
            ],
        ];
        if(!$this->validate($rules)){
            $data=$this->validator->listErrors();            
        }
        else{

            $org=null;
            $group_class=null;
            
            if($this->request->getVar('org')==-1){
                $org=null;
                $group_class=null;
            }
            else if($this->request->getVar('group_class')==-1&&$this->request->getVar('org')!=-1){
                $group_class=null;
                $org=$this->request->getVar('org');
            }
            else{
                $org=$this->request->getVar('org');
                $group_class=$this->request->getVar('group_class');
            }

            $verficode=md5(str_shuffle('abcdgfrthewerrthgpqqwertbn'.time()));
            $data=[
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'middle_name' => $_POST['middle_name'],
                'gender' => $_POST['sex'],
                'role' => $_POST['role'],
                'email' => $_POST['email'],
                'organization_id' => $org,
                'group_or_class_id' => $group_class,
                'password' => $_POST['password'],
                'updated_at' =>date('Y-m-d H:i:s'),
                'email_verification_code' => $verficode,
            ];
            $UserModel->save($data);
            $EmailController=new Email();
            $EmailController->send_verify($data);
            $data=true;
        }
        //$data=true;
        return json_encode($data);
    }

    public function get_user()
    {
        $UserModel=new UserModel();
        $array= $UserModel->where('id',$_POST['id'])->first();
        
        return json_encode($array);
    }

    public function activate_user($id)
    {
        $UserModel=new UserModel();
        $session=session();
        if($id==$session->id){
            return json_encode(false);
        }
        else{
            $user= $UserModel->where('id',$id)->first();
            if($user['active_status']==1){
                $user['active_status']=0;
            }
            else{
                $user['active_status']=1;
            }
            $user['updated_at'] =date('Y-m-d H:i:s');
            $UserModel->update($id,$user);
            return json_encode(true);
        }
    }
}