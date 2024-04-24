
<?php
include 'connet.php';

// Vérifier si la variable $_GET['date'] est définie
if(isset($_GET['date']) && isset($_GET['choix'])) {
    // Récupérer la date envoyée
    $date = $_GET['date'];
    $date2 = $_GET['date2'];
    $choix = $_GET['choix'];

    // Préparer la requête SQL avec une déclaration préparée pour éviter les injections SQL
    $sql = "SELECT *
    FROM produit
    WHERE DATE(dateAjout) BETWEEN ? AND ?
    AND etat = ?";
    $stmt = $conn->prepare($sql);

    // Lier les paramètres
    $stmt->bind_param("sss", $date,$date2,$choix);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer le résultat de la requête
    $result = $stmt->get_result();

    // Créer un tableau pour stocker les données
    $data = array();

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        // Boucler à travers les résultats et les stocker dans le tableau
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Fermer la déclaration
    $stmt->close();
} else {
    // Si la variable $_GET['date'] n'est pas définie, renvoyer un message d'erreur
    $data = array("error" => "La date n'est pas spécifiée");
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner les données au format JSON
echo json_encode($data);
?>
