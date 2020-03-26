<?php 
class Saldo {

	public function izracunajSaldo($sifraKupca,$nazivFirme,$datum){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");

		
		$idFirma = mysqli_fetch_object(mysqli_query($conn, "SELECT id_firma FROM firme WHERE naziv_firme = '{$nazivFirme}' "));


		$duguje =  mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(iznos_zaduzuje) AS duguje FROM fakture WHERE kupci_sifra_kupca = '{$sifraKupca}' AND firme_id_firma = '{$idFirma->id_firma}' AND datum <= '{$datum}' "));
		
		$potrazuje =  mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(iznos_potrazuje) AS potrazuje FROM izvodi WHERE kupci_sifra_kupca = '{$sifraKupca}' AND firme_id_firma = '{$idFirma->id_firma}' AND datum <= '{$datum}' "));
		

		
		$saldo = -$duguje->duguje + $potrazuje->potrazuje;
		return $saldo;


	}

}


