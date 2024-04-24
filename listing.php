<?php
include('tet.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- SweetAlert CSS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css"> -->
   <!-- Inclure le CSS de SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">


    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"  href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <?php
    include('nav.php');
    ?>

<div class="text-center" style="padding: 45px;">
    <button type="button" class="btn btn-success" id="btnAddProduct">Ajouter un produit</button>
</div>

    <!-- Tableau des produits -->
    <table id="dataTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>codeProd</th>
                <th>nomProd</th>
                <th>description</th>
                <th>image</th>
                <th>poid</th>
                <th>prixU</th>
                <th>prixV</th>
                <th>dateAjout</th>
                <th>dateModif</th>
                <th>Id user</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les données seront chargées dynamiquement ici -->
        </tbody>
    </table>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Scripts -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
    <!-- Inclure le script de SweetAlert -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <script>
        // Fonction pour afficher les produits
        function displayProducts() {
            $('#dataTable').DataTable().ajax.reload(); // Recharge les données du DataTable
        }

        $(document).ready(function() {
            $('#dataTable').DataTable({
                "ajax": {
                    "url": "donneCS.php",
                    "dataSrc": ""
                },
                "columns": [
                    {"data": "idProd"},
                    {"data": "codeProd"},
                    {"data": "nomProd"},
                    {"data": "description"},
                    {"data": "image"},
                    {"data": "poid"},
                    {"data": "prixU"},
                    {"data": "prixV"},
                    {"data": "dateAjout"},
                    {"data": "dateModif"},
                    {"data": "idU"},
                    {
                        "render": function(data, type, row) {
                            return `
                                <button onclick="deleteProduct(${row.idProd})" class="btn btn-outline-danger">Supprimer</button><br >
                                <button onclick="editProduct(${row.idProd})" class="btn btn-outline-success">Modifier</button>
                            `;
                        }
                    }
                ]
            });
        });

        // Fonction pour supprimer un produit
function deleteProduct(id) {
    // Récupérer les informations du produit via une requête AJAX
    $.ajax({
        url: 'getProductInfo.php',
        type: 'POST',
        data: { id: id },
        success: function(productData) {
            // Convertir la réponse JSON en objet JavaScript
            var product = JSON.parse(productData);

            // Construire le formulaire avec les informations du produit
            var formContent = `
                <form id="deleteProductForm" novalidate>
               

                
                <div class="mb-3">
                        <label for="description" class="form-label">nomProd:</label>
                        <input type="text" id="nomProd" name="nomProd" class="form-control" value="${product.nomProd}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <input type="text" id="description" name="description" class="form-control" value="${product.description}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="poid" class="form-label">Poids:</label>
                        <input type="number" id="poid" name="poid" class="form-control" value="${product.poid}">
                    </div>
                    <div class="mb-3">
                        <label for="prixU" class="form-label">Prix unitaire:</label>
                        <input type="number" id="prixU" name="prixU" class="form-control" value="${product.prixU}">
                    </div>
                    <div class="mb-3">
                        <label for="prixV" class="form-label">Prix de vente:</label>
                        <input type="number" id="prixV" name="prixV" class="form-control" value="${product.prixV}">
                    </div>
                    <div class="mb-2">
                        <label for="idU" class="form-label">ID utilisateur:</label>
                        <input type="number" id="idU" name="idU" class="form-control" value="${product.idU}">
                    </div>
                    <div class="mb-3">
                       
                        
                        <img src="${product.image}" alt="Description de l'image" width="200" height="200">

                    </div>
                    <!-- Champs cachés pour dateAjout et dateModif -->
                    <input type="hidden" id="dateAjout" name="dateAjout" value="${product.dateAjout}">
                    <input type="hidden" id="dateModif" name="dateModif" value="${product.dateModif}">
                </form>
            `;

            // Afficher le formulaire dans un SweetAlert 2


            Swal.fire({
                title: 'Supprimer le produit',
                html: formContent,
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Supprimer',
                icon: 'warning',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envoyer une requête AJAX pour supprimer le produit
                    // $('#deleteProductForm').submit();

                    // Envoyer une requête AJAX pour supprimer le produit
                    Swal.fire({
        title: 'Êtes-vous sûr de vouloir Supprimer le produit ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {                    
                    $.ajax({
                        url: 'updateEtat.php',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            // Afficher un message de succès
                            Swal.fire('Produit supprimé !', '', 'success');
                            
                            // Recharger les données du DataTable
                            displayProducts();
                        },
                        error: function(xhr, status, error) {
                            console.error('Erreur AJAX :', xhr.responseText);
                        }
                    });

                                     }
    });
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX :', xhr.responseText);
        }
    });
}




$(document).ready(function() {
    // Attacher un gestionnaire d'événements au clic du bouton
    $('#btnAddProduct').click(function() {
        addProduct();
    });
});


function addProduct() {
    // Construire le formulaire pour ajouter un produit
    var formContent = `
    <form id="addPersonForm" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="codeProd" class="form-label">CodeProd:</label>
            <input type="text" id="codeProd" name="codeProd" class="form-control">
        </div>
        <div class="mb-3">
            <label for="nomProd" class="form-label">Nomprod:</label>
            <input type="text" id="nomProd" name="nomProd" class="form-control">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <input type="text" id="description" name="description" class="form-control">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image :</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label for="poid" class="form-label">Poids:</label>
            <input type="number" id="poid" name="poid" class="form-control">
        </div>
        <div class="mb-3">
            <label for="prixU" class="form-label">Prix U:</label>
            <input type="number" id="prixU" name="prixU" class="form-control">
        </div>
        <div class="mb-3">
            <label for="prixV" class="form-label">Prix V:</label>
            <input type="number" id="prixV" name="prixV" class="form-control">
        </div>
        <div class="mb-3">
        <label for="selectedValue" class="form-label">Sélectionnez un User :</label>
            <select class="form-select" id="selectedValue" name="selectedValue">
                <option value="">Sélectionner un User</option>
                <!-- Les options seront ajoutées dynamiquement ici -->
            </select>
        </div>
        <!-- Champs cachés pour dateAjout et dateModif -->
        <input type="hidden" id="dateAjout" name="dateAjout" value="<?= date('Y-m-d H:i:s') ?>">
        <input type="hidden" id="dateModif" name="dateModif" value="<?= date('Y-m-d H:i:s') ?>">
    </form>
    `;

    // Afficher le formulaire dans un SweetAlert
    Swal.fire({
        title: 'Ajouter un produit',
        html: formContent,
        showCancelButton: true,
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Ajouter',
        icon: 'info',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        didOpen: function() {
            // Charger les éléments du menu déroulant lorsque le formulaire est ouvert
            loadDropdownItems();
        },
        preConfirm: function() {
            // Récupérer les valeurs du formulaire pour la validation
            var codeProd = $('#codeProd').val();
            var nomProd = $('#nomProd').val();
            var description = $('#description').val();
            var image = $('#image').val();
            var poid = $('#poid').val();
            var prixU = $('#prixU').val();
            var prixV = $('#prixV').val();
            var selectedValue = $('#selectedValue').val();

            // Vérifier que tous les champs obligatoires sont remplis
            if (codeProd === '' || nomProd === '' || description === '' || image === '' || poid === '' || prixU === '' || prixV === '' || selectedValue === '') {
                Swal.showValidationMessage('Veuillez remplir tous les champs obligatoires');
                return false;
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Envoyer le formulaire si confirmé
            var formData = new FormData($('#addPersonForm')[0]);
                Swal.fire({
        title: 'Êtes-vous sûr de vouloir ajouter ce produit ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'addProduct.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Traiter la réponse
                    if (response.trim() === 'Succès de l\'insertion') {
                        Swal.fire('Produit ajouté !', '', 'success').then((result) => {
                           // window.location.href = 'addProduct.php';
                            displayProducts();
                        });
                    } else {
                        Swal.fire('Erreur', 'Erreur lors de l\'insertion du produit', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur AJAX :', xhr.responseText);
                    Swal.fire('Erreur', 'Erreur AJAX lors de l\'ajout du produit', 'error');
                }
            });
 }
    });

        }
    });
}

function loadDropdownItems() {
    $.ajax({
        url: 'select.php', // Le fichier PHP qui récupère les éléments
        type: 'GET',
        success: function(response) {
            // Convertir la réponse JSON en objet JavaScript
            var elements = JSON.parse(response);

            // Sélectionner le menu déroulant par son identifiant
            var dropdownMenu = $('#selectedValue');

            // Supprimer les anciennes options s'il y en a
            dropdownMenu.empty();

            // Ajouter une option par défaut
            dropdownMenu.append($('<option></option>').text('Sélectionner un élément'));

            // Boucle à travers les éléments et créer une option pour chaque élément
            elements.forEach(function(element) {
                // Créer un élément d'option
                var option = $('<option></option>').attr('value', element.idU).text(element.nom);
                // Ajouter l'option au menu déroulant
                dropdownMenu.append(option);
            });
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX :', xhr.responseText);
        }
    });
}





function editProduct(id) {
    // Récupérer les informations du produit via une requête AJAX
    $.ajax({
        url: 'getProductInfo.php',
        type: 'POST',
        data: { id: id },
        success: function(productData) {
            // Convertir la réponse JSON en objet JavaScript
            var product = JSON.parse(productData);

            // Construire le formulaire avec les informations du produit
            var formContent = `
                <form id="deleteProductForm">
                <div class="mb-3">
                        <label for="description" class="form-label">codeProd:</label>
                        <input type="text" id="codeProd" name="codeProd" class="form-control" value="${product.codeProd}">
                    </div>
                <div class="mb-3">
                        <label for="description" class="form-label">nomProd:</label>
                        <input type="text" id="nomProd" name="nomProd" class="form-control" value="${product.nomProd}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <input type="text" id="description" name="description" class="form-control" value="${product.description}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="poid" class="form-label">Poids:</label>
                        <input type="number" id="poid" name="poid" class="form-control" value="${product.poid}">
                    </div>
                    <div class="mb-3">
                        <label for="prixU" class="form-label">Prix unitaire:</label>
                        <input type="number" id="prixU" name="prixU" class="form-control" value="${product.prixU}">
                    </div>
                    <div class="mb-3">
                        <label for="prixV" class="form-label">Prix de vente:</label>
                        <input type="number" id="prixV" name="prixV" class="form-control" value="${product.prixV}">
                    </div>
                    <div class="mb-2">
                        <label for="idU" class="form-label">ID utilisateur:</label>
                        <input type="number" id="idU" name="idU" class="form-control" value="${product.idU}">
                    </div>
                    <div class="mb-3">
                       
                        
                        <img src="${product.image}" alt="Description de l'image" width="200" height="200">

                    </div>
                    <!-- Champs cachés pour dateAjout et dateModif -->
                    <input type="hidden" id="dateAjout" name="dateAjout" value="${product.dateAjout}">
                    <input type="hidden" id="dateModif" name="dateModif" value="${product.dateModif}">
                    <button type="button" class="btn btn-primary" onclick="updateProduct(${product.idProd})">Enregistrer les modifications</button>
                </form>
            `;

            // Afficher le formulaire dans un SweetAlert 2


            // Swal.fire({
            //     title: 'Update le produit',
            //     html: formContent,
            //     showCancelButton: true,
            //     // cancelButtonText: 'Annuler',
            //     // confirmButtonText: 'Supprimer',
            //     icon: 'warning',
            //     confirmButtonColor: '#d33',
            //     cancelButtonColor: '#3085d6',
            // });
            Swal.fire({
                title: 'Modifier le produit',
                html: formContent,
                showCancelButton: true,
                icon: 'warning',
                confirmButtonText: 'Annuler',
                showConfirmButton: false,
                confirmButtonColor: '#d33',
            });
            
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX :', xhr.responseText);
        }
    });
}

function updateProduct(id) {
    // Récupérer les valeurs mises à jour du formulaire
    var codeProd = $('#codeProd').val();
    var nomProd = $('#nomProd').val();
    var description = $('#description ').val();
    var poid = $('#poid').val();
    var prixU = $('#prixU').val();
    var prixV = $('#prixV').val();
    var dateAjout = $('#dateAjout').val();
    var dateModif = $('#dateModif').val();
    // Ajoutez les autres champs du formulaire ici
    
    // Envoyer une requête AJAX pour mettre à jour le produit
    Swal.fire({
        title: 'Êtes-vous sûr de vouloir Faire la modification ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'updateTout.php',
                type: 'POST',
                data: {
                    id: id,
                    codeProd: codeProd,
                    nomProd: nomProd,
                    description: description,
                    poid: poid,
                    prixU: prixU,
                    prixV: prixV,
                    dateAjout: dateAjout,
                    dateModif: dateModif,
                    
                    // Ajoutez les autres champs du formulaire ici
                },
                success: function(response) {
                    // Afficher un message de succès

                    Swal.fire('Produit mis à jour !', response, 'success').then((result) => {
                        window.location.href = 'listing.php';
                        displayProducts();
                    });
                },
                    
                    
                    // Fermer la modal SweetAlert
                    

                    // Recharger les données du DataTable
                   // displayProducts();
                
                error: function(xhr, status, error) {
                    console.error('Erreur AJAX :', xhr.responseText);
                }
            });
        }
    });

}




// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()


    </script>
</body>
</html>
