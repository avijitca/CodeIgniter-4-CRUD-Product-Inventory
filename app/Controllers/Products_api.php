<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Products_api extends ResourceController{
    protected $modelName = 'App\Models\Products_model';
    protected $format    = 'json'; // Response format (JSON)

    // Get all products
    public function index(){
        return $this->respond($this->model->findAll());
    }
    // Create a new product
    public function create(){
        $data = $this->request->getJSON();
        // print_r($this->request->getJSON()); exit;
        if ($this->model->insert($data)) {
            return $this->respondCreated($data, 'Product created');
        }
        return $this->failValidationErrors($this->model->errors());
    }


}