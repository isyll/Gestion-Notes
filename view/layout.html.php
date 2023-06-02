<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? '' ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital@0;1&family=Roboto&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/img/logo-site.png">
    <link rel="stylesheet" href="/css/new.css" />
    <link rel="stylesheet" href="/css/bootstrap-icons.css" />
    <link rel="stylesheet" href="/css/custom.css" />
    <style>
        * {
            font-family: 'Roboto', Calibri, sans-serif;
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
    <script src="/js/script.js"></script>
    <script>
    // Activer les popovers de Bootstrap
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    });

    // Activer les tooltips de Bootstrap
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
<?= $scriptTags ?? '' ?>
</body>

</html>
