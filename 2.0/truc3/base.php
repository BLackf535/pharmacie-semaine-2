<?php
// Connexion à la base de données (à adapter selon votre configuration)
$servername = "localhost";
$username = "black";
$password = "black";
$dbname = "boutique";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Exemple de requête pour récupérer les données de la base de données (à adapter selon votre schéma de base de données)
$sql = "SELECT * FROM user";

$result = $conn->query($sql);

// Génération du PDF
require('jspdf.debug.js');

// Création du document PDF
$doc = new \JsPDF();
$y = 10; // Position verticale initiale

// Boucle sur les données de la base de données
while ($row = $result->fetch_assoc()) {
    $data = $row['nom']; // Remplacez 'nom_colonne' par le nom de votre colonne contenant les données

    // Ajout des données dans le document PDF
    $doc->text($data, 10, $y);
    $y += 10; // Incrémentation de la position verticale
}

// Enregistrement du fichier PDF
$filename = 'exemple.pdf';
$doc->save($filename);

// Fermeture de la connexion à la base de données
$conn->close();

// Réponse au client avec le nom du fichier PDF généré
echo $filename;
?>