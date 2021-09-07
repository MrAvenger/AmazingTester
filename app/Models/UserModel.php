<?php namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model{
    protected $table = 'users';
    protected $allowedFields=['first_name','last_name','middle_name','email','password','updated_at','created_at','gender','role','email_verification_code','active_status','organization_id','group_or_class_id'];
    protected $beforeInsert=['beforeInsert'];
    protected $beforeUpdate=['beforeUpdate'];
    protected $createdField  = ['created_at'];
    protected $updatedField  = ['updated_at'];

    protected function beforeInsert(array $data){
        $data=$this->passwordHash($data);
        return $data;
    }

    protected function beforeUpdate(array $data){
        $data=$this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data){
        if(isset($data['data']['password'])){
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}