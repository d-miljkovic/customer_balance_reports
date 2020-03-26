<?php

class Firma {

	public function prikaziFirmu(){
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$conn->set_charset("utf8");
		$query = mysqli_query($conn, "SELECT naziv_firme FROM firme");
		while ($all = mysqli_fetch_all($query,MYSQLI_ASSOC)) {
			return($all);
		}
		
	}

	

}
