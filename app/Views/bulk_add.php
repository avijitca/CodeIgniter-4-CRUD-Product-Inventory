<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="col-sm-12">
    <?php if (session()->getFlashdata('success')){ ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php } ?>
    <?php if (isset($validation)){      ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
    <?php } ?>
    <form name="crud_form" method="post" action="<?= base_url('bulk-add')  ?>" enctype="multipart/form-data">
        <h4>Add Bulk Products</h4>
        <br />
    <table class="table">
        <tr>
            <td><b>Upload file:</b></td>
            <td>
                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv, .xlsx">
            </td>
        </tr>
        <tr><td></td><td><input type="submit" name="submit" class="btn btn-dark form-control" /></td></tr>
    </table>
    </form>
</div>

<?= $this->endSection() ?>