<?php
namespace App\Models;
use CodeIgniter\Model;

class Users_model extends Model{
    protected $table='users';
    protected $primaryKey='id';
    protected $useAutoIncrement=true;
    protected $allowedFields=['name','username','password','role','role_title','created_at','updated_at'];


    public function get_user($username,$password){  
        return $this->where(['username' => $username, 'password' => $password])->first();
        //echo 'czxcz'. $this->db->getLastQuery(); exit;
    }
    public function get_roles(){
        $query=$this->db->table('user_roles')->get();
        return $query->getResultArray();
    }

}





