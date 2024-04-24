







function deleteProduct(id) {
    // Récupérer les informations du produit via une autre requête AJAX
    $.ajax({
        url: 'getProductInfo.php', // URL de votre script PHP pour récupérer les informations du produit
        type: 'POST',
        data: { id: id },
        success: function(productData) {
            // Construire le formulaire avec les informations du produit
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
        <label for="poid" class="form-label">poids:</label>
        <input type="number" id="poid" name="poid" class="form-control">
    </div>
    <div class="mb-3">
        <label for="prixU" class="form-label">prixU:</label>
        <input type="number" id="prixU" name="prixU" class="form-control">
    </div>
    <div class="mb-3">
        <label for="prixV" class="form-label">prixV:</label>
        <input type="number" id="prixV" name="prixV" class="form-control">
    </div>
    
<select class="form-select" id="dropdownMenu" name="selectedValue" onchange="selectChange(this)">
    <option value="">Sélectionner un élément</option>
    <?php
    // Vérifie si la variable $elements est définie et non null
    if(isset($elements) && !is_null($elements)) {
        // La variable $elements est définie et contient des données
        foreach ($elements as $element) {
            echo '<option value="' . $element['idU'] . '">' . $element['nom'] . '</option>';
        }
    } else {
        // La variable $elements est soit non définie, soit null
        // Traitez cette situation en conséquence ou affichez un message d'erreur
        echo '<option value="">Aucun élément trouvé</option>';
    }
    ?>
</select>


    <!-- Champs cachés pour dateAjout et dateModif -->
    <input type="hidden" id="dateAjout" name="dateAjout" value="<?= date('Y-m-d H:i:s') ?>">
    <input type="hidden" id="dateModif" name="dateModif" value="<?= date('Y-m-d H:i:s') ?>">
    

    <button type="button" onclick="addPerson()" class="btn btn-primary">Ajouter</button>
</form>
            `;

            // Afficher le formulaire dans un SweetAlert 2
            swal({
                title: "Supprimer le produit",
                html: formContent,
                showCancelButton: true,
                cancelButtonText: "Annuler",
                confirmButtonText: "Supprimer",
                closeOnConfirm: false,
                closeOnCancel: true,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    // Envoyer une requête AJAX pour supprimer le produit
                    $('#deleteProductForm').submit();
                }
            });
        },
        error: function(xhr, status, error) {
            toastr.error('Erreur lors de la récupération des informations du produit.');
            console.error('Erreur AJAX :', xhr.responseText);
        }
    });
}
