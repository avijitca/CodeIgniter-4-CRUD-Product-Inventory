<?php
namespace App\Controllers;
use App\Models\Users_model;


class Users extends BaseController{
    public function __construct(){
        $users_model=new Users_model();

    }
    public function index(){
        $users_model= new Users_model();
         // Pagination configuration
        $perPage = 3;  // Define the number of results per page
        $currentPage = $this->request->getVar('page') ?? 1; // Get current page from URL, default to 1

        $users = $users_model->orderBy('id', 'ASC')->paginate($perPage, 'default', $currentPage);
    
        // Pass the pager object and users data to the view
        return view('users/index', [
            'title' => 'Users List',
            'users' => $users,
            'pager' => $users_model->pager  // Pass pager object to the view for pagination
        ]);
    }
    public function login(){
        $validation = \Config\Services::validation();
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $isPosted = $this->request->is('post');
        if ($isPosted && !$this->validate($rules)) {
            return view('users/login', [
                'validation' => $this->validator,
                'title'=>'Login'
            ]);
        }

        if($isPosted){
            $username=$this->request->getPost('username');
            $password=md5($this->request->getPost('password'));

            $users_model=new Users_model();
            $user=$users_model->get_user($username,$password);
            if(!empty($user)){
                $session_data=[
                    'name'=>$user['name'],
                    'username'=>$user['username'],
                    'role'=>$user['role'],
                    'role_title'=>$user['role_title']
                ];
                $this->session->set($session_data);
                $name = $this->session->get('name');
                
                return redirect()->to('/product-list')->with('success','Welcome to Inventory System '.$name.'!');
            }else{
                return redirect()->to('/login')->with('error','Invalid Username or Password.');
            }

        }else{
            return view('users/login',['title'=>'Login']);
        }
    }

    public function logout(){
        $this->session->remove(['name','username','role','role_title']);
        return redirect()->to('/login')->with('success','You have successfully logged out!');
    }

    public function add_user(){
        $users_model=new Users_model();
        $roles=$users_model->get_roles();

        $validation = \Config\Services::validation();
         // Define validation rules
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'username' => 'required|min_length[3]|max_length[255]',
            'password' => 'required|min_length[4]|max_length[255]',
            'role' => 'required|in_list[super_admin,admin,manager,viewer]',
        ];

        // Check if input is valid
        $isPosted = $this->request->is('post');
        if ($isPosted && !$this->validate($rules)) {
            // Load the same view with errors and old input
            return view('users/add_user', [
                'validation' => $this->validator,
                'title'=>'Add New User',
                'roles'=>$roles
            ]);            
        }

        if($isPosted){
            $data=[
                'name'=>$this->request->getPost('name'),
                'username'=>$this->request->getPost('username'),
                'password'=>md5($this->request->getPost('password')),
                'role'=>$this->request->getPost('role')
            ];
            $users_model->insert($data);
            return redirect()->to('/all-users')->with('success','User has been added successfully.');
        }else{
            return view('users/add_user',['title'=>'Add New User','roles'=>$roles]);
        }
    }
    public function update_user($id=null){
        $users_model=new Users_model();
        $roles=$users_model->get_roles();
        $user=$users_model->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User with ID $id not found.");
        }

        $validation = \Config\Services::validation();
         // Define validation rules
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'username' => 'required|min_length[3]|max_length[255]',
            'role' => 'required|in_list[super_admin,admin,manager,viewer]'
        ];

        // Check if input is valid
        $isPosted = $this->request->is('post');
        if ($isPosted && !$this->validate($rules)) {
            // Load the same view with errors and old input
            return view('users/add_user', [
                'validation' => $this->validator,
                'title'=>'Add New User',
                'roles'=>$roles
            ]);            
        }
        if($isPosted){
            $data=[
                'name'=>$this->request->getPost('name'),
                'username'=>$this->request->getPost('username'),
                'role'=>$this->request->getPost('role')
            ];
            $users_model->update($id,$data);
            return redirect()->to('/all-users')->with('success','User has been updated successfully.');
        }else{
            return view('users/update_user',['title'=>'Update User','roles'=>$roles,'user'=>$user]);
        }
    }
    public function delete_user($id=NULL){
        $users_model=new Users_model();
        $user=$users_model->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User with ID $id not found.");
        }
        if($users_model->delete($id)){
            return redirect()->to('/all-users')->with('success',"User deleted successfully.");
        }else{
            return redirect()->to('/all-users')->with('error',"Failed to delete the user.");
        }
        
    }



}

