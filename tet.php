<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  header("Location: login.php");
  exit;
}

// Obtenez les informations de l'utilisateur connecté
$username = $_SESSION["username"];
?>