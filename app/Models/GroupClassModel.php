<?php namespace App\Models;
use CodeIgniter\Model;
class GroupClassModel extends Model{
    protected $table = 'groups_and_classes';
    protected $allowedFields=['id','name','organization_id','created_by','updated_at','created_at'];
}