<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SubjectsModel;

class Tests extends BaseController
{
    public function index(){
        $model=new SubjectsModel();
        $data['categories']=$model->findAll();
        echo view('template/head');
		echo view('template/categories/body',$data);
		echo view('template/footer');
    }

    public function create(){
        echo view('template/head');
		echo view('template/test_create/body');
		echo view('template/footer');
    }
}