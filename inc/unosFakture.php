<?php 
$errors = array();

$form = new FormHelper("POST","");
$form->open_tag();

echo "Sifra Fakture ";
$form->input('', 'input','sifra_fakture', '','','Upisite broj fakture', 'form-control');
echo "<br><br>";

echo "Firma ";
$firma = new Firma();
$lista_firme = $firma->prikaziFirmu();
$default_opcija_firme = 'Izaberi Firmu';
$form->selectQuery('', 'naziv_frime',$lista_firme,$default_opcija_firme, 'form-control');
echo "<br><br>";

echo "Kupac ";
$kupac = new Kupac(1);
$lista_kupci = $kupac->prikaziNazivKupca();
$default_opcija_kupci = 'Izaberi Kupca';
$form->selectQuery('', 'naziv_kupca',$lista_kupci,$default_opcija_kupci, 'form-control');
echo "<br><br>";

echo "Iznos zaduzuje ";
$form->input('', 'number' , 'iznos_zaduzuje', '', '', '0.00' , 'form-control');
echo " &#1044;&#1080;&#1085;&#46;";
echo "<br><br>";

echo "Datum ";
$danasnjiDatum = date("Y-m-d");
$form->input('', 'date', 'datepicker',$danasnjiDatum, '', '' , 'form-control');
echo "<br><br>";


$form->input('' ,'submit', 'dugme_unesi', 'Unesi Fakturu', 'return confirm("Da li ste sigurni da zelite da unesete fakturu?")', '', 'form-control btn btn-secondary mb-2'); 
$form->close_tag();






 if(isset($_POST['dugme_unesi'])){
	if(isset($_POST['sifra_fakture'])){
		$sifraFakture = $_POST['sifra_fakture'];
	}
 	if(isset($_POST['naziv_frime'])){
 		$firma = $_POST['naziv_frime'];
 	}
 	if(isset($_POST['naziv_kupca'])){
 		$kupac = $_POST['naziv_kupca'];
 	}
 	if(isset($_POST['iznos_zaduzuje'])){
 		$iznosZaduzuje = $_POST['iznos_zaduzuje'];
 	}
 	
 	$datum = date("Y-m-d H:i:s",strtotime($_POST['datepicker']));
 	

 	if(!$errors){
	 	if(!$sifraFakture|| !$firma || !$kupac || !$iznosZaduzuje || !$_POST['datepicker']){
	 		$errors[] = "Sva polja moraju biti popunjena, pokusajte opet.";
	 	}  
	 	if($sifraFakture && !is_numeric($sifraFakture)){
	 		$errors[] = "Polje Sifra Fakture mora biti broj.";
	 	}  
	 	if($iznosZaduzuje && $iznosZaduzuje<=0) {
	 		$errors[] = "Iznos fakture mora biti veci od nule.";
	 	}
	 	// if ($_POST['datepicker'] <= '01-01-1970') {
	 	// 	$errors[] = "Niste uneli ispravan datum.";
	 	// } 
	 	$fakture = new Faktura();
	 	if($sifraFakture && ($fakture->proveriDuplikate($sifraFakture,$firma,$kupac)===true)){
	 		$errors[] = "Faktura sa brojem ".$sifraFakture." vec postoji za kupca ".$kupac." na firmu ".$firma.".";
	 	} 
 	} 

 	if(!$errors) {
		$fakture = new Faktura();
	 	$fakture->unesiFakturu($sifraFakture,$firma,$kupac,$iznosZaduzuje,$datum);
	 	echo "Uspesno ste uneli fakturu.";
	}
 
 }

$check = new User();
if ($errors) {
	
	echo "<h4> Pokusali smo da unesemo fakutru ali: </h4>";
	echo $check->output_errors($errors);
} 

 ?>