<?php
namespace App\Controllers;
// require_once APPPATH . 'Libraries/mpdfloader.php';
require_once ROOTPATH . 'vendor/autoload.php';

// use Mpdf\Mpdf;

use App\Models\Products_model;


class Products extends BaseController{
    public function index(){
        $product_model = new Products_model();
        $db = $product_model->db;

        // Number of records per page
        $perPage = 5;

        // Get the current page number (default is 1)
        $currentPage = $this->request->getVar('page') ?? 1;

        // Calculate the offset for the query
        $offset = ($currentPage - 1) * $perPage;

        // Fetch paginated data
        $data['products'] = $db->table('products pd')
            ->select('pd.id,pd.name product_name,pd.price,pd.stock_status,pd.created_at,pc.item,us.name user_name')
            ->join('product_category pc', 'pd.product_category_id = pc.id', 'left')
            ->join('users us', 'pd.created_by = us.id', 'left')
            ->orderBy('pd.id', 'ASC')
            ->limit($perPage, $offset) // Limit and offset for pagination
            ->get()
            ->getResultArray();

        // Fetch total record count for pagination
        $total = $db->table('products pd')
            ->join('product_category pc', 'pd.product_category_id = pc.id', 'left')
            ->join('users us', 'pd.created_by = us.id', 'left')
            ->countAllResults();

        // Use the Pager service
        $pager = \Config\Services::pager();

        // Pass products, pager links, and other data to the view
        return view('products', [
            'title'    => 'Product List',
            'products' => $data['products'],
            'pager'    => $pager->makeLinks($currentPage, $perPage, $total, 'default_full'), // Use custom pagination template
        ]);
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
    public function bulk_add(){
         // Load Product Model
         $product_model = new Products_model();

         if ($this->request->is('post')) {
            $file = $this->request->getFile('csv_file');
             // Check if file exists and is valid
            if (!$file->isValid()) {
                return redirect()->back()->with('error', 'Invalid file selected');
            }
            
            // Define allowed file types
            $allowedMimes = ['text/csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

            // Validate file type
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return redirect()->back()->with('error', 'Only CSV or Excel files are allowed');
            }

            // Move uploaded file to a temporary directory
            $filePath = WRITEPATH . 'uploads/' . $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $filePath);

            // Determine file type and parse accordingly
            if ($file->getExtension() === 'csv') {
                $fileData = $this->parseCSV($filePath);
            } else {
                $fileData = $this->parseExcel($filePath);
            }

print_r($fileData); exit;

            // Process and insert into database
            if (!empty($fileData)) {
                foreach ($fileData as $row) {
                    $data = [
                        'name' => $row['name'] ?? '',
                        'product_category_id' => $row['product_category_id'] ?? 0,
                        'price' => $row['price'] ?? 0,
                        'stock_status' => $row['stock_status'] ?? 'In Stock',
                        'created_by' => 1, // Hardcoded user ID; modify as needed
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $product_model->insert($data);
                }

                return redirect()->back()->with('success', 'Products imported successfully!');
            } else {
                return redirect()->back()->with('error', 'No valid data found in file');
            }
        }else{
            return view('bulk_add',['title'=>'Add Bulk Products']);
        }
     }
 
     // Function to parse CSV files
     private function parseCSV($filePath){
         $csvData = [];
         if (($handle = fopen($filePath, 'r')) !== false) {
             $header = fgetcsv($handle); // Get the header row
 
             while (($row = fgetcsv($handle)) !== false) {
                 $csvData[] = array_combine($header, $row);
             }
 
             fclose($handle);
         }
         return $csvData;
     }
 
     // Function to parse Excel files
     private function parseExcel($filePath){
         $spreadsheet = IOFactory::load($filePath);
         $worksheet = $spreadsheet->getActiveSheet();
         $rows = $worksheet->toArray();
 
         // Extract header
         $header = array_shift($rows);
         $excelData = [];
 
         foreach ($rows as $row) {
             $excelData[] = array_combine($header, $row);
         }
 
         return $excelData;
     }

     // download product list in pdf format
     public function downloadPdf(){
        $product_model = new Products_model();
        $products = $product_model->findAll();
        // Load MPDF
        $mpdf = new \Mpdf\Mpdf();

        // Build HTML content
        $html = '<h1>Product List</h1>';
        $html .= '<table border="1" width="100%" cellpadding="5">';
        $html .= '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock Status</th>
                    </tr>
                </thead>';
        $html .= '<tbody>';
        foreach ($products as $product) {
            $html .= '<tr>
                        <td>' . $product['id'] . '</td>
                        <td>' . $product['name'] . '</td>
                        <td>' . $product['product_category_id'] . '</td>
                        <td>' . $product['price'] . '</td>
                        <td>' . $product['stock_status'] . '</td>
                    </tr>';
        }
        $html .= '</tbody></table>';

        // Write content to the PDF
        $mpdf->WriteHTML($html);
        $mpdf->Output('ProductList.pdf', 'D'); 
    }
    public function downloadExcel(){
        $product_model = new Products_model();
        $products = $product_model->findAll();

        // Load PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Category');
        $sheet->setCellValue('D1', 'Price');
        $sheet->setCellValue('E1', 'Stock Status');

        // Fill data
        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product['id']);
            $sheet->setCellValue('B' . $row, $product['name']);
            $sheet->setCellValue('C' . $row, $product['product_category_id']);
            $sheet->setCellValue('D' . $row, $product['price']);
            $sheet->setCellValue('E' . $row, $product['stock_status']);
            $row++;
        }

        // Save the file to a temporary location
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $tempFile = WRITEPATH . 'uploads/products.xlsx';
        $writer->save($tempFile);

        // Send the file as response
        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="products.xlsx"')
            ->setBody(file_get_contents($tempFile));
    }

}