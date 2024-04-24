<?php
// Inclusion de l'autoloader de Faker
require_once __DIR__ . '/libs/Faker-master/src/autoload.php';

// Création d'une instance de Faker
$faker = Faker\Factory::create();

// Connexion à la base de données
$servername = "localhost";
$username = "black"; // Mettez votre nom d'utilisateur MySQL
$password = "black"; // Mettez votre mot de passe MySQL
$dbname = "pharmacie";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}


// Génération des données pour la table client

$clientData = [];

for ($i = 0; $i < 10; $i++) {
    $clientData[] = [
        'nomClient' => $faker->lastName,
        'villeClient' => $faker->city,
        'emailClient' => $faker->email,
        'telephoneClient' =>substr($faker->phoneNumber, 0, 10),
        'etat' => $faker->randomElement(['active']),
    ];
}


// Génération des données pour la table Fournisseur
// $fournisseurData = [];
// for ($i = 0; $i < 6; $i++) {
//     $fournisseurData[] = [
//         'nomFournis' => $faker->lastName,
//         'villeFournis' => $faker->city,
//         'emailFournis' => $faker->email,
//         'telephoneFournis' => substr($faker->phoneNumber, 0, 9),
//         'etat' => $faker->randomElement(['active']),
       
//     ];
// }


// Génération des données pour la table user
// $userData = [];
// for ($i = 0; $i < 10; $i++) {
//     $userData[] = [
//         'nomU' => $faker->lastName, 
//         'login' => $faker->userName,
//         'password'=> md5($faker->password),
//         'etat' => $faker->randomElement(['active']),
       
//     ];
// }


// Génération des données pour la table produit
// $produitData = [];
// for ($i = 0; $i < 1000; $i++) {
  
//     $produitData[] = [
//         'nomProd' => $faker->sentence(3),
//         'numLot' => $faker->numberBetween(1, 100),
//         'datePerem' => $faker->date('Y-m-d H:i:s'),
//         'qteDispo' => $faker->numberBetween(1, 100),
//         'prixU' => $faker->numberBetween(10, 1000),
//         'idFournis' => $faker->numberBetween(1, 6), // Assurez-vous que ces valeurs correspondent aux IDs réels dans votre base de données
//         'idCategorie' => $faker->numberBetween(1, 6), // Assurez-vous que ces valeurs correspondent aux IDs réels dans votre base de données
//         'etat' => $faker->randomElement(['active']),
//         'imageProd' => $faker->imageUrl(200, 200),

        
//     ];
// }

// Génération des données pour la table ventes
// $venteData = [];
// for ($i = 0; $i < 100; $i++) {
  
//     $venteData[] = [
        
//         'dateVente' => $faker->date('Y-m-d H:i:s'),
//         'qteVente' => $faker->numberBetween(1, 100),
//         'prixT' => $faker->numberBetween(147, 100000),
//         'idProd' => $faker->numberBetween(1, 1000), // Assurez-vous que ces valeurs correspondent aux IDs réels dans votre base de données
//         'idClient' => $faker->numberBetween(1, 10), // Assurez-vous que ces valeurs correspondent aux IDs réels dans votre base de données
//         'etat' => $faker->randomElement(['active']),
        
//     ];
// }


// Génération des données pour la table facture
// $factureData = [];
// for ($i = 0; $i < 100; $i++) {
  
//     $factureData[] = [
        
//         'dateFact' => $faker->date('Y-m-d H:i:s'),
//         'montantT' => $faker->numberBetween(147, 100000),
//         'idVente' => $faker->numberBetween(1, 100), // Assurez-vous que ces valeurs correspondent aux IDs réels dans votre base de données
//         'etat' => $faker->randomElement(['active']),
        
        
//     ];
// }


// Préparation et exécution des requêtes d'insertion pour la table client
foreach ($clientData as $data) {
    // Préparation de la requête d'insertion avec des requêtes préparées
    $sql = "INSERT INTO client(nomClient, villeClient, emailClient, telephoneClient, etat) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $data['nomClient'], $data['villeClient'], $data['emailClient'], $data['telephoneClient'], $data['etat']);

    // Exécution de la requête préparée
    if ($stmt->execute() !== TRUE) {
        echo "Erreur lors de l'insertion des données dans la table client : " . $stmt->error;
    }

    // Fermeture du statement
    $stmt->close();
}


// Préparation et exécution des requêtes d'insertion pour la table fournisseur
// foreach ($fournisseurData as $data) {
//     $sql = "INSERT INTO fournisseur( nomFournis, villeFournis,emailFournis, telephoneFournis,etat) VALUES ('" . $data['nomFournis'] . "','" . $data['villeFournis'] . "','" . $data['emailFournis'] . "','" . $data['telephoneFournis'] . "','" . $data['etat'] . "')";

//     if ($conn->query($sql) !== TRUE) {
//         echo "Erreur lors de l'insertion des données dans la table fournisseur : " . $conn->error;
//     }
// }

// Préparation et exécution des requêtes d'insertion pour la table user
// foreach ($userData as $data) {
//     $sql = "INSERT INTO user( nomU, login, password,etat) VALUES ('" . $data['nomU'] . "','" . $data['login'] . "','" . $data['password'] . "','" . $data['etat'] . "')";

//     if ($conn->query($sql) !== TRUE) {
//         echo "Erreur lors de l'insertion des données dans la table user : " . $conn->error;
//     }
// }

// Préparation et exécution des requêtes d'insertion pour la table produit
// foreach ($produitData as $data) {
//     $sql = "INSERT INTO produit(nomProd, numLot, datePerem, qteDispo, prixU, idFournis, idCategorie,etat,imageProd) VALUES ('" . $data['nomProd'] . "','" . $data['numLot'] . "','" . $data['datePerem'] . "','" . $data['qteDispo'] . "','" . $data['prixU'] . "','" . $data['idFournis'] . "','" . $data['idCategorie'] . "','" . $data['etat'] . "','" . $data['imageProd'] . "')";

//     if ($conn->query($sql) !== TRUE) {
//         echo "Erreur lors de l'insertion des données dans la table produit : " . $conn->error;
//     }
// }


// Préparation et exécution des requêtes d'insertion pour la table vente
// foreach ($venteData as $data) {
//     $sql = "INSERT INTO ventes( dateVente, qteVente, prixT, idProd, idClient,etat) VALUES ('" . $data['dateVente'] . "','" . $data['qteVente'] . "','" . $data['prixT'] . "','" . $data['idProd'] . "','" . $data['idClient'] . "','" . $data['etat'] . "')";

//     if ($conn->query($sql) !== TRUE) {
//         echo "Erreur lors de l'insertion des données dans la table vente : " . $conn->error;
//     }
// }

// Préparation et exécution des requêtes d'insertion pour la table facture
// foreach ($factureData as $data) {
//     $sql = "INSERT INTO facture( dateFact, montantT, idVente,etat) VALUES ('" . $data['dateFact'] . "','" . $data['montantT'] . "','" . $data['idVente'] . "','" . $data['etat'] . "')";

//     if ($conn->query($sql) !== TRUE) {
//         echo "Erreur lors de l'insertion des données dans la table facture : " . $conn->error;
//     }
// }



echo "Les données ont été insérées avec succès !";

// Fermeture de la connexion
$conn->close();
?>
