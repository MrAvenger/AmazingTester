<?php namespace App\Models;
use CodeIgniter\Model;
class ResetPasswordModel extends Model{
    protected $table = 'password_resets';
    protected $allowedFields=['email','token','created_at'];
}