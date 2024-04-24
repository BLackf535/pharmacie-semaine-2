
<?php
// Connexion à la base de données
$servername = "localhost";
$username = "black";
$password = "black";
$dbname = "boutique";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
?>
