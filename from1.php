<?php
// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$login = $_POST['login'];
$password = $_POST['password'];
$telephone = $_POST['telephone'];
$idRole = $_POST['idRole'];
$dateAjout = $_POST['dateAjout'];
$dateModif = $_POST['dateModif'];

// echo $nom;
// echo $prenom;
// echo $login;
// echo $password;
// echo $telephone;
// echo $idRole;
// echo ' da ',$dateAjout;
// echo ' dm ',$dateModif;

// Hacher le mot de passe
// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Ici, vous devez insérer les données récupérées dans votre base de données
$servername = "localhost";
$username = "black";
$password = "black";
$dbname = "boutique";

// // Créer une connexion
 $conn = new mysqli($servername, $username, $password, $dbname);

// // Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// // Préparer et exécuter la requête SQL pour insérer les données
 $sql = "INSERT INTO user (nom, prenom, login, password, telephone, idRole, dateAjout, dateModif) VALUES ('$nom', '$prenom', '$login', '$password', '$telephone', '$idRole', '$dateAjout', '$dateModif')";

if ($conn->query($sql) === TRUE) {
    echo "La personne a été ajoutée avec succès !";
} else {
    echo "Erreur lors de l'ajout de la personne : " . $conn->error;
}

// // Fermer la connexion à la base de données
$conn->close();
?>
