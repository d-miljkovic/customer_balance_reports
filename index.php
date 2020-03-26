<?php 
require_once "config.php";

if(isset($_SESSION['username'])&&($_SESSION['username']=='admin')){
require_once "index_pretraga.php"; 
} else {
 ?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/custom_style.css">

  <!----------------- multiselect include -->
  <link rel="stylesheet" type="text/css" href="css/multi-select.css">

  <title>Saldo kupci</title>
</head>
<body>


  <nav class="navbar bg-dark navbar-dark navbar-expand-sm">
    <div class="container">
      <div class="navbar-nav ml-sm-auto">

        <a class="nav-item nav-link skriveni_nav" href="index.php">skriveni nav</a>

      </div>
    </div>
  </nav>


  <div class="container" id="wrapper">
    <div class="row">
      <section class="h1_naslov">
        <h1 id="h1_naslov_login">Prijava na sistem</h1>
      </section>
    </div>
    
    <?php include 'indexFormaLogin.php' ?>
  </div> <!-- end of wrapper -->


  


  <!-- partial print include -->
  <script src="js/partial-print.js"></script>


  <!----------------- multiselect include -->
    <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
  <!-- Bootstrap JavaScript -->
  <script src="js/jquery.multi-select.js"></script>
  <script type="text/javascript">
  // run pre selected options
  $('#pre-selected-options').multiSelect();
  </script>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<?php } ?>
