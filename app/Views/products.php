<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="col-sm-12">
    <?php if (session()->getFlashdata('success')){ ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
    <?php } ?>
    <br />
    <h4>List of all Products</h4>
    <div class="d-flex justify-content-end">
      <a href="<?= base_url('create-product') ?>" class="btn btn-dark">Add Product</a>
    </div>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Item</th>
          <th scope="col">Price</th>
          <th scope="col">Stock Status</th>
          <th scope="col">Created By</th>
          <th scope="col">Created at</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(!empty($products)){
            $i=1;
            foreach ($products as $pd){
        ?>
        <tr>
          <th scope="row"><?=  $i ?></th>
          <td><?=  $pd['product_name'] ?></td>
          <td>$ <?=  $pd['price'] ?></td>
          <td><?=  $pd['stock_status'] ?></td>
          <td><?=  $pd['user_name'] ?></td>
          <td><?=  $pd['created_at'] ?></td>
          <td>
          <a href="<?= base_url('update-product/').$pd['id'] ?>" class="btn btn-default btn-sm">
            <i class="bi bi-pencil"></i>
          </a>           
          |
          <a onClick="return confirm('Are you sure you want to delete this record?');"  href="<?= base_url('delete-product/').$pd['id'] ?>" class="btn btn-default btn-sm"><i class="bi bi-trash"></i></a></td>
        </tr>
        <?php
        $i++;   }}
        ?>
      </tbody>
    </table>
    <!-- Render pagination links -->
    <div class="pagination-links">
        <?= $pager ?>
    </div>
    <div class="d-flex justify-content-end">
      <a href="<?= base_url('products/pdf') ?>" class="btn btn-dark">Download PDF</a> 
      &nbsp;
      <a href="<?= base_url('products/excel') ?>" class="btn btn-dark">Download Excel</a>
    </div>
</div>
<?= $this->endSection() ?>