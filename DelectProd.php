<?php
// Récupérer l'ID du produit à supprimer
$id = $_POST['id'];

// Effectuer la logique de suppression du produit dans la base de données
// Exemple : supprimer le produit avec l'ID spécifié
// Assurez-vous d'adapter cette logique en fonction de votre structure de base de données
$dbHost = 'localhost';
$dbUser = 'black';
$dbPass = 'black';
$dbName = 'boutique';

// Connexion à la base de données
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die('Erreur de connexion à la base de données : ' . $conn->connect_error);
}

// Suppression du produit
$query = "DELETE FROM produit WHERE idProd = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    // Répondre avec un message de succès
    echo json_encode(['success' => true, 'message' => 'Produit supprimé avec succès.']);
} else {
    // Répondre avec un message d'erreur
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du produit.']);
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>