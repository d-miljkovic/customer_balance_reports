<?php 
require_once "config.php";

$check = new User();

if (empty($_POST) === false){

	$username = $_POST['username'];
	$password = $_POST['password'];


	if (empty($username) === true || empty($password) === true){
		$errors[] = "Potrebno je da unesete korisnicko ime i lozinku.";
	} else if ($check->CheckUser($username) === false){
		$errors[] = "Nismo uspeli da nadjemo korisnicko ime koje ste uneli, da li ste registrovani?";
	} else {

		if (strlen($password)>32) {
			$errors[] = "Lozinka je predugacka";
		}

		$login = $check->login($username, $password);
		if ($login === false){
			$errors[] = "Kombinacija korisnicko ime/loznika nije tacna.";
		} else {
			//set the user session
			//redirect user to home
			session_start();
			$_SESSION['user_id'] = $login;
			$_SESSION['username'] = $username;
			header("Location: index_pretraga.php");
			exit();

		}
	}

	
} else {
	$errors[] = "No data recived.";
}
if (empty($errors === false)) {
	include 'index.php';
}


?>
