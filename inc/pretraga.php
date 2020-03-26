<?php 
$errors = array();


echo '  
<div class="row" id="forma_pretraga">
<section class="col-12">
';


$form = new FormHelper("POST","");
$form->open_tag();




$form->input('select-all','submit', 'btn_select', 'Selektuj sve','','','btn btn-secondary btn-sm');
$form->input('deselect-all','submit', 'btn_deselect', 'Odselektuj sve','','','btn btn-secondary btn-sm');

$kupac = new Kupac(1);
$q = $kupac->prikaziAktivnogKupca();
$form->multiSelect('public-methods','','selSifra[]',$q, '', 'multiple'); 

echo "Firma ";
$firma = new Firma();
$lista_firme = $firma->prikaziFirmu();
$default_opcija_firme = 'Izaberi Firmu';
$form->selectQuery('', 'naziv_frime',$lista_firme,$default_opcija_firme, 'form-control'); 
echo "<br><br>";


echo "Datum ";
$danasnjiDatum = date("Y-m-d");
$form->input('datepickerPretraga', 'date', 'datepicker', $danasnjiDatum , '', '' , 'form-control');
echo "<br><br>";


$form->input('dugme_pretrazi' ,'submit', 'btn_pretrazi', 'Pretrazi', '', '', 'btn btn-secondary mb-2'); 

$form->close_tag();


echo '      
</section>
</div>
';



// pocetak pretrage
if(isset($_POST['btn_pretrazi'])){


  $firma = $_POST['naziv_frime'];
  $selSifra = $_POST['selSifra'];
  $datum = $_POST['datepicker'];


  // provera da li su sva polja popunjena
  if(!$errors){
    if(!$firma || !$selSifra || !$datum){
      $errors[] = "Sva polja moraju biti popunjena, pokusajte opet.";
    } 
  }

  // ako su sva polja popunjena prikazuje
  if (!$errors){

    ?>
    <a href="index_pretraga.php"><button class="btn btn-primary mb-2" id="dugme_nazad_pretraga">Nazad na pretragu</button></a>
    <script>
    document.getElementById('forma_pretraga').style='display:none';
    </script>
    <?php


    echo '
    <div class="row">
    <section class="col-12" id="sekcija_ukupan_saldo"> 
    <h4>Ukupno</h4>
    <p>Selektovani datum: '. date("d.m.Y",strtotime($datum)) .'</p>
    <p>Ukupan saldo za odabrane kupce: <span id="saldo_span"> </span></p>
    </section> 
    </div>  
      '; 
     


     //ukupan saldo za odabrane kupce
      $ukupanSaldo = null;
      foreach ($selSifra as $key => $sifre_kupci) {
        $saldoObj= new Saldo();
        $saldoKupci = $saldoObj->izracunajSaldo($sifre_kupci, $firma ,$datum);
        $ukupanSaldo+=$saldoKupci;
      }
      ?>
      
      
      <!-- ispisivanje ukunog salda u direktno u span saldo_span -->
      <!-- boja zelena/crvena u zavisnosti da lije saldo + ili - -->
      <script>
      
      <?php if($ukupanSaldo>0){ ?>
      document.getElementById('saldo_span').innerHTML =  '<?php echo '-'. abs($ukupanSaldo); ?>';  
      document.getElementById('saldo_span').style = 'background: #FD7878';
      <?php }else if ($ukupanSaldo<0){ ?>
      document.getElementById('saldo_span').innerHTML =  '<?php echo '+'. abs($ukupanSaldo); ?>';  
      document.getElementById('saldo_span').style = 'background: #98FF96';
     <?php } ?>
      </script>



      <?php
      // pozivanje klasa Faktura i Izvoda i prosledjivanje select kupci kao $value 
     foreach ($selSifra as $key => $sifre_kupci) {
        $fakture = new Faktura();
        $dugovanja = $fakture->prikaziDuguje($sifre_kupci,$firma);
        $izvodi = new Izvod();
        $potrazivanja = $izvodi->prikaziPotrazuje($sifre_kupci,$firma);
        $saldoKupci = $saldoObj->izracunajSaldo($sifre_kupci, $firma ,$datum);
        if($saldoKupci < 0){
          $saldoKupci = '+'. abs($saldoKupci);
        } else if ($saldoKupci > 0){
          $saldoKupci = '-'. abs($saldoKupci);
        }
        $kupci = new Kupac(1);
        $kupac = $kupci->prikaziKupcaPrekoSifre($sifre_kupci);

        

        // pocetak prikaza duguje/potrazuje
         echo '

         <div id="'.$sifre_kupci.'" class="row faktura_frame">
         <h5>Istorija Kupca</h4>

         <a href="#" id="link_printer"><img onclick="printContent('.$sifre_kupci.')" class ="printer_icon" src="img/icons/printer.svg"></a>

         
          <p class="col-12">Firma: '. $firma .' </p> 
          <p class="col-12">Kupac: '. $kupac->naziv_kupca .'  </p> 
          <p class="col-12">Selektovni datum: '. date("d.m.Y",strtotime($datum)) .' </p> 
          <span class="col-12">Saldo: '. $saldoKupci .' </span><br><br>
          <section class="col-xs-12 col-sm-12 col-md-6">
          <span class="6">Istorija duguje:</span><br>
          <table class="table table-striped">
          <thead>
          <tr>
          <th scope="col">Sifra fakture</th>
          <th scope="col">Duguje iznos</th>
          <th scope="col">Datum</th>
          </tr>
          </thead>
           <tbody>
            ';  //faktura, duguje, datum , pojedinacan saldo svakog kupca
        if($dugovanja != null){
          foreach ($dugovanja as $key => $value) {
            echo '
            <tr>
            <th scope="row">'.$value['sifra_fakture']. '</th>
            <td scope="row">'.$value['iznos_zaduzuje']. '</td>
            <td>' . date("d.m.Y",strtotime($value['datum'])) . '</td>
            </tr>
              ';
          }
        } 

        echo '
        </tbody>
        </table>
        </section>
        <section class="col-xs-12 col-sm-12 col-md-6">
        <span class="6">Istorija potrazuje:</span>
        <table class="table table-striped">
        <thead>
        <tr>
        <th scope="col">Broj izvoda</th>
        <th scope="col">Potrazuje iznos</th>
        <th scope="col">Datum</th>
        </tr>
        </thead>
        <tbody>
          '; //izvod, potrazuje, datum , pojedinacan saldo svakog kupca
        if($potrazivanja != null){
          foreach ($potrazivanja as $key => $value) {
            echo '
            <tr>
            <th scope="row">'.$value['broj_izvoda']. '</th>
            <td scope="row">'.$value['iznos_potrazuje']. '</td>
            <td>' . date("d.m.Y",strtotime($value['datum'])) . '</td>
            </tr>
              ';
          }
        }
        echo '
        </tbody>
        </table>
        </section>
        </div> 
        <br><hr><br><br>
          ';

     }
   }

}


$check = new User();
if ($errors) {
  
  echo "<h4> Pokusali smo da izvrsimo pretragu ali: </h4>";
  echo $check->output_errors($errors);
} 

?>




