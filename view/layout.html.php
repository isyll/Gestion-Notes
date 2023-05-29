<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? '' ?>
    </title>
    <link rel="shortcut icon" href="/img/logo-site.png">
    <link rel="stylesheet" href="/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/bootstrap-icons.css" />
    <link rel="stylesheet" href="/css/prism-okaidia.css" />
    <link rel="stylesheet" href="/css/custom.css" />
    <style>
        * {
            font-size: 102.5%;
        }
    </style>
</head>

<body class="text-center">
    <?= $content; ?>
    <script id='datas' type="application/json">
        <?= json_encode(Core\Router::getAPIRoutes()); ?>
    </script>
    <script>
        const data = JSON.parse(document.getElementById("datas").textContent);

        const baseURL = '<?= Core\Helpers::getBaseURL(); ?>';

    </script>

    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap-bundle.js"></script>
    <script src="/js/prism.js"></script>
    <script src="/js/custom.js"></script>
</body>

</html>
