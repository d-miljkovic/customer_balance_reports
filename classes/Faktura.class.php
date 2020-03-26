<?php 
class Faktura {

	public function unesiFakturu($sifra_fakture,$naziv_frime,$naziv_kupca,$iznos_zaduzuje, $datum){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$naziv_frime = mysqli_fetch_object(mysqli_query($conn, "SELECT id_firma FROM firme WHERE naziv_firme = '{$naziv_frime}'"));
		$naziv_kupca = mysqli_fetch_object(mysqli_query($conn, "SELECT sifra_kupca FROM kupci WHERE naziv_kupca = '{$naziv_kupca}'"));

		mysqli_query($conn, "INSERT INTO fakture (sifra_fakture, firme_id_firma, kupci_sifra_kupca, iznos_zaduzuje, datum) VALUES ('{$sifra_fakture}', '{$naziv_frime->id_firma}', '{$naziv_kupca->sifra_kupca}', '{$iznos_zaduzuje}', '{$datum}')");

		echo mysqli_error($conn);
	

	}


	public function proveriDuplikate($sifra_fakture,$naziv_frime,$naziv_kupca){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		
		$id_firma = mysqli_fetch_object(mysqli_query($conn, "SELECT id_firma FROM firme WHERE naziv_firme = '{$naziv_frime}'"));

		$id_kupac = mysqli_fetch_object(mysqli_query($conn, "SELECT sifra_kupca FROM kupci WHERE naziv_kupca = '{$naziv_kupca}'"));

		$query = mysqli_query($conn, "SELECT * FROM fakture WHERE sifra_fakture='{$sifra_fakture}' AND firme_id_firma={$id_firma->id_firma} AND kupci_sifra_kupca={$id_kupac->sifra_kupca}");
		$object = mysqli_fetch_object($query);
		if ($object) {
			return true;
		}
		
	}


	public function proveriSifruFakture($sifra_fakture,$naziv_frime){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");

		$id_firma = mysqli_fetch_object(mysqli_query($conn, "SELECT id_firma FROM firme WHERE naziv_firme = '{$naziv_frime}'"));

		$query = mysqli_query($conn, "SELECT * FROM fakture WHERE sifra_fakture='{$sifra_fakture}' AND firme_id_firma={$id_firma->id_firma}");
		$object = mysqli_fetch_object($query);
		if ($object) {
			return true;
		}
		
	}

	public function prikaziDuguje($sifra_kupca,$nazivFirme){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$idFirma = mysqli_fetch_object(mysqli_query($conn, "SELECT id_firma FROM firme WHERE naziv_firme = '{$nazivFirme}' "));
		$query = mysqli_query($conn, "SELECT sifra_fakture,iznos_zaduzuje,datum FROM fakture WHERE kupci_sifra_kupca='{$sifra_kupca}' AND firme_id_firma = '{$idFirma->id_firma}' ORDER BY datum");
	
		while ($all = mysqli_fetch_all($query,MYSQLI_ASSOC)) {
			return($all);
		}
	}
}


?>



