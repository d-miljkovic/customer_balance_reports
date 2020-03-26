<?php
class Kupac {

	public $active = 1;

	public function __construct($active){
		$this->active = $active;
	}

	public function unesiKupca($sifra_kupca,$naziv_kupca,$status) {
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		mysqli_query($conn, "INSERT INTO kupci (sifra_kupca, naziv_kupca, active) VALUES ('{$sifra_kupca}', '{$naziv_kupca}', '{$status}')");

	}

	public function izmeniKupca($sifra_kupca,$naziv_kupca,$selCategory){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		mysqli_query($conn, "UPDATE kupci SET sifra_kupca = '{$sifra_kupca}', naziv_kupca='{$naziv_kupca}' WHERE sifra_kupca = '{$selCategory}'");
	}

	public function izmeniStatus($sifra_kupca,$status){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		mysqli_query($conn, "UPDATE kupci SET active = '{$status}' WHERE sifra_kupca = '{$sifra_kupca}' ");
	}	

	public function trajnoIzbrisi($sifra_kupca){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		mysqli_query($conn, "DELETE FROM kupci WHERE sifra_kupca = '{$sifra_kupca}' ");
		if (mysqli_error($conn)) {
			echo("Error description: " . mysqli_error($conn));
		}
		 
	}

	public function prikaziNazivKupca(){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$query = mysqli_query($conn, "SELECT naziv_kupca FROM kupci");
		while ($all = mysqli_fetch_all($query,MYSQLI_ASSOC)) {
			return($all);
		}
		
	}

	public function prikaziKupca(){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$query = mysqli_query($conn, "SELECT * FROM kupci");
		return $query;
		
	}

	public function prikaziAktivnogKupca(){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$query = mysqli_query($conn, "SELECT * FROM kupci WHERE active = 1");
		return $query;
		
	}

	public function prikaziKupcaPrekoSifre($cid){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$query = mysqli_query($conn, "SELECT * FROM kupci WHERE sifra_kupca = '{$cid}'");
		return mysqli_fetch_object($query);
	}

	public function proveriSifruKupca($sifra_kupca){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$query = mysqli_query($conn, "SELECT * FROM kupci WHERE sifra_kupca ='{$sifra_kupca}'");
		$object = mysqli_fetch_object($query);
		if($object){
			return true;
		}		
	}
	

}
