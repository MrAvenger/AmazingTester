<?php namespace App\Models;
use CodeIgniter\Model;
class OrganizationModel extends Model{
    protected $table = 'organizations';
    protected $allowedFields=['id','name'];
}