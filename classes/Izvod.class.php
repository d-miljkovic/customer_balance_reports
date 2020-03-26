<?php 
class Izvod{

	public function unesiIzvod($broj_izvoda,$naziv_frime,$naziv_kupca,$iznos_potrazuje, $datum){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$naziv_frime = mysqli_fetch_object(mysqli_query($conn, "SELECT id_firma FROM firme WHERE naziv_firme = '{$naziv_frime}'"));
		$naziv_kupca = mysqli_fetch_object(mysqli_query($conn, "SELECT sifra_kupca FROM kupci WHERE naziv_kupca = '{$naziv_kupca}'"));

		mysqli_query($conn, "INSERT INTO izvodi (broj_izvoda, kupci_sifra_kupca, firme_id_firma, iznos_potrazuje, datum) VALUES ('{$broj_izvoda}', '{$naziv_kupca->sifra_kupca}', '{$naziv_frime->id_firma}', '{$iznos_potrazuje}', '{$datum}')");
		echo mysqli_error($conn);
	}

	public function proveriDuplikate($broj_izvoda,$naziv_frime,$naziv_kupca){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		
		$id_firma = mysqli_fetch_object(mysqli_query($conn, "SELECT id_firma FROM firme WHERE naziv_firme = '{$naziv_frime}'"));

		$id_kupac = mysqli_fetch_object(mysqli_query($conn, "SELECT sifra_kupca FROM kupci WHERE naziv_kupca = '{$naziv_kupca}'"));

		$query = mysqli_query($conn, "SELECT * FROM izvodi WHERE broj_izvoda='{$broj_izvoda}' AND firme_id_firma={$id_firma->id_firma} AND kupci_sifra_kupca={$id_kupac->sifra_kupca}");
		$object = mysqli_fetch_object($query);
		if ($object) {
			return true;
		}
		
	}

	public function prikaziPotrazuje($sifra_kupca,$nazivFirme){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$idFirma = mysqli_fetch_object(mysqli_query($conn, "SELECT id_firma FROM firme WHERE naziv_firme = '{$nazivFirme}' "));
		$query = mysqli_query($conn, "SELECT broj_izvoda,iznos_potrazuje,datum FROM izvodi WHERE kupci_sifra_kupca='{$sifra_kupca}' AND firme_id_firma = '{$idFirma->id_firma}' ORDER BY datum");
	
		while ($all = mysqli_fetch_all($query,MYSQLI_ASSOC)) {
			return($all);
		}
	}	
}

 ?>