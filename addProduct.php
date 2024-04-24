<?php


// $codeProd = isset($_POST['codeProd']) ? $_POST['codeProd'] : '';
// $nomProd = isset($_POST['nomProd']) ? $_POST['nomProd'] : '';
// $description = isset($_POST['description']) ? $_POST['description'] : '';
// $poid = isset($_POST['poid']) ? $_POST['poid'] : '';
// $prixU = isset($_POST['prixU']) ? $_POST['prixU'] : '';
// $prixV = isset($_POST['prixV']) ? $_POST['prixV'] : '';
// $dateAjout = isset($_POST['dateAjout']) ? $_POST['dateAjout'] : '';
// $dateModif = isset($_POST['dateModif']) ? $_POST['dateModif'] : '';
// $selectedValue = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : '';
// $etat = "active";


// echo '-'.$codeProd;
// echo '-'.$nomProd;
// echo '-'.$description;
// echo '-'.$poid;
// echo '-'.$prixU;
// echo '-'.$prixV;
// echo '-'.$dateAjout;
// echo '-'.$dateModif;
// echo '-'.$selectedValue;





// Vérifier si les données du formulaire sont définies
if (isset($_POST['codeProd'], $_POST['nomProd'], $_POST['description'], $_POST['poid'], $_POST['prixU'], $_POST['prixV'], $_POST['dateAjout'], $_POST['dateModif'], $_POST['selectedValue'])) {
    // Récupérer les données du formulaire
    $codeProd = $_POST['codeProd'];
    $nomProd = $_POST['nomProd'];
    $description = $_POST['description'];
    $poid = $_POST['poid'];
    $prixU = $_POST['prixU'];
    $prixV = $_POST['prixV'];
    $dateAjout = $_POST['dateAjout'];
    $dateModif = date('Y-m-d'); // Mettre à jour la date de modification
    $selectedValue = $_POST['selectedValue'];
    $etat = "active";

    // Vérifier si un fichier image a été téléchargé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name']; // Nom de l'image
        $imageTmpName = $_FILES['image']['tmp_name']; // Emplacement temporaire de l'image
        $imagePath = 'uploads/' . $imageName; // Chemin de l'image sur le serveur

        // Déplacer le fichier téléchargé vers le répertoire de stockage des images
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            // Connexion à la base de données
            $servername = "localhost";
            $username = "black";
            $password = "black";
            $dbname = "boutique";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Échec de la connexion à la base de données: " . $conn->connect_error);
            }

            // Préparer et exécuter la requête SQL pour insérer les données
            $query = "INSERT INTO produit (codeProd, nomProd, description, image, poid, prixU, prixV, dateAjout, dateModif, etat, idU) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssssssss", $codeProd, $nomProd, $description, $imagePath, $poid, $prixU, $prixV, $dateAjout, $dateModif, $etat, $selectedValue);

            if ($stmt->execute()) {
                echo "Succès de l'insertion";
            } else {
                echo "Erreur lors de l'insertion";
                echo "Erreur : " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
        echo "Aucun fichier image téléchargé ou erreur lors du téléchargement.";
    }
} else {
    echo "Données du formulaire manquantes.";
}
?>
