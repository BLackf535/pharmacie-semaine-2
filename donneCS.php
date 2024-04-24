<?php
$servername = "localhost";
$username = "black";
$password = "black";
$dbname = "boutique";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Requête SQL pour récupérer les données
$sql = "SELECT * FROM produit WHERE etat = 'active'";
$result = $conn->query($sql);

// Tableau pour stocker les données
$data = array();

// Parcourir les résultats de la requête et les stocker dans le tableau
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['id'] = $row['idProd']; // Utiliser 'idProd' comme 'id'
        $data[] = $row;
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Envoyer les données au format JSON
echo json_encode($data);
?>
