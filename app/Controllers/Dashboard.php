<?php namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index(){
        echo view('template/head');
		echo view('template/dashboard/body');
		echo view('template/footer');
    }
}