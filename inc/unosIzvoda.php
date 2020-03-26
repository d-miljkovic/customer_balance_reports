<?php 

$errors = array();

$form = new FormHelper("POST","");
$form->open_tag();

echo "Broj Izvoda ";
$form->input('', 'input','broj_izvoda', '', '', ' Upisite broj izvoda','form-control'); 
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
$form->selectQuery('', 'naziv_kupca',$lista_kupci,$default_opcija_kupci,'form-control');
echo "<br><br>";

echo "Iznos Potrazuje ";
$form->input('', 'number' , 'iznos_potrazuje', '', '', '0.00','form-control');
echo " &#1044;&#1080;&#1085;&#46;";
echo "<br><br>";

echo "Datum ";
$danasnjiDatum = date("Y-m-d");
$form->input('', 'date', 'datepicker', $danasnjiDatum ,'','','form-control'); 
echo "<br><br>"; 

$form->input('', 'submit', 'dugme_unesi', 'Unesi Izvod', 'return confirm("Da li ste sigurni da zelite da unesete izvod?")','','form-control btn btn-secondary mb-2'); 
$form->close_tag();






 if(isset($_POST['dugme_unesi'])){
 	if(isset($_POST['broj_izvoda'])){
 		$brojIzvoda = $_POST['broj_izvoda'];
 	}
 	if(isset($_POST['naziv_frime'])){
 		$nazivFirme = $_POST['naziv_frime'];
 	}
 	if(isset($_POST['naziv_kupca'])){
 		$nazivKupca = $_POST['naziv_kupca'];
 	}
 	if(isset($_POST['iznos_potrazuje'])){
 		$iznosPotrazuje = $_POST['iznos_potrazuje'];
 	}
 	
 	
 	
 	$datum = date("Y-m-d H:i:s",strtotime($_POST['datepicker']));
 	

 	if(!$errors){
	 	if(!$brojIzvoda|| !$nazivFirme || !$nazivKupca || !$iznosPotrazuje || !$_POST['datepicker']){
	 		$errors[] = "Sva polja moraju biti popunjena, pokusajte opet.";
	 	}  
	 	if ($brojIzvoda && !is_numeric($brojIzvoda)){
	 		$errors[] = "Polje Broj Izvoda mora biti broj.";
	 	}  
	 	if ($iznosPotrazuje && $iznosPotrazuje<=0) {
	 		$errors[] = "Iznos Potrazuje mora biti veci od nule.";
	 	}
	 	// if ($_POST['datepicker'] <= '01-01-1970') {
	 	// 	$errors[] = "Niste uneli ispravan datum.";
	 	// } 
	 	$izvodi = new Izvod();
	 	if ($brojIzvoda && ($izvodi->proveriDuplikate($brojIzvoda,$nazivFirme,$nazivKupca)===true)){
	 		$errors[] = "Izvod sa brojem ".$brojIzvoda." vec postoji za kupca ".$nazivKupca." na firmu ".$nazivFirme.".";
	 	} 
 	}

 	if(!$errors) {
 	$izvodi = new Izvod();
 	$izvodi->unesiIzvod($brojIzvoda,$nazivFirme,$nazivKupca,$iznosPotrazuje,$datum);
	 	echo "Uspesno ste uneli izvod.";
	}
 }


$check = new User();
if ($errors) {
	
	echo "<h4> Pokusali smo da unesemo izvod ali: </h4>";
	echo $check->output_errors($errors);
} 


 ?>


 