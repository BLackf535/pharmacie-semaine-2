<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    .modal-dialog {
      max-width: 95%; /* Modifiez cette valeur selon vos besoins */
      margin: 1.75rem auto;
      height: 90vh; /* Modifiez cette valeur selon vos besoins */
    }
    .modal-content {
      width: 100%;
      height: 100%;
    }
  </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <label for="datePicker">Sélectionnez une date :</label>
            <input type="date" id="datePicker" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="datePicker">Sélectionnez une date 2:</label>
            <input type="date" id="datePicker2" class="form-control">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="choix" value="1" id="checkbox1">
                <label class="form-check-label" for="checkbox1">
                    Option 1
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="choix" value="2" id="checkbox2">
                <label class="form-check-label" for="checkbox2">
                    Option 2
                </label>
            </div>
        </div>
    </div>
    <button id="generatePdfBtn" class="btn btn-primary mt-3">Générer PDF</button>
</div>


  <!-- Fenêtre modale -->
  <div id="pdfModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">PDF Généré</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <iframe id="pdfIframe" width="100%" height="100%"></iframe>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.js"></script>

  <script>
$(document).ready(function() {
  $('#generatePdfBtn').click(function() {
    var selectedDate = $('#datePicker').val(); // Récupérer la valeur sélectionnée dans le champ de date
    var selectedDate2 = $('#datePicker2').val(); 
    var selectedOption = $('input[name="choix"]:checked').val();

    // Appeler le script PHP pour récupérer les données de la base de données
    $.ajax({
      url: 'data.php',
      dataType: 'json',
      data: { 
        date: selectedDate,
        date2: selectedDate2 ,
        choix : selectedOption 
    
    }, // Envoyer la date sélectionnée à la page PHP
      success: function(dataFromDatabase) {
        console.log(dataFromDatabase); // Vérifiez les données reçues dans la console
        
        // Génération du contenu PDF avec les données récupérées
        var doc = new jsPDF();
        
        // Position initiale de la table
        var startX = 15;
        var startY = 15;
        
        // Largeur et hauteur des cellules
        var cellWidth = 40;
        var cellHeight = 10;
        
        // Espacement horizontal et vertical entre les cellules
        var cellSpacingX = 0;
        var cellSpacingY = 0;
        
        // Création de la table
        var columns = ["ID", "Nom" , "Prenom" , "Login"];
        var rowCount = dataFromDatabase.length;
        var columnCount = columns.length;
        
        // Dessiner les en-têtes de colonne
        for (var i = 0; i < columnCount; i++) {
          doc.rect(startX + (cellWidth + cellSpacingX) * i, startY, cellWidth, cellHeight, 'S');
          doc.text(columns[i], startX + (cellWidth + cellSpacingX) * i + cellWidth / 2 - doc.getStringUnitWidth(columns[i]) * 5 / 2, startY + cellHeight / 2 + 2);
        }
        
        // Dessiner les lignes de données
        for (var i = 0; i < rowCount; i++) {
          var rowData = [dataFromDatabase[i].idU.toString(), dataFromDatabase[i].nom.toString(), dataFromDatabase[i].prenom.toString(), dataFromDatabase[i].login.toString()]; // Convertir les valeurs en chaînes de caractères
          for (var j = 0; j < columnCount; j++) {
            doc.rect(startX + (cellWidth + cellSpacingX) * j, startY + cellHeight + (cellHeight + cellSpacingY) * (i + 1), cellWidth, cellHeight, 'S');
            doc.text(rowData[j], startX + (cellWidth + cellSpacingX) * j + cellWidth / 2 - doc.getStringUnitWidth(rowData[j]) * 5 / 2, startY + cellHeight + (cellHeight + cellSpacingY) * (i + 1) + cellHeight / 2 + 2);
          }
        }
        
        // Génération du fichier PDF
        var pdfData = doc.output('datauristring');

        // Affichage du PDF dans la fenêtre modale
        $('#pdfIframe').attr('src', pdfData);
        $('#pdfModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText); // Affichez les erreurs éventuelles dans la console
      }
    });
  });
});


</script>

</body>
</html>
