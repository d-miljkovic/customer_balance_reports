<?php 
require "config.php";

if(isset($_SESSION['username'])&&($_SESSION['username']=='admin')){
 
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

  <title>Saldo kupci</title>
</head>
<body>


  <nav class="navbar bg-dark navbar-dark navbar-expand-sm">
    <div class="container">
      <div class="navbar-nav ml-sm-auto">
        <a class="nav-item nav-link" href="logout.php"><button id="logout_dugme" class="btn btn-secondary">Odjavi se</button></a>
        <a class="nav-item nav-link" href="index_pretraga.php">Pretraga</a>

        <!-- start of dropdwon -->
        <div class="dropdown"> 

        <a class="nav-item nav-link active dropdown-toggle" data-toggle="dropdown" id="unosDropdown" aria-haspopup="true" aria-expanded="false" href="#">Unos</a>
        
        <div class="dropdown-menu" aria-labelledby="unosDropdown">
        <a class="dropdown-item" href="index_fakture.php">Unos Fakture</a> 
        <a class="dropdown-item" href="index_izvodi.php">Unos Izvoda</a>
        </div>

        </div>
        <!-- end of dropdown -->

        
        <a class="nav-item nav-link" href="index_administracijaKupca.php?cid">Administracija kupca</a>
      </div>
    </div>
  </nav>


 

  <div class="container" id="wrapper">
    <div class="row">
      <section class="h1_naslov">
        <h1>Fakture</h1>
      </section>
    </div>
    <div class="row" >
      <section class="col-12" id="firstRow">
         <?php        
            include('inc/unosFakture.php');
          ?>
      </section>
    </div>

    <div class="row"> 
      <section class="footer" >
          2019 &copy; <span id="footer_span">Customer Balance reports
      </section>
    </div>
  </div> <!-- end of wrapper -->





  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<?php 
  } else {
      include 'neautorizovaniPristup.php';
    }
?>