<?php namespace App\Models;
use CodeIgniter\Model;
class SubjectsModel extends Model{
    protected $table = 'subjects';
    protected $allowedFields=['name','image','group_or_class_id','created_by','created_at','updated_at'];
    //protected $beforeInsert=['beforeInsert'];
    //protected $beforeUpdate=['beforeUpdate'];
}