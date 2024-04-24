<?php
include('tet.php');
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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

    <?php
    include('nav.php');
    ?> 

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
                <input class="form-check-input" type="radio" name="choix" value="active" id="checkbox1">
                <label class="form-check-label" for="checkbox1">
                    Active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="choix" value="suprimer" id="checkbox2">
                <label class="form-check-label" for="checkbox2">
                    Supprimer
                </label>
            </div>
        </div>
    </div>
    <button id="generatePdfBtn" class="btn btn-success"><i class="fa-solid fa-print"></i> PDF</button>
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
// $(document).ready(function() {
//   $('#generatePdfBtn').click(function() {
//     var selectedDate = $('#datePicker').val();
//     var selectedDate2 = $('#datePicker2').val();
//     var selectedOption = $('input[name="choix"]:checked').val();

//     $.ajax({
//       url: 'data.php',
//       dataType: 'json',
//       data: { 
//         date: selectedDate,
//         date2: selectedDate2,
//         choix: selectedOption 
//       },
//       success: function(dataFromDatabase) {
//         console.log(dataFromDatabase);

//         var doc = new jsPDF('landscape');
//         var recordsPerPage = 20; // Nombre d'enregistrements par page
//         var rowCount = dataFromDatabase.length;
//         var totalPages = Math.ceil(rowCount / recordsPerPage);
//         var startIndex = 0;

//         for (var page = 0; page < totalPages; page++) {
//           if (page > 0) {
//             doc.addPage();
//           }

//           var columns = ["codeProd", "NomProd", "Poid", "Prix Unit", "Prix Vente"];

//           // Dessiner les en-têtes de colonne sur chaque page
//           var startX = 10;
//           var startY = 10;
//           var cellWidth = 60;
//           var cellHeight = 20;
//           var cellSpacingX = 0;
//           var cellSpacingY = 0;

//           for (var j = 0; j < columns.length; j++) {
//             var columnWidth = Math.max(cellWidth, doc.getStringUnitWidth(columns[j]) * 5);
//             doc.rect(startX + (columnWidth + cellSpacingX) * j, startY, columnWidth, cellHeight, 'S');
//             doc.text(columns[j], startX + (columnWidth + cellSpacingX) * j + columnWidth / 2 - doc.getStringUnitWidth(columns[j]) * 5 / 2, startY + cellHeight / 2 + 2);
//           }

//           // Dessiner les lignes de données sur chaque page
//           for (var i = startIndex; i < Math.min(startIndex + recordsPerPage, rowCount); i++) {
//             var rowData = [
//               dataFromDatabase[i].codeProd.toString(),
//               dataFromDatabase[i].nomProd.toString(),
//               dataFromDatabase[i].poid.toString(),
//               dataFromDatabase[i].prixU.toString(),
//               dataFromDatabase[i].prixV.toString()
//             ];

//             for (var j = 0; j < columns.length; j++) {
//               var columnWidth = Math.max(cellWidth, doc.getStringUnitWidth(columns[j]) * 5);
//               doc.rect(startX + (columnWidth + cellSpacingX) * j, startY + cellHeight + (cellHeight + cellSpacingY) * (i - startIndex), columnWidth, cellHeight, 'S');
//               doc.text(rowData[j], startX + (columnWidth + cellSpacingX) * j + columnWidth / 2 - doc.getStringUnitWidth(rowData[j]) * 5 / 2, startY + cellHeight + (cellHeight + cellSpacingY) * (i - startIndex) + cellHeight / 2 + 2);
//             }
//           }

//           startIndex += recordsPerPage;
//         }

//         var pdfData = doc.output('datauristring');
//         $('#pdfIframe').attr('src', pdfData);
//         $('#pdfModal').modal('show');
//       },
//       error: function(xhr, status, error) {
//         console.error(xhr.responseText);
//       }
//     });
//   });
// });

$(document).ready(function() {
  $('#generatePdfBtn').click(function() {
    var selectedDate = $('#datePicker').val();
    var selectedDate2 = $('#datePicker2').val();
    var selectedOption = $('input[name="choix"]:checked').val();

    $.ajax({
      url: 'data.php',
      dataType: 'json',
      data: { 
        date: selectedDate,
        date2: selectedDate2,
        choix: selectedOption 
      },
      success: function(dataFromDatabase) {
        console.log(dataFromDatabase);

        var doc = new jsPDF('landscape');
        var recordsPerPage = 20; // Nombre d'enregistrements par page
        var rowCount = dataFromDatabase.length;
        var totalPages = Math.ceil(rowCount / recordsPerPage);
        var startIndex = 0;

        for (var page = 0; page < totalPages; page++) {
          if (page > 0) {
            doc.addPage();
          }

          var columns = ["codeProd", "NomProd", "Poid", "Prix Unit", "Prix Vente"];

          // Dessiner les en-têtes de colonne sur chaque page
          var startX = 10;
          var startY = 10;
          var cellWidth = 60;
          var cellHeight = 20;
          var cellSpacingX = 0;
          var cellSpacingY = 0;

          for (var j = 0; j < columns.length; j++) {
            var columnWidth = Math.max(cellWidth, doc.getStringUnitWidth(columns[j]) * 5);
            doc.rect(startX + (columnWidth + cellSpacingX) * j, startY, columnWidth, cellHeight, 'S');
            doc.text(columns[j], startX + (columnWidth + cellSpacingX) * j + columnWidth / 2 - doc.getStringUnitWidth(columns[j]) * 5 / 2, startY + cellHeight / 2 + 2);
          }

          // Dessiner les lignes de données sur chaque page
          for (var i = startIndex; i < Math.min(startIndex + recordsPerPage, rowCount); i++) {
            var rowData = [
              dataFromDatabase[i].codeProd.toString(),
              dataFromDatabase[i].nomProd.toString(),
              dataFromDatabase[i].poid.toString(),
              dataFromDatabase[i].prixU.toString(),
              dataFromDatabase[i].prixV.toString()
            ];

            for (var j = 0; j < columns.length; j++) {
              var columnWidth = Math.max(cellWidth, doc.getStringUnitWidth(columns[j]) * 5);
              var cellText = rowData[j];

              var textWidth = doc.getTextWidth(cellText);
              if (textWidth > columnWidth) {
                // Tronquer le texte si sa largeur dépasse la largeur de la cellule
                var truncatedText = cellText.substring(0, Math.floor(columnWidth / textWidth * cellText.length));
                cellText = truncatedText + "...";
              }

              doc.rect(startX + (columnWidth + cellSpacingX) * j, startY + cellHeight + (cellHeight + cellSpacingY) * (i - startIndex), columnWidth, cellHeight, 'S');
              doc.text(cellText, startX + (columnWidth + cellSpacingX) * j + columnWidth / 2 - doc.getStringUnitWidth(cellText) * 5 / 2, startY + cellHeight + (cellHeight + cellSpacingY) * (i - startIndex) + cellHeight / 2 + 2);
            }
          }

          startIndex += recordsPerPage;
        }

        var pdfData = doc.output('datauristring');
        $('#pdfIframe').attr('src', pdfData);
        $('#pdfModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });
});
</script>

</body>
</html>
