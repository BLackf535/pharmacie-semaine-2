<?php
require_once('fpdf.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "black"; // Remplacez par votre nom d'utilisateur MySQL
    $password = "black"; // Remplacez par votre mot de passe MySQL
    $dbname = "boutique"; // Remplacez par le nom de votre base de données

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupération des valeurs du formulaire
    $date1 = $conn->real_escape_string($_POST['dateD']);
    $date2 = $conn->real_escape_string($_POST['dateF']);
    $etat = $conn->real_escape_string($_POST['etatP']);

    // Requête SQL avec les valeurs filtrées
    $sql = "SELECT *
            FROM produit
            WHERE DATE(dateAjout) BETWEEN '$date1' AND '$date2'
            AND etat = '$etat'";

    $result = $conn->query($sql);

    if ($result === false) {
        die("Erreur lors de l'exécution de la requête SQL: " . $conn->error);
    }

    // Créer un nouvel objet FPDF
    $pdf = new FPDF('P');
    $pdf->SetFont('Arial', '', 12); // Définir la police et la taille

    // Ajouter une page
    $pdf->AddPage();

    // Entêtes du tableau
    $pdf->Cell(40, 10, 'codeProd', 1);
    $pdf->Cell(50, 10, 'NomProd', 1);
    $pdf->Cell(40, 10, 'Poids', 1);
    $pdf->Cell(40, 10, 'PrixU', 1);
    $pdf->Cell(40, 10, 'PrixV', 1);
    $pdf->Cell(40, 10, 'ID', 1);
    $pdf->Ln(); // Aller à la ligne

    // Récupérer les données de la base de données et les afficher dans le tableau
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['idProd'], 1);
        $pdf->Cell(50, 10, $row['nomProd'], 1);
        $pdf->Cell(40, 10, $row['poid'], 1);
        $pdf->Cell(40, 10, $row['prixU'], 1);
        $pdf->Cell(40, 10, $row['prixV'], 1);
        $pdf->Cell(40, 10, $row['idProd'], 1);
        $pdf->Ln(); // Aller à la ligne pour la prochaine entrée
    }

    // Ne pas envoyer de sortie HTML avant la génération du PDF
    $pdfOutput = $pdf->Output('', 'S'); // Stocker le PDF dans une variable

    // Envoyer le PDF en réponse à la requête AJAX
    echo base64_encode($pdfOutput);
    exit; // Arrêter l'exécution du script PHP après l'envoi du PDF
}
?>
