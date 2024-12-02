<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="col-sm-12">
    <?php if (isset($validation)){ 
//     var_dump($validation);
        ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
    <?php } ?>
    <form name="crud_form" method="post" action="<?= base_url('create-product')  ?>">
        <h4>Add a new Product</h4>
    <table>
        <tr>
            <td><b>Item Name:</b></td>
            <td>
                <input type="text" name="name" class="form-control">
                
            </td>
        </tr>
        <tr>
            <td><b>Product Category:</b></td>
            <td>
                <select class="form-control" name="product_category_id">
                    <option value="">Choose</option>
                    <?php   
                        if(!empty($categories)){
                            foreach ($categories as $cat){
                    ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['item'] ?></option>
                    <?php }}  ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><b>Price:</b></td>
            <td>
                <input type="text" class="form-control" name="price">
            </td>
        </tr>
        <tr>
            <td><b>Stock Status:</b></td>
            <td>
                <select class="form-control" name="stock_status">
                    <option value="">Choose</option>
                    <option value="in_stock">Available</option>
                    <option value="outof_stock">Not Available</option>
                </select>
            </td>
        </tr>
        <tr><td></td><td><input type="submit" name="submit" class="btn btn-dark form-control" /></td></tr>
    </table>
    </form>
</div>




<?= $this->endSection() ?>