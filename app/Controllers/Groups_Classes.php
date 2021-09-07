<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrganizationModel;
use App\Models\SubjectsModel;
use App\Models\GroupClassModel;

class Groups_Classes extends BaseController
{
    public function storage_groups_classes(){
        $SubjectsModel=new SubjectsModel();
        $GroupClassModel=new GroupClassModel();
        $OrganizationModel=new OrganizationModel();
        $html=array();
        $t=array();
        $array=$GroupClassModel->findAll();
        foreach($array as $item){
            array_push($html,'<th scope="row">'.$item['id'].'</th>');
            array_push($html,'<td>'.$item['name'].'</td>');
            $modelUs=new UserModel();
            $user_by_item=$modelUs->where('id',$item['created_by'])->first();
            $myorg=$OrganizationModel->where('id',$item['organization_id'])->first();
            array_push($html,'<td>'.$myorg['name'].'</td>');
            array_push($html,'<td>'.'(№ '.$item['created_by'].') '.$user_by_item['first_name'].' '.$user_by_item['last_name'].'</td>');
            array_push($html,'<td>'.date("d.m.Y H:i:s",strtotime($item['created_at'])).'</td>');
            array_push($html,'<td>'.date("d.m.Y H:i:s",strtotime($item['updated_at'])).'</td>');
            array_push($html,'<button type="button" data-toggle="modal" data-target="#Modal_Group_Classes_Edit" class="btn btn-primary btn-sm btn-floating"  onclick="edit_open('.$item['id'].')"> <i class="far fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm btn-floating" data-toggle="modal" data-target="#Modal_Group_Classes_Delete" onclick="delete_open('.$item['id'].')"> <i class="fas fa-trash-alt"></i></button>');
            array_push($t,$html);
            $html=array();
        }
        return json_encode($t);
    }

    public function add_groups_classes(){
        helper(['form']);
        $data=[];
        $GroupClassModel=new GroupClassModel();
        $OrganizationModel=new OrganizationModel();
        $newsub=[
            'name'=>$_POST['name'],
            'organization_id'=>$_POST['organization_id']
        ];
        $rules=[
            'name' =>[
                'rules'  => 'required|max_length[20]|min_length[2]',
                'errors' => [
                    'required' => 'Название - обязательное поле!',
                    'min_length' => 'Название - должно содержать не менее 2-х символов!',
                    'max_length' => 'Название - должно содержать не более 20 символов!',
                ],
            ],
            'organization_id' =>[
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Организация - обязательное поле!',
                ],
            ]
        ];

        if(!$this->validate($rules)){
            $data=$this->validator->listErrors();            
        }
        else if($GroupClassModel->where($newsub)->first()!=null){
            $data="Такая группа у организации уже есть!";
        }
        else{
            $newsub['created_by']=session()->get('id');
            $newsub['updated_at']=date('Y-m-d H:i:s');
            $GroupClassModel->save($newsub);
            $data=true;
        }
        return json_encode($data);
    }

    public function edit_groups_classes($id){
        helper(['form']);
        $data=[];
        $GroupClassModel=new GroupClassModel();
        $OrganizationModel=new OrganizationModel();
        $group_class=$GroupClassModel->where('id',$id)->first();
        $newgroup_class=[
            'name'=>$_POST['name'],
            'organization_id'=>$_POST['organization_id']
        ];
        $group_class_old=$GroupClassModel->where($newgroup_class)->first();
        $rules=[
            'name' =>[
                'rules'  => 'required|max_length[20]|min_length[2]',
                'errors' => [
                    'required' => 'Название - обязательное поле!',
                    'min_length' => 'Название - должно содержать не менее 2-х символов!',
                    'max_length' => 'Название - должно содержать не более 20 символов!',
                ],
            ],
            'organization_id' =>[
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Организация - обязательное поле!',
                ],
            ]
        ];

        if(!$this->validate($rules)){
            $data=$this->validator->listErrors();            
        }
        else if(($group_class_old!=null)&&($group_class['id']!=$group_class_old['id'])){
            $data="У выбранной организации уже есть такая группа!";
        }
        else{
            $data=[
                'name' =>$_POST['name'],
                'organization_id' =>$_POST['organization_id'],
                'created_by' =>session()->get('id'),
                'updated_at' =>date('Y-m-d H:i:s'),
            ];

            $GroupClassModel->update($id,$data);
            $data=true;
        }
        return json_encode($data);
    }

    public function get_groups_classes()
    {
        $GroupClassModel=new GroupClassModel();
        $array= $GroupClassModel->where('id',$_POST['id'])->first();
        return json_encode($array);
    }

    public function delete_groups_classes()
    {
        $GroupClassModel=new GroupClassModel();
        $GroupClassModel->where('id',$_POST['id'])->delete();
        return true;
    }

    public function getorgs(){
        $OrganizationModel=new OrganizationModel();
        return json_encode($OrganizationModel->findAll());
    }
}