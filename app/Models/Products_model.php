<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use CodeIgniter\Model;


class Products_model extends Model{
    protected $table='products';
    protected $primaryKey='id';
    
    protected $useAutoIncrement=true;
    
    protected $allowedFields=['name','product_category_id','price','stock_status','created_by','updated_at'];
    
    public function get_categories(){
        $query=$this->db->table('product_category')->get();
        return $query->getResultArray();
    }
}