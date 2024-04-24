<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  header("Location: login.php");
  exit;
}

// Obtenez les informations de l'utilisateur connecté
$username = $_SESSION["username"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <style>
       
        body {
            background-color: #f8f9fa; /* Couleur de fond légèrement grise */
        }

        .title-container {
            text-align: center;
            padding: 280px 0;
        }

        .title-container h1 {
            font-size: 3rem; /* Taille de la police plus grande */
            color: #007bff; /* Couleur bleue */
            font-weight: bold; /* Gras */
            text-transform: uppercase; /* Convertir en majuscules */
        }
    </style>
</head>
<body>
            <?php
            include('nav.php');
            ?>

            <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="title-container">
                <h1>Travail de la Semaine 2</h1>
            </div>
        </div>
    </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>



