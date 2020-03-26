<?php
$selektovana_sifra_kupca = -1;
$selektovan_naziv = "";
$selektovan_status = "";

$errors = array();
$status = array();

if(isset($_GET['cid'])){
	$kupac = new Kupac(1);
	$rw = $kupac->prikaziKupcaPrekoSifre($_GET['cid']);	
	if($rw){
		$selektovana_sifra_kupca = $rw->sifra_kupca;
		$selektovan_naziv = $rw->naziv_kupca;
		$selektovan_status = $rw->active;
	}
} 
if(isset($_POST['btn_insert'])){
	$selektovan_naziv = $_POST['tb_naziv'];
	$selektovana_sifra_kupca = $_POST['tb_sifra'];
	
	if(!$errors){	
		if(!$selektovan_naziv || !$selektovana_sifra_kupca) {
			$errors[] = "Sva polja moraju biti popunjena";
		} 
		if($selektovana_sifra_kupca && !is_numeric($selektovana_sifra_kupca)) {
			$errors[] =  "Sifra kupca mora biti numericka.";
		} 
		if ($selektovana_sifra_kupca && ($selektovana_sifra_kupca <= 0)) {
			$errors[] = "Sifra kupca mora biti veca od nule.";
		}
		if ($selektovana_sifra_kupca && ($kupac->proveriSifruKupca($selektovana_sifra_kupca))==true){
			$errors[] = "Kupac sa sifrom kupca ".$selektovana_sifra_kupca." vec postoji.";
		} 
		if(!$errors){
			$selektovan_status = 1; // po defaultu 1 da bi svaki novi kupac bio aktivan
			$kupac->unesiKupca($selektovana_sifra_kupca,$selektovan_naziv,$selektovan_status);
			$status[] = "Uspesno ste uneli kupca.";
		} 
	}
	
}
if(isset($_POST['btn_update'])){
	$selektovan_naziv = $_POST['tb_naziv'];
	$selektovana_sifra_kupca = $_POST['tb_sifra'];
	$selCategory = $_POST['selCategory'];

	if(!$errors){
		if(!$selektovan_naziv || !$selektovana_sifra_kupca || !$selCategory){
			$errors[] = "Sva polja moraju biti popunjena.";
		}
		if($selCategory<=0) {
			$errors[] = "Da biste izmenili kupca, morate prethodno izabrati kupca u polje Kupac.";
		}
		if($selektovana_sifra_kupca && ($selCategory!==$selektovana_sifra_kupca)){
			$errors[] = "Sifru kupca koju ste odabrali se ne poklapa sa sifrom izabranog kupca, molimo vas izaberite opet kupca kog zelite da azuritate.";
		}
		if($selektovana_sifra_kupca && ($kupac->proveriSifruKupca($selektovana_sifra_kupca)==false)){
			$errors[] = "Kupac sa sifrom kupca ".$selektovana_sifra_kupca." ne postoji.";
		}
		if(!$errors){
			$kupac->izmeniKupca($selektovana_sifra_kupca,$selektovan_naziv,$selCategory);
			$status[] = "Uspesno ste izmenili kupca.";			
		}
	}

}

if(isset($_POST['btn_activate'])){
	$selCategory = $_POST['selCategory'];
	$selektovana_sifra_kupca = $_POST['tb_sifra'];
	$selektovan_naziv = $_POST['tb_naziv'];

	if(!$errors){

		if(!$selCategory || !$selektovana_sifra_kupca || !$selektovan_naziv){
			$errors[] = "Sva polja moraju biti popunjena.";
		}
		if($selektovana_sifra_kupca && ($selCategory!==$selektovana_sifra_kupca)){
			$errors[] = "Izabrani kupac i sifra kupca moraju biti isti";
		}

		if(!$errors){
			$selektovan_status = 1;
			$kupac->izmeniStatus($selektovana_sifra_kupca,$selektovan_status);
			$status[] = "Uspesno ste aktivirali kupca";		
		}
		
	}
	
	
}
if(isset($_POST['btn_disable'])){
	$selCategory = $_POST['selCategory'];
	$selektovana_sifra_kupca = $_POST['tb_sifra'];
	$selektovan_naziv = $_POST['tb_naziv'];
	
	if(!$errors){

		if(!$selCategory || !$selektovana_sifra_kupca || !$selektovan_naziv){
			$errors[] = "Sva polja moraju biti popunjena.";
		}
		if($selektovana_sifra_kupca && ($selCategory!==$selektovana_sifra_kupca)){
			$errors[] = "Izabrani kupac i sifra kupca moraju biti isti";
		}
		if(!$errors){
			$selektovan_status = 0;
			$kupac->izmeniStatus($selektovana_sifra_kupca,$selektovan_status);
			$status[] = "Uspesno ste deaktivirali kupca";		
		}
		
	}
	
}

// brisanje - za potrebe administratora

// if(isset($_POST['btn_delete'])){
// 	$selektovana_sifra_kupca = $_POST['tb_sifra'];
// 	$kupac->trajnoIzbrisi($selektovana_sifra_kupca);
// 	echo "Uspesno ste izbrisali kupca";
	
// }

?>



<?php 
$form = new FormHelper("POST","");
$form->open_tag();
echo "Kupac ";
$q = $kupac->prikaziKupca();
$form->select1('window.location="?cid="+this.value','selCategory',$q,$selektovana_sifra_kupca,'form-control'); //onchange, name, query , selektovana_sifra_kupca, sifra_kupca

echo "<br><br>";
echo "Sifra kupca";
$form->input('','text','tb_sifra', ($selektovana_sifra_kupca>0?$selektovana_sifra_kupca:""),'','','form-control');// id ,type, name, value, onClick, placeholder, class

echo "<br><br>";
echo "Naziv kupca";
$form->input('','text','tb_naziv', $selektovan_naziv,'','','form-control');// id ,type, name, value, onClick, placeholder, class, disable


echo "<br><br>";
echo "Status kupca";


if(($selektovan_status==0)&&($selektovana_sifra_kupca<0)){
	$selektovan_status = '';
} else if ($selektovan_status==1) {
	$selektovan_status = 'aktivan';
} else {
	$selektovan_status = 'neaktivan';
}


$form->input('','text','tb_status',$selektovan_status, '', '', 'form-control', 'readonly');

echo "<br><br>";
$form->input('','submit', 'btn_insert', 'Dodaj novog kupca','return confirm("Da li ste sigurni da zelite da dodate kupca?")','','dugme_izmena btn btn-secondary');
$form->input('','submit', 'btn_update', 'Azuriraj kupca','return confirm("Da li ste sigurni da zelite da azurirate kupca?")','','dugme_izmena btn btn-secondary');

echo "<br><br>";

$form->input('','submit', 'btn_activate', 'Aktiviraj','return confirm("Da li ste sigurni da zelite da aktivirate kupca?")','','btn dugme_izmena btn-success');
$form->input('','submit', 'btn_disable', 'Deaktiviraj','return confirm("Da li ste sigurni da zelite da deaktivirate kupca?")','','btn dugme_izmena btn-danger');// id ,type, name, value, onClick, placeholder, class, disable




//ukoliko se koristi trajno brisanje iz baze
// echo "<br><br>";
// $form->input('','submit', 'btn_delete', 'Trajno izbrisi');

$form->close_tag();



$check = new User();
if ($errors) {
	
	if(isset($_POST['btn_insert'])){
		echo "<h4> Pokusali smo da unesemo kupca ali: </h4>";
		echo $check->output_errors($errors);
	}

	if(isset($_POST['btn_update'])){
		echo "<h4> Pokusali smo da azuriramo kupca ali: </h4>";
		echo $check->output_errors($errors);
	}

	if(isset($_POST['btn_activate'])){
		echo "<h4> Pokusali smo da aktiviramo kupca ali: </h4>";
		echo $check->output_errors($errors);
	}

	if(isset($_POST['btn_disable'])){
		echo "<h4> Pokusali smo da deaktivirmo kupca ali: </h4>";
		echo $check->output_errors($errors);
	}

} 

if ($status) {
	
	if(isset($_POST['btn_insert'])){
		echo "<br><h5>". $status[0] ."</h5>";
	}

	if(isset($_POST['btn_update'])){
		echo "<br><h5>". $status[0] ."</h5>";
	}

	if(isset($_POST['btn_activate'])){
		echo "<br><h5>". $status[0] ."</h5>";
	}

	if(isset($_POST['btn_disable'])){
		echo "<br><h5>". $status[0] ."</h5>";
	}
}

 ?>



