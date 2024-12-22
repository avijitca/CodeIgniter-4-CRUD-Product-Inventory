<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="col-sm-12">
    <?php if (session()->getFlashdata('success')){ ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
    <?php } ?>
    <br />
    <h4>List of all Users</h4>
    <div class="d-flex justify-content-end">
      <a href="<?= base_url('add-user') ?>" class="btn btn-dark">Add User</a>
    </div>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Full Name</th>
          <th scope="col">User Name</th>
          <th scope="col">Role</th>
          <th scope="col">Created at</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(!empty($users)){
            $i=1;
            foreach ($users as $user){
        ?>
        <tr>
          <th scope="row"><?=  $i ?></th>
          <td><?=  $user['name'] ?></td>
          <td><?=  $user['username'] ?></td>
          <td><?=  $user['role'] ?></td>
          <td><?=  $user['created_at'] ?></td>
          <td>
          <a href="<?= base_url('update-user/').$user['id'] ?>" class="btn btn-default btn-sm">
            <i class="bi bi-pencil"></i>
          </a>           
          |
          <a onClick="return confirm('Are you sure you want to delete this record?');"  href="<?= base_url('delete-user/').$user['id'] ?>" class="btn btn-default btn-sm"><i class="bi bi-trash"></i></a>
        </td>
        </tr>
        <?php
        $i++;   }}
        ?>
      </tbody>
    </table>

<!-- Display Pagination Links -->
<div class="pagination-links">
    <nav aria-label="Page navigation">
        <?= $pager->links('default', 'default_full') ?>
    </nav>
</div>

</div>
<?= $this->endSection() ?>