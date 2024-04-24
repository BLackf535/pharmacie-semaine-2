<?php
// Vérifier si la requête est faite en utilisant AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // La requête est faite en utilisant AJAX

    // Récupérer l'ID du produit depuis la requête AJAX
    $id = $_POST['id'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "black"; // Remplacez par votre nom d'utilisateur MySQL
    $password = "black"; // Remplacez par votre mot de passe MySQL
    $dbname = "boutique"; // Remplacez par le nom de votre base de données

    // Création d'une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier les erreurs de connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données: " . $conn->connect_error);
    }

    // Préparer la requête SQL pour récupérer les informations du produit
    $stmt = $conn->prepare("SELECT * FROM produit WHERE idProd = ?");
    $stmt->bind_param("i", $id); // "i" indique que l'ID est un entier
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si le produit existe
    if ($result->num_rows === 1) {
        // Récupérer les données du produit sous forme de tableau associatif
        $productData = $result->fetch_assoc();

        // Convertir le tableau associatif en JSON et le renvoyer
        echo json_encode($productData);
    } else {
        // Si le produit n'existe pas, renvoyer une réponse JSON vide
        echo json_encode([]);
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
    exit; // Arrêter l'exécution du script après avoir renvoyé la réponse JSON
} else {
    // Si la requête n'est pas faite en utilisant AJAX, afficher un message d'erreur
    echo "Erreur : cette page ne peut être accédée directement.";
}
?>
