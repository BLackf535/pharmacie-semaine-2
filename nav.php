


<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
<style>
       

       .navbar-brand {
           color: #333; /* Couleur du texte noir */
       }

       .navbar-nav li a {
           color: #333; /* Couleur du texte noir */
       }

       .navbar-nav li a:hover {
           color: #007bff; /* Couleur du texte bleu au survol */
       }
       body {
           background-color: #f8f9fa; /* Couleur de fond légèrement grise */
           padding-top: 10px; /* Ajout de padding-top pour éviter que le navbar ne se cache sous le contenu */
       }
   </style>
  

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">Bonjour   <?php echo $username; ?> !</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
       
        <li class="nav-item">
          <a class="nav-link " href="listing.php" id="navbarDropdown" role="button" >
          Listing
          </a>
         
         
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="inserForm.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Datatable
          </a>
          
        </li> -->
        <li class="nav-item ">
          <a class="nav-link " href="repport.php" id="navbarDropdown" role="button" >
          Reporting
          </a>
        </li>
        
        
        
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Se déconnecter</a>
        </li>
        
      </ul>
    </div>
  </div>
</nav>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->