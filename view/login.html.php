<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Connexion
    </title>
    <link rel="shortcut icon" href="/img/logo-site.png">
    <link rel="stylesheet" href="/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/bootstrap-icons.css" />
    <link rel="stylesheet" href="/css/new.css" />
    <style>
        * {
            font-size: 102.5%;
        }
    </style>
</head>

<body class="text-center p-0">
    <div class="container form-signin w-100">
        <div class="row">
            <div class="m-auto pt-3 col-10 col-lg-6 col-xl-4">
                <img src="/img/logo-site.png" alt="Logo" class="pb-2">
                <?php if (isset($msg)): ?>
                    <div class="text-<?= $msg['type'] ?> fs-4 text-center mb-4">
                        <?= $msg['value'] ?>
                    </div>
                <?php else: ?>
                    <div class="fs-4 text-info text-center mb-4">
                        Veuillez vous connecter
                    </div>
                <?php endif ?>
                <?php include 'parts/forms/loginform.html.php' ?>
            </div>
        </div>
    </div>

    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap-bundle.js"></script>
</body>

</html>
