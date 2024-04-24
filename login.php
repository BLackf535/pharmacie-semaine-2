<?php
// Vérifier si la requête est faite en utilisant AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // La requête est faite en utilisant AJAX

    // Récupérer les identifiants de connexion
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Connexion à la base de données
    $servername = "localhost";
    $dbusername = "black";
    $dbpassword = "black";
    $dbname = "boutique";

    // Création d'une connexion
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Vérifier les erreurs de connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données: " . $conn->connect_error);
    }

    // Préparer la requête SQL pour vérifier les identifiants
    $stmt = $conn->prepare("SELECT idU FROM user WHERE login = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Si les identifiants sont valides, renvoyer une réponse JSON avec succès true
    if ($result->num_rows === 1) {
        // echo json_encode(['success' => true]);
         // Démarrer la session
         session_start();

         // Stocker les informations de session
         $_SESSION["loggedin"] = true;
         $_SESSION["username"] = $username;
 
         // Fermer la connexion à la base de données
         $stmt->close();
         $conn->close();
 
         // Répondre avec une réponse JSON de succès
         echo json_encode(['success' => true]);
         exit;
   
        
    } else {
        // Si les identifiants sont invalides, renvoyer une réponse JSON avec succès false et un message d'erreur
        echo json_encode(['success' => false, 'message' => 'Saisie  invalides']);
    }
    
    // Ajouter l'en-tête JSON à la réponse
    header('Content-Type: application/json');
    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
    exit; // Arrêter l'exécution du script après avoir renvoyé la réponse JSON
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Inclure Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Connexion</div>
                    <div class="card-body">
                        <!-- Formulaire de connexion -->
                        <form id="loginForm" method="POST">
                            <div class="form-group">
                                <label for="username">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <!-- Message d'erreur -->
                                <div class="invalid-feedback">Veuillez saisir votre nom.</div>
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <!-- Message d'erreur -->
                                <div class="invalid-feedback"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                            <button type="reset" class="btn btn-danger">Annuler</button>
                        </form>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <!-- Lien vers la page de déconnexion si l'utilisateur n'a pas de compte -->
                        Vous n'avez pas de compte ? <a href="inserForm.php">Créer un compte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                // Empêcher la soumission par défaut du formulaire
                event.preventDefault();

                // Réinitialiser les messages d'erreur
                $('.invalid-feedback').text('');

                // Récupérer les valeurs des champs
                var username = $('#username').val();
                var password = $('#password').val();

                // Vérifier si les champs sont vides
                if (!username || !password) {
                    // Afficher un message d'erreur pour les champs vides
                    $('#username').next('.invalid-feedback').text('Veuillez remplir tous les champs.');
                    return;
                }

                // Envoyer la requête AJAX pour vérifier les identifiants
                $.ajax({
                    url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (!response.success) {
                            // Afficher un message d'erreur pour les identifiants invalides
                            $('#password').next('.invalid-feedback').text(response.message);
                            $('#password').addClass('is-invalid');
                            $('#username').next('.invalid-feedback').text(response.message);
                            $('#username').addClass('is-invalid');
                        } else {
                            // Redirection après une requête AJAX réussie
                            window.location.href = 'index.php';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur AJAX:', error);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
});
    </script>
</body>
</html>
