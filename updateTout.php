<?php
// Récupérer les données envoyées par la requête AJAX
$id = $_POST['id'];
$codeProd = $_POST['codeProd'];
$nomProd = $_POST['nomProd'];
$description = $_POST['description'];
$poid = $_POST['poid'];
$prixU = $_POST['prixU'];
$prixV = $_POST['prixV'];
$dateAjout = $_POST['dateAjout'];
$dateModif = $_POST['dateModif'];
// Récupérer les autres champs du formulaire ici

// Connexion à la base de données
$servername = "localhost";
$username = "black";
$password = "black";
$dbname = "boutique";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Préparer et exécuter la requête SQL pour mettre à jour les données du produit
$sql = "UPDATE produit SET codeProd=?, nomProd=?,description=?,poid=?,prixU=?,prixV=?,dateAjout=?,dateModif=? WHERE idProd=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssi", $codeProd, $nomProd,$description,$poid ,$prixU ,$prixV,$dateAjout,$dateModif, $id);

if ($stmt->execute()) {
    // Les informations du produit ont été mises à jour avec succès
    echo 'Les informations du produit ont été mises à jour avec succès !';
} else {
    // Une erreur s'est produite lors de la mise à jour des informations du produit
    echo 'Erreur lors de la mise à jour des informations du produit: ' . $conn->error;
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>
