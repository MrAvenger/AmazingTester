<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrganizationModel;
use App\Models\SubjectsModel;
use App\Models\GroupClassModel;

class Organizations extends BaseController
{
    public function storage_organizations(){
        $OrganizationModel=new OrganizationModel();
        $html=array();
        $t=array();
        $array=$OrganizationModel->findAll();
        foreach($array as $item){
            array_push($html,'<th scope="row">'.$item['id'].'</th>');
            array_push($html,'<td>'.$item['name'].'</td>');
            array_push($html,'<button type="button" data-toggle="modal" data-target="#Modal_Organization_Edit" class="btn btn-primary btn-sm btn-floating"  onclick="edit_open('.$item['id'].')"> <i class="far fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm btn-floating" data-toggle="modal" data-target="#Modal_Organization_Delete" onclick="delete_open('.$item['id'].')"> <i class="fas fa-trash-alt"></i></button>');
            array_push($t,$html);
            $html=array();
        }
        return json_encode($t);
    }

    public function add_organization(){
        helper(['form']);
        $data=[];
        $OrganizationModel=new OrganizationModel();
        $rules=[
            'name' =>[
                'rules'  => 'required|max_length[100]|min_length[5]',
                'errors' => [
                    'required' => 'Название - обязательное поле!',
                    'min_length' => 'Название - должно содержать не менее 5-ти символов!',
                    'max_length' => 'Название - должно содержать не более 100 символов!',
                ],
            ]
        ];

        if(!$this->validate($rules)){
            $data=$this->validator->listErrors();            
        }
        else if($OrganizationModel->where('name',$_POST['name'])->first()!=null){
            $data="Такая организация уже есть";
        }
        else{
            $data=[
                'name' =>$_POST['name']
            ];
            $OrganizationModel->save($data);
            $data=true;
        }
        return json_encode($data);
    }

    public function edit_organization($id){
        helper(['form']);
        $data=[];
        $OrganizationModel=new OrganizationModel();
        $organization=$OrganizationModel->where('id',$id)->first();
        $rules=[
            'name' =>[
                'rules'  => 'required|max_length[100]|min_length[5]',
                'errors' => [
                    'required' => 'Название - обязательное поле!',
                    'min_length' => 'Название - должно содержать не менее 5-ти символов!',
                    'max_length' => 'Название - должно содержать не более 100 символов!',
                ],
            ]
        ];
        if(!$this->validate($rules)){
            $data=$this->validator->listErrors();            
        }
        else if(($organization['name']!=$_POST['name'])&&($OrganizationModel->where('name',$_POST['name'])->first()!=null)){
            $data="Такая организация уже есть!";
        }
        else{
            $data=[
                'name' =>$_POST['name'],
            ];

            $OrganizationModel->update($id,$data);
            $data=true;
        }
        return json_encode($data);
    }

    public function get_organization()
    {
        $OrganizationModel=new OrganizationModel();
        $array= $OrganizationModel->where('id',$_POST['id'])->first();
        return json_encode($array);
    }

    public function delete_organizations()
    {
        $OrganizationModel=new OrganizationModel();
        $OrganizationModel->where('id',$_POST['id'])->delete();
        return true;
    }
}