<?php
// Inclusion de l'autoloader de Faker
require_once __DIR__ . '/libs/Faker-master/src/autoload.php';

// Création d'une instance de Faker
$faker = Faker\Factory::create();

// Connexion à la base de données
$servername = "localhost";
$username = "black"; // Mettez votre nom d'utilisateur MySQL
$password = "black"; // Mettez votre mot de passe MySQL
$dbname = "boutique";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Génération des données pour la table user
$userData = [];
for ($i = 0; $i < 10; $i++) {
    $userData[] = [
        'nom' => $faker->lastName,
        'prenom' => $faker->firstName,
        'login' => $faker->userName,
        'password' => password_hash($faker->password, PASSWORD_DEFAULT),
        'telephone' => substr($faker->phoneNumber, 0, 10),
        'idRole' => $faker->numberBetween(1, 3),
        'dateAjout' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'dateModif' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
    ];
}

// Génération des données pour la table produit
$produitData = [];
for ($i = 0; $i < 1000; $i++) {
    $etat = $faker->randomElement(['active', 'suprimer']); // Choix aléatoire entre 'active' et 'suprimer'
    $produitData[] = [
        'codeProd' => $faker->ean13,
        'nomProd' => $faker->sentence(3),
        'description' => $faker->paragraph,
        'image' => $faker->imageUrl(200, 200),
        'poid' => $faker->randomFloat(2, 0.1, 1000),
        'prixU' => $faker->numberBetween(10, 1000),
        'prixV' => $faker->numberBetween(11, 1001),
        'dateAjout' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'dateModif' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'etat' => $etat, // Ajout du champ 'etat' avec la valeur générée aléatoirement
        'idU' => $faker->numberBetween(1, 10), // Assurez-vous que ces valeurs correspondent aux IDs réels dans votre base de données
        
    ];
}


// Préparation et exécution des requêtes d'insertion pour la table user
foreach ($userData as $data) {
    $sql = "INSERT INTO user (nom, prenom, login, password, telephone, idRole, dateAjout, dateModif) VALUES ('" . $data['nom'] . "', '" . $data['prenom'] . "', '" . $data['login'] . "', '" . $data['password'] . "', '" . $data['telephone'] . "', '" . $data['idRole'] . "', '" . $data['dateAjout'] . "', '" . $data['dateModif'] . "')";

    if ($conn->query($sql) !== TRUE) {
        echo "Erreur lors de l'insertion des données dans la table user : " . $conn->error;
    }
}

// Préparation et exécution des requêtes d'insertion pour la table produit
foreach ($produitData as $data) {
    $sql = "INSERT INTO produit (codeProd, nomProd, description, image, poid, prixU, prixV, dateAjout, dateModif,etat, idU) VALUES ('" . $data['codeProd'] . "', '" . $data['nomProd'] . "', '" . $data['description'] . "', '" . $data['image'] . "', '" . $data['poid'] . "', '" . $data['prixU'] . "', '" . $data['prixV'] . "', '" . $data['dateAjout'] . "', '" . $data['dateModif'] . "', '" . $data['etat'] . "', '" . $data['idU'] . "')";

    if ($conn->query($sql) !== TRUE) {
        echo "Erreur lors de l'insertion des données dans la table produit : " . $conn->error;
    }
}

echo "Les données ont été insérées avec succès !";

// Fermeture de la connexion
$conn->close();
?>
