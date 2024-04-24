<?php
include('tet.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
      <?php
    include('nav.php');
    ?> 
<div class="card">
    <h2>Liste Produit PDF</h2>
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
                <input type="radio" name="etatP" id="etatP" value="Suprimer" required>SUPPRIMER<br>
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
