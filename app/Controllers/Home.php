<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('template/head');
		echo view('template/main/body');
		echo view('template/footer');
	}
	
	public function error403()
	{
		$session=service('session');
		if($session->isLoggedIn){
			$session->has_error=false;
		}
		header('Refresh: 5; url='.base_url());
		echo view('template/error403');		
	}
}
