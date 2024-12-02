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
            height: 40vh; /* Full viewport height */
        }
    </style>
</head>
<body class="bg-light">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-8 text-center">
                <a style="text-decoration: none;" href="<?= base_url('product-list') ?>">
                <h1 class="display-7">CodeIgniter 4 CRUD Project</h1>
                </a>
                <p class="lead">This page shows list of products.</p>
                
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

<!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>