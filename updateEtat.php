<?php
$id = $_POST['id'];

// Connexion à la base de données
$dbHost = 'localhost';
$dbUser = 'black';
$dbPass = 'black';
$dbName = 'boutique';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die('Erreur de connexion à la base de données : ' . $conn->connect_error);
}

// Mettre à jour le champ 'etat' de la table avec la valeur 'supprimer'
$query = "UPDATE produit SET etat = 'suprimer' WHERE idProd = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    echo "Champ mis à jour avec succès.";
} else {
    echo "Erreur lors de la mise à jour du champ : " . $stmt->error;
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>