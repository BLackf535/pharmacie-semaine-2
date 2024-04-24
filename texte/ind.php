<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>reporting</title>
    <style>
        .card {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 1);
            padding: 10px;
            margin: 10px;
            margin-top: 100px;
        }

        h1, h2 {
            text-align: center;
        }

        h1 {
            color: green;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../Images/sigeris.png" alt="" width="35" height="30" style="border-radius: 10px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tableProduit.html">Datatable Ajax</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reporting.html">Reporting FPDF</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        ssi Admin
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="../model/logout.php">Se Deconnecter</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br><br>
<h1>Gestion des medicaments</h1>
<div class="card">
    <h2>Liste medicament PDF</h2>
    <br>
    <form id="searchForm" method="POST">
        <div class="row">
            <div class="col-md-3">
                <label for="dateD">Date debut</label>
                <input type="date" class="form-control" name="dateD" id="dateD" required>
            </div>
            <div class="col-md-3">
                <label for="dateF">Date de fin</label>
                <input type="date" class="form-control" name="dateF" id="dateF" required>
            </div>
            <div class="col-md-2">
                <label for="etatP">Etat produit</label><br>
                <input type="radio" name="etatP" id="etatP" value="active" required>Active<br>
                <input type="radio" name="etatP" id="etatP" value="Supprimer" required>SUPPRIMER<br>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success" id="submitButton"><i class="fa fa-print"></i> PRINT
                </button>
            </div>
        </div>
    </form>
</div>
<!-- Afficher le PDF dans un modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Fichier PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfViewer" style="width: 100%; height: 600px;"></iframe>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
    // Soumettre le formulaire lors du clic sur le bouton PRINT
    $('#submitButton').click(function () {
        $('#searchForm').submit();
    });

    // Afficher le PDF dans le modal après soumission du formulaire
    $('#searchForm').submit(function (e) {
        e.preventDefault(); // Empêcher le formulaire de soumettre normalement
        $.ajax({
            type: 'POST',
            url: 'factfpdf.php',
            data: $(this).serialize(),
            success: function (response) {
                // Afficher le PDF dans le modal
                $('#pdfViewer').attr('src', 'data:application/pdf;base64,' + response);
                $('#pdfModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Gérer les erreurs AJAX
                console.error(xhr.responseText);
                alert('Une erreur est survenue lors de la récupération du PDF.');
            }
        });
    });
});

</script>
</body>
</html>
