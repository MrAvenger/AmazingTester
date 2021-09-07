<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrganizationModel;
use App\Models\SubjectsModel;
use App\Models\GroupClassModel;

class Subjects extends BaseController
{
    public function storage_subjects(){
        $SubjectsModel=new SubjectsModel();
        $GroupClassModel=new GroupClassModel();
        $OrganizationModel=new OrganizationModel();
        $html=array();
        $t=array();
        $array=$SubjectsModel->findAll();
        foreach($array as $item){
            array_push($html,'<th scope="row">'.$item['id'].'</th>');
            array_push($html,'<td>'.$item['name'].'</td>');
            array_push($html,'<td><img width="100" height="70" src="'.base_url().'/public/uploads/images/categories/'.$item['image'].'"></td>');
            $group=$GroupClassModel->where('id',$item['group_or_class_id'])->first();
            array_push($html,'<td>'.$group['name'].'</td>');
            $modelUs=new UserModel();
            $user_by_item=$modelUs->where('id',$item['created_by'])->first();
            $myorg=$OrganizationModel->where('id',$group['organization_id'])->first();
            array_push($html,'<td>'.$myorg['name'].'</td>');
            array_push($html,'<td>'.'(№ '.$item['created_by'].') '.$user_by_item['first_name'].' '.$user_by_item['last_name'].'</td>');
            array_push($html,'<td>'.date("d.m.Y H:i:s",strtotime($item['created_at'])).'</td>');
            array_push($html,'<td>'.date("d.m.Y H:i:s",strtotime($item['updated_at'])).'</td>');
            array_push($html,'<button type="button" data-toggle="modal" data-target="#Modal_Subject_Edit" class="btn btn-primary btn-sm btn-floating"  onclick="edit_open('.$item['id'].')"> <i class="far fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm btn-floating" data-toggle="modal" data-target="#Modal_Subject_Delete" onclick="delete_open('.$item['id'].')"> <i class="fas fa-trash-alt"></i></button>');
            array_push($t,$html);
            $html=array();
        }
        return json_encode($t);
    }

    public function add_subject(){
        helper(['form','file']);
        $data=[];
        $SubjectsModel=new SubjectsModel();
        $GroupClassModel=new GroupClassModel();
        $newsub=[
            'name'=>$_POST['name'],
            'group_or_class_id'=>$_POST['group_or_class_id']
        ];
        $rules=[
            'file' =>[
                'rules'  => 'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,4096]|uploaded[file]',
                'errors' => [
                    'mime_in' => 'Файл не является изображением!',
                    'max_size' => 'Превышен допустимый размер файла!',
                    'uploaded' => 'Файл не загружен!',
                ],
            ],
            'name' =>[
                'rules'  => 'required|max_length[125]|min_length[5]',
                'errors' => [
                    'required' => 'Название - обязательное поле!',
                    'min_length' => 'Название - должно содержать не менее 5-ти символов!',
                    'max_length' => 'Название - должно содержать не более 125 символов!',
                ],
            ],
            'group_or_class_id' =>[
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Группа - обязательное поле!',
                ],
            ]
        ];

        if(!$this->validate($rules)){
            $data=$this->validator->listErrors();            
        }
        else if($GroupClassModel->where('id',$_POST['group_or_class_id'])->first()==null){
            $data="Группа должна быть указана!";
        }
        else if($SubjectsModel->where($newsub)->first()!=null){
            $data="Такой предмет у группы уже есть!";
        }
        else{
            if($img = $this->request->getFile('file'))
            {
                $image=$this->request->getFile('file');
                if ($img->isValid() && ! $img->hasMoved())
                {
                    $newName = $img->getRandomName();
                    $img->move('./public/uploads/images/categories', $newName);
                    $data=[
                        'image' =>$newName,
                        'group_or_class_id' =>$_POST['group_or_class_id'],
                        'created_by' =>session()->get('id'),
                        'name' =>$_POST['name'],
                        'updated_at' =>date('Y-m-d H:i:s'),
                    ];
        
                    $SubjectsModel->save($data);
                }
            }

            $data=true;
        }
        return json_encode($data);
    }

    public function edit_subject($id){
        helper(['form','file']);
        $data=[];
        $SubjectsModel=new SubjectsModel();
        $GroupClassModel=new GroupClassModel();
        $OrganizationModel=new OrganizationModel();
        $sub=$SubjectsModel->where('id',$id)->first();
        $newsub=[
            'name'=>$_POST['name'],
            'group_or_class_id'=>$_POST['group_or_class_id']
        ];
        $sub_old=$SubjectsModel->where($newsub)->first();
        $rules=[
            'name' =>[
                'rules'  => 'required|max_length[125]|min_length[5]',
                'errors' => [
                    'required' => 'Название - обязательное поле!',
                    'min_length' => 'Название - должно содержать не менее 5-ти символов!',
                    'max_length' => 'Название - должно содержать не более 125 символов!',
                ],
            ],
            'group_or_class_id' =>[
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Группа - обязательное поле!',
                ],
            ]
        ];
        if($this->request->getFile('file')!=null){
            $rule['file']=[
                'rules'  => 'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,4096]|uploaded[file]',
                'errors' => [
                    'mime_in' => 'Файл не является изображением!',
                    'max_size' => 'Превышен допустимый размер файла!',
                    'uploaded' => 'Файл не загружен!',
                ],
            ];
        }
        if(!$this->validate($rules)){
            $data=$this->validator->listErrors();            
        }
        else if($GroupClassModel->where('id',$_POST['group_or_class_id'])->first()==null){
            $data="Группа должна быть указана!";
        }
        else if(($sub_old!=null)&&($sub['id']!=$sub_old['id'])){
            $data="У указанной группы уже есть такая дисциплина!";
        }
        else{
            if($img = $this->request->getFile('file'))
            {
                if(file_exists('./public/uploads/images/categories/'.$info['image'])){
                    $info=$SubjectsModel->where('id',$id)->first();
                    unlink('./public/uploads/images/categories/'.$info['image']);
                }
                $image=$this->request->getFile('file');
                if ($img->isValid() && ! $img->hasMoved())
                {
                    $newName = $img->getRandomName();
                    $img->move('./public/uploads/images/categories', $newName);
                    $data=[
                        'image' =>$newName,
                        'name' =>$_POST['name'],
                        'group_or_class_id' =>$_POST['group_or_class_id'],
                        'created_by' =>session()->get('id'),
                        'updated_at' =>date('Y-m-d H:i:s'),
                    ];
        
                    $SubjectsModel->update($id,$data);
                }
            }
            else{
                $data=[
                    'name' =>$_POST['name'],
                    'group_or_class_id' =>$_POST['group_or_class_id'],
                    'created_by' =>session()->get('id'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                ];
    
                $SubjectsModel->update($id,$data);
            }
            $data=true;
        }
        return json_encode($data);
    }

    public function get_subject()
    {
        $SubjectsModel=new SubjectsModel();
        $array= $SubjectsModel->where('id',$_POST['id'])->first();
        $GroupClassModel=new GroupClassModel();
        $org=$GroupClassModel->where('id',$array['group_or_class_id'])->first();
        $array['organization_id']=$org['organization_id'];
        return json_encode($array);
    }

    public function delete_subjects()
    {
        $SubjectsModel=new SubjectsModel();
        $info=$SubjectsModel->where('id',$_POST['id'])->first();
        if(file_exists('./public/uploads/images/categories/'.$info['image'])){
            unlink('./public/uploads/images/categories/'.$info['image']);
        }
        $SubjectsModel->where('id',$_POST['id'])->delete();
        return true;
    }
}