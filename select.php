<?php
// Connexion à la base de données (vous devez configurer ces informations)
$host = 'localhost';
$dbname = 'boutique';
$username = 'black';
$password = 'black';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Requête pour récupérer les éléments du menu depuis la base de données
    $query = "SELECT idU, nom FROM user";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $elements = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convertir les éléments en format JSON
    echo json_encode($elements);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>
