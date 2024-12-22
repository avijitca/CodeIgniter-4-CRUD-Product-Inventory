<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url('public/css/style.css') ?>" rel="stylesheet">
    <!-- Optional Custom CSS -->
    <style>
        body {
            height: 40vh;
            /* Full viewport height */
        }
    </style>
</head>

<body class="bg-light">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-8 text-center">
            <h1 class="display-7">Product Inventory System</h1>
            <h4>Login</h4>
            <?php if (isset($validation)){ ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
    <?php } ?>
    <?php if (session()->getFlashdata('success')){ ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
    <?php } ?>
                <div class="col-sm-12">
                    <form name="crud_form" method="post" action="<?= base_url('login')  ?>">
                        
                        <table class="table">
                            <tr>
                                <td><b>User Name:</b></td>
                                <td>
                                    <input type="text" name="username" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td><b>Password:</b></td>
                                <td>
                                    <input type="password" name="password" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="submit" class="btn btn-dark form-control" /></td>
                            </tr>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>