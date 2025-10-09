<?php
    session_start();

    if(isset($_SESSION['login']))
    {
        header("LOCATION:dashboard.php");
        exit();
    }

    // test
    if(isset($_POST['login']) && isset($_POST['password']))
    {
        if(empty($_POST['login']) || empty($_POST['password']))
        {
            $error = "Veuillez remplir le formulaire correctement";
        }else{
            $login = htmlspecialchars($_POST['login']);
            require '../config/connexion.php';
            // req à la base de données
            $req = $bdd->prepare("SELECT * FROM admin WHERE login = ?");
            $req->execute([$login]);
            $don = $req->fetch();
            // tester le login
            if($don)
            {
                // traitement du mot passe
                if(password_verify($_POST['password'],$don['password']))
                {
                    // création d'une variable de session
                    $_SESSION['login'] = $login;
                    // redirection vers le tableau de bord
                    header("LOCATION:dashboard.php");
                    // pour indiquer au code d'arrêter sinon il continue pour rien 
                    exit();
                }else{
                    $error = "Le mot de passe ne correspond pas";
                }
            }else{
                $error = "Le Login n'est pas reconnu";
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Session</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <h1>Connexion</h1>
                <form action="index.php" method="POST">
                    <?php
                        if(isset($error))
                        {
                            echo '<div class="alert alert-danger">'.$error.'</div>';
                        }
                    ?>
                    <div class="form-group my-3">
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" class="form-control">
                    </div>
                    <div class="form-group my-3">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group my-3">
                        <input type="submit" value="Connexion" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>