<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'ajout d'un Utilisateur</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            margin-bottom: 15px;
        }
        button {
            width: 100%;
        }
        .footer-link {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h1>Inscription</h1>
        <form id="addPersonForm" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
                <div class="invalid-feedback">Veuillez saisir votre nom.</div>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom:</label>
                <input type="text" id="prenom" name="prenom" class="form-control" required>
                <div class="invalid-feedback">Veuillez saisir votre prénom.</div>
            </div>
            <div class="mb-3">
                <label for="login" class="form-label">Login:</label>
                <input type="text" id="login" name="login" class="form-control" required>
                <div class="invalid-feedback">Veuillez saisir votre login.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe:</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="invalid-feedback">Veuillez saisir votre mot de passe.</div>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirmer le mot de passe:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                <div class="invalid-feedback">Veuillez confirmer votre mot de passe.</div>
                <div id="passwordMatch" class="invalid-feedback">Les mots de passe ne correspondent pas.</div>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone:</label>
                <input type="text" id="telephone" name="telephone" class="form-control" required>
                <div class="invalid-feedback">Veuillez saisir votre numéro de téléphone.</div>
            </div>
            <div class="mb-3">
                <label for="idRole" class="form-label">ID de rôle (1 à 3):</label>
                <input type="number" id="idRole" name="idRole" min="1" max="3" class="form-control" required>
                <div class="invalid-feedback">Veuillez saisir un ID de rôle valide (entre 1 et 3).</div>
            </div>
            <!-- Champs cachés pour dateAjout et dateModif -->
            <input type="hidden" id="dateAjout" name="dateAjout" value="<?= date('Y-m-d H:i:s') ?>">
            <input type="hidden" id="dateModif" name="dateModif" value="<?= date('Y-m-d H:i:s') ?>">
        
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
        <div class="footer-link">
            Vous n'avez un compte ? <a href="login.php">Connexion</a>
        </div>
    </div>
</div>

<script src="./libs/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#addPersonForm').submit(function(event) {
        event.preventDefault();
        if (this.checkValidity() === false) {
            event.stopPropagation();
        } else {
            validatePasswords();
        }
        $(this).addClass('was-validated');
    });
});

function validatePasswords() {
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();

    if (password !== confirmPassword) {
        $('#passwordMatch').show();
    } else {
        addPerson();
    }
}

function addPerson() {
    var nom = $('#nom').val();
    var prenom = $('#prenom').val();
    var login = $('#login').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();
    var telephone = $('#telephone').val();
    var idRole = $('#idRole').val();
    var dateAjout = $('#dateAjout').val();
    var dateModif = $('#dateModif').val();

    if (nom === '' || prenom === '' || login === '' || password === '' || confirmPassword === '' || telephone === '' || idRole === '') {
        Swal.fire('Erreur', 'Veuillez remplir tous les champs obligatoires', 'error');
        return;
    }

    if (password !== confirmPassword) {
        Swal.fire('Erreur', 'Les mots de passe ne correspondent pas', 'error');
        return;
    }

    Swal.fire({
        title: 'Êtes-vous sûr de vouloir ajouter cette personne ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'from1.php',
                type: 'POST',
                data: { nom: nom, prenom: prenom, login: login, password: password, telephone: telephone, idRole: idRole, dateAjout: dateAjout, dateModif: dateModif },
                success: function(response) {
                    Swal.fire('Succès', response, 'success').then((result) => {
                        window.location.href = 'login.php';
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Erreur', 'Une erreur est survenue', 'error');
                }
            });
        }
    });
}
</script>

</body>
</html>
