<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Page non trouvée
    </title>
    <link rel="shortcut icon" href="/img/logo-site.png">
    <link rel="stylesheet" href="/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/new.css" />
    <link rel="stylesheet" href="/css/custom.css" />
    <style>
        * {
            font-family: "Segoe UI", Roboto, "Helvetica Neue", sans-serif, "Segoe UI Emoji", "Segoe UI Symbol";
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center w-100" style="height: 60vh;">

    <div class="w-50 p-3 text-center">
        <h1 style="font-size: 6rem;">404</h1>
        <div class="fs-4 text-center">La page que vous avez demandée n'existe pas</div>
        <div class="text-center mt-4 fs-5"><a href="<?= $urls['baseURL'] ?>">Revenir à la page d'accueil</a></div>
    </div>
</body>

</html>
