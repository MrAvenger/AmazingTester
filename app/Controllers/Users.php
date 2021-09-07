<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrganizationModel;
use App\Models\GroupClassModel;
use App\Models\ResetPasswordModel;
use App\Controllers\Email;

class Users extends BaseController
{
	public function register()
	{
		$data=[];
		helper(['form']);
		if($this->request->getMethod()=='post'){
			$signup = [
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
				'password_confirm'    => [
					'rules'  => 'matches[password]',
					'errors' => [
						'matches' => 'Повторите введённый пароль',
					]
				]
			];
  
			if($this->request->getPost('new_org_name')!=null){
				$signup['new_org_name']=[
					'rules'  => 'required|min_length[8]|max_length[100]',
					'errors' => [
						'required' => 'Организация - обязательное поле!',
						'min_length' => 'Минимальная длина названия организации - не менее 6-ми символов!',
						'max_length' => 'Максимальная длина названия организации - не более 100 символов!',
					],
				];
			}

			if(!$this->validate($signup)){
				$data['validation']=$this->validator;
				$data['user']=$_POST;
			}
			else{
				$session=session();
				$model=new UserModel();
				$modelOrg=new OrganizationModel();
				$orgdata['name']=$this->request->getPost('new_org_name');
				$modelOrg->save($orgdata);
				$verficode=md5(str_shuffle('abcdgfrthewerrthgpqqwertbn'.time()));
				$role="";
				$id_org="";
				if($this->request->getVar('role')!="User"&&$this->request->getVar('role')!="Teacher"){
					$role="User";
				}
				else{
					$role=$this->request->getVar('role');
				}

				if($this->request->getVar('new_org_name')==null){
					$id_org=$this->request->getVar('org');
				}
				else{
					$orginfo=$modelOrg->where('name',$this->request->getPost('new_org_name'))->first();
					$id_org=$orginfo['id'];
				}

				$newData=[
					'first_name' => $this->request->getVar('first_name'),
					'last_name' => $this->request->getVar('last_name'),
					'middle_name' => $this->request->getVar('middle_name'),
					'password' => $this->request->getVar('password'),
					'email' => $this->request->getVar('email'),
					'gender' => $this->request->getVar('sex'),
					'role' => $role,
					'organization_id' => $id_org,
					'group_or_class_id' => $this->request->getVar('group_class'),
					'created_at' =>date('Y-m-d H:i:s'),
					'updated_at' =>date('Y-m-d H:i:s'),
					'email_verification_code' => $verficode,
					'active_status' => 0,
				];
				if($model->save($newData)){
					$session=session();
					$session->setFlashdata('success','Успешная регистрация!<br>На почту отправлена ссылка для активации аккаунта');
					$EmailController=new Email();
					$EmailController->send_verify($newData);
					return redirect()->to('login');
				}
				else{
					$session=session();
					$session->setFlashdata('error','Ошибка создания учётной записи');
				}
			}
			
		}
		echo view('template/head');
		echo view('template/register/body',$data);
		echo view('template/footer');
	}
	//--------------------------------------------------------------------

	public function login(){
		require_once APPPATH.'config/ConfigGoogleApi.php';
		//session()->set('access_token',false);
		$data=[];
		helper(['form']);
		$modelUser=new UserModel();
		if($this->request->getMethod()=='post'){
			$rules=[
				'email' =>'required|valid_email',
				'password' =>'required|validateUser[email,password]',
			];
			$errors=[
				'password'=> [
					'required' => 'Пароль - обязательное поле',
					'validateUser' => 'Неверный логин или пароль'
				],
				'email' =>[
					'valid_email' => 'Проверьте адрес эл. почты!',
					'required' => 'Email - обязательное поле!',
				],
			];
			if(!$this->validate($rules,$errors)){
				$data['validation']=$this->validator;				
			}
			else{
				
				$user=$modelUser->where('email',$this->request->getVar('email'))->first();
				if($user['active_status']){
					$this->setUserSession($user);
					return redirect()->to('dashboard');
				}
				else{
					$session=session();
					$session->setFlashdata('error_login_status','Ваша учётная запись не активирована!');
				}
			}
		}
		if($this->request->getVar('code')){
			$token = $google_client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
			if(!isset($token["error"]))
			{
				$google_client->setAccessToken($token['access_token']);
				$google_service = new \Google_Service_Oauth2($google_client);
				$user = $google_service->userinfo->get();
				$userSearch=$modelUser->where('email',$user['email'])->first();
				if($userSearch!=null){
					if($userSearch['active_status']){
						$this->setUserSession($userSearch);
						return redirect()->to('dashboard');
					}
					else{
						$session=session();
						$session->setFlashdata('error_login_status','Ваша учётная запись не активирована!');
					}
				}
				else{
					$fname_mname  = $user['given_name'];
					$fname_mname_new = explode(" ", $fname_mname);
					$user_google = array(
						'first_name' => $fname_mname_new[0],
						'last_name'  => $user['family_name'],
						'middle_name' =>$fname_mname_new[1],
						'email' => $user['email'],
						'profile_picture'=> $user['picture'],
						'gender'=> $user['gender'],
					);
					$session=session();
					$session->setFlashdata('user_google',$user_google);
					$session->setFlashdata('success_google','Аккаунта с такой эл.почтой нет. Для прохождения регистрации из gmail были взяты данные');
					return redirect('register');
				}
			}
		}
		if(!session()->get('access_token')){
			$data['login_button']=$google_client->createAuthUrl();
		}
		
		echo view('template/head');
		echo view('template/login/body',$data);
		echo view('template/footer');
	}

	//--------------------------------------------------------------------

	private function setUserSession($user){
		$data=[
			'id' => $user['id'],
			'first_name' => $user['first_name'],
			'last_name' => $user['last_name'],
			'middle_name' => $user['middle_name'],
			'gender' => $user['gender'],
			'email' => $user['email'],
			'role' => $user['role'],
			'organization_id' => $user['organization_id'],
			'group_class' => $user['group_or_class_id'],
			'isLoggedIn' => true,
			'has_error' =>false,
		];
		session()->set($data);
		return true;
	}

	//--------------------------------------------------------------------

	public function profile(){
		
		$data=[];
		helper(['form']);
		$model=new UserModel();
		if($this->request->getMethod()=='post'){
			$update = [
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
  
			if($this->request->getPost('password')!=null){
				$update['password']=[
					'rules'  => 'required|min_length[8]|max_length[200]|regex_match[/(?=^.{8,200}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?!.*\s).*$/]',
					'errors' => [
						'required' => 'Пароль - обязательное поле!',
						'min_length' => 'Минимальная длина пароля - не менее 8-ми символов!',
						'max_length' => 'Максимальная длина пароля - не более 255-ти символов!',
						'regex_match' => 'Пароль должен содержать минимум один строчный латинский символ и символ в верхнем регистре, а также цифру. Длина пароля от 8 до 200 символов (включительно).'
					],
				];
				$update['password_confirm']=[
					'rules'  => 'matches[password]',
					'errors' => [
						'matches' => 'Повторите введённый пароль',
					],
				];
			}

			if(!$this->validate($update)){
				$data['validation']=$this->validator;
			}
			else{				
				$newData=[
					'id' => session()->get('id'),
					'first_name' => $this->request->getVar('first_name'),
					'last_name' => $this->request->getVar('last_name'),
					'middle_name' => $this->request->getVar('middle_name'),
					'organization_id' => $this->request->getVar('org'),
					'group_or_class_id' => $this->request->getVar('group_class'),
					'gender' => $this->request->getVar('sex'),
					'updated_at' =>date('Y-m-d H:i:s'),
				];
				if($this->request->getPost('password')!=null){
					$newData['password']=$this->request->getVar('password');
				}
				if($model->save($newData)){
					$session=session();
					$update_user=$model->where('id',session()->get('id'))->first();
					$session->setFlashdata('success','Данные изменены!');
					$this->setUserSession($update_user);
					return redirect()->to('profile');
				}
				else{
					$session=session();
					$session->setFlashdata('error','Ошибка обновления данных учётной записи');
				}
			}
		}
		
		$data['user']=$model->where('id',session()->get('id'))->first();
		echo view('template/head');
		echo view('template/profile/body',$data);
		echo view('template/footer');
	}

	//--------------------------------------------------------------------

	public function activate($token){
		$model=new UserModel();
		$user=$model->where('email_verification_code',$token)->first();
		if($user!=null){
			if(!$user['active_status']){
				$newData=[
					'id' => $user['id'],
					'active_status' =>1,
				];
				if($model->save($newData)){
					session()->setFlashdata('success','Учётная запись успешно активирована!');
				}
				else{
					session()->setFlashdata('error_login_status','Ошибка активации учётной записи');
				}				
			}
			else{
				session()->setFlashdata('error_login_status','Учётная запись уже активирована');
			}
		}
		else{
			session()->setFlashdata('error_login_status','Невалидный токен активации!');
		}
		return redirect('login');
	}

	//--------------------------------------------------------------------

	public function forgot_password(){
		$data=[];
		helper(['form']);
		if($this->request->getMethod()=='post'){
			$modelUser=new UserModel();
			$modelReset=new ResetPasswordModel();			
			$rules=[
				'email'    => [
					'rules'  => 'required|valid_email',
					'errors' => [
						'valid_email' => 'Проверьте адрес эл. почты!',
						'required' => 'Email - обязательное поле!',
					],
				],
			];
			if($this->validate($rules)){
				if($modelUser->where('email',$this->request->getVar('email'))->first()!=null){
					$user=$modelUser->where('email',$this->request->getVar('email'))->first();
					if($user['active_status']){
						if($modelReset->where('email',$this->request->getVar('email'))->first()!=null){
							$modelReset->where('email',$this->request->getVar('email'))->delete();
						}
						$token=md5(str_shuffle('abcdefgrtypplkjhgmnbvzqws'.time()));
						$newData=[
							'email' => $user['email'],
							'token' =>$token,
							'created_at' => date('Y-m-d H:i:s'),
						];
						if($modelReset->save($newData)){
							$user['token']=$token;
							$EmailController=new Email();
							$EmailController->send_reset($user);
							session()->setFlashdata('success_forgot','На почту отправлено письмо для восстановления пароля');
						}
						else{
							session()->setFlashdata('error_forgot','Ошибка создания токена');
						}
					}
					else{
						$EmailController=new Email();
						$EmailController->send_verify($user);
						session()->setFlashdata('error_forgot','Учётная запись неактивирована.'."<br>".' Активируйте учётную запись, перейдя по ссылке в письме!');
					}
				}
				else{
					session()->setFlashdata('error_forgot','Учётная запись с указанной почтой не найдена!');
				}
			}
			else{
				$data['validation']=$this->validator;
			}
		}

		echo view('template/head');
		echo view('template/forgot/forgot_password',$data);
		echo view('template/footer');
	}

	//--------------------------------------------------------------------

	public function reset($token){
		$data=[];
		helper(['form']);
		$modelUser=new UserModel();
		$modelReset=new ResetPasswordModel();
		$reset_user=$modelReset->where('token',$token)->first();
		if($reset_user!=null){
			if($this->request->getMethod()=='post'){
				$reset = [
					'password'    => [
						'rules'  => 'required|min_length[8]|max_length[200]|regex_match[/(?=^.{8,200}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?!.*\s).*$/]',
						'errors' => [
							'required' => 'Пароль - обязательное поле!',
							'min_length' => 'Минимальная длина пароля - не менее 8-ми символов!',
							'max_length' => 'Максимальная длина пароля - не более 255-ти символов!',
							'regex_match' => 'Пароль должен содержать минимум один строчный латинский символ и символ в верхнем регистре, а также цифру. Длина пароля от 8 до 200 символов (включительно).'
						]
					],
					'password_confirm'    => [
						'rules'  => 'matches[password]',
						'errors' => [
							'matches' => 'Повторите введённый пароль',
						]
					]
				];
	  
				if(!$this->validate($reset)){
					$data['validation']=$this->validator;
				}
				else{
					$modelReset->where('token',$token)->delete();
					$user=$modelUser->where('email',$reset_user['email'])->first();
					$Data=[
						'id' => $user['id'],
						'password' => $this->request->getVar('password'),
						'updated_at' =>date('Y-m-d H:i:s'),
					];
					if($modelUser->save($Data)){
						$session=session();
						$session->setFlashdata('success','Пароль успешно сменён');
						return redirect('login');
					}
					else{
						$session=session();
						$session->setFlashdata('error','Ошибка смены пароля');
					}
				}
			}
			$data['token']=$token;
			echo view('template/head');
			echo view('template/reset/reset',$data);
			echo view('template/footer');
		}
	}
	//--------------------------------------------------------------------

	public function getorgs(){
		$orgModel=new OrganizationModel();
		$array=$orgModel->findAll();
		return json_encode($array);
	}

	//--------------------------------------------------------------------

	public function get_group_class(){
		$orgModel=new GroupClassModel();
		$array=$orgModel->where('organization_id',$_POST['org_id'])->findAll();
		return json_encode($array);
	}
	
	//--------------------------------------------------------------------
	
	public function logout(){
		//$session=session();
		session()->destroy();
		return redirect()->to('/Codeigniter4');
	}

	//--------------------------------------------------------------------
}
