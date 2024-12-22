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
    <form name="crud_form" method="post" action="<?= base_url('update-user/'.$user['id'])  ?>">
        <h4>Update a User</h4>
    <table class="table">
        <tr>
            <td><b>Name:</b></td>
            <td>
                <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>">
                
            </td>
        </tr>
        <tr>
            <td><b>User Name:</b></td>
            <td>
                <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>">
                
            </td>
        </tr>
        <tr>
            <td><b>Role:</b></td>
            <td>
                <select class="form-control" name="role">
                    <option value="">Choose</option>
                    <?php
                        if(!empty($roles)){
                            foreach($roles as $role){
                    ?>
                    <option <?php if($role['role']==$user['role']){echo 'selected="selected"';}else{echo '';} ?> value="<?= $role['role'] ?>"><?=  $role['role_title']  ?></option>
                    <?php }}  ?>
                </select>                
            </td>
        </tr>        
        <tr><td></td><td><input type="submit" name="submit" class="btn btn-dark form-control" /></td></tr>
    </table>
    </form>
</div>


<?= $this->endSection() ?>