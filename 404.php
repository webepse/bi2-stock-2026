<?php
    // header toujours au dessus de DOCTYPE
    header("http/1.1 404 Not Found");
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <script src="assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/style.css">
    <title>BI2 - Stock - 404</title>
</head>
<body>
<?php
    include("partials/nav.php");
?>
    <div class="container">
        <div class="alert alert-danger mt-5">
            <h1>Page 404 - Cette page d'existe pas (ou plus)</h1>
            <p>Vous pouvez revenir au site via le lien suivant:</p>
        </div>
        <a href="index.php" class="btn btn-primary">Revenir au site</a>
    </div>
</body>
</html>