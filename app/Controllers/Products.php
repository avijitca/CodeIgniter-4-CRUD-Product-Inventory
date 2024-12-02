<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;
use App\Models\Products_model;

class Products extends BaseController{
    public function __construct() {
        
    }
    public function index(){
        $product_model=new Products_model();
        $data=$product_model->db->table('products pd')
                ->select('pd.id,pd.name product_name,pd.price,pd.stock_status,pd.created_at,pc.item,us.name user_name')
                ->join('product_category pc','pd.product_category_id=pc.id','left')
                ->join('users us','pd.created_by=us.id','left')
                ->orderBy('pd.id','ASC')
                ->get()
                ->getResultArray();
//        print_r($data);
        return view('products',['title'=>'Product List','products'=>$data]);
    }
    
    public function create_product(){
        $product_model=new Products_model();
        $categories=$product_model->get_categories();
        
        $validation = \Config\Services::validation();
         // Define validation rules
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'product_category_id' => 'required|integer',
            'price' => 'required|decimal',
            'stock_status' => 'required|in_list[in_stock,outof_stock]',
        ];
        // Check if input is valid
         $isPosted = $this->request->is('post');
        if ($isPosted && !$this->validate($rules)) {
            // Load the same view with errors and old input
            return view('create_product', [
                'validation' => $this->validator,
                'old_input' => $this->request->getPost(),
                'title'=>'Create New Product',
                'categories'=>$categories
            ]);
        }
            
        
        if($isPosted){
            $data = [
                'name' => $this->request->getPost('name'),
                'product_category_id' => $this->request->getPost('product_category_id'),
                'price' => $this->request->getPost('price'),
                'stock_status' => $this->request->getPost('stock_status'),
                'created_by' => '1'
            ];
//            print_r($data);exit;
            $product_model->insert($data);
            return redirect()->to('/product-list')->with('success','Product added successfully.');
        }
        
//        print_r($categories);exit;
        return view('create_product',['title'=>'Create New Product','categories'=>$categories]);
    }
    public function update_product($id=NULL){
        $product_model= new Products_model();
        $categories=$product_model->get_categories();
        $product=$product_model->find($id);
        
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product with ID $id not found.");
        }
//        print_r($product);

        $validation = \Config\Services::validation();
         // Define validation rules
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'product_category_id' => 'required|integer',
            'price' => 'required|decimal',
            'stock_status' => 'required|in_list[in_stock,outof_stock]',
        ];
        // Check if input is valid
         $isPosted = $this->request->is('post');
        if ($isPosted && !$this->validate($rules)) {
            // Load the same view with errors and old input
            return view('create_product', [
                'validation' => $this->validator,
                'title'=>'Create New Product',
                'categories'=>$categories
            ]);
        }
        
        if($isPosted){
            $data = [
                'name' => $this->request->getPost('name'),
                'product_category_id' => $this->request->getPost('product_category_id'),
                'price' => $this->request->getPost('price'),
                'stock_status' => $this->request->getPost('stock_status'),
                'created_by' => '1'
            ];
//        print_r($data); exit;
            $product_model->update($id,$data);
            return redirect()->to('/product-list')->with('success','Product updated successfully.');
        }
        
        
        
        return view('update_product',['title'=>'Update Product','categories'=>$categories,'product'=>$product]);
    }
    
    public function delete_product($id=NULL){
        $product_model=new Products_model();
        $product=$product_model->find($id);

        if (!$product) {
            return redirect()->to('/product-list')->with('error',"Product ID: $id not found. Try again.");
        }
        if($product_model->delete($id)){
            return redirect()->to('/product-list')->with('success',"Product deleted successfully.");
        }else{
            return redirect()->to('/product-list')->with('error',"Failed to delete the product.");
        }
        
    }
}