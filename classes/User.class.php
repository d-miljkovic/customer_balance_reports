<?php 
class User

{

	public function sanitize($data) {
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		return mysqli_real_escape_string($conn,$data);
	}

	public function array_sanitize(&$item) {
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		return mysqli_real_escape_string($conn,$item);
	}

	public  function CheckUser($username) {

		$username = self::sanitize($username);
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$query = mysqli_query($conn, "select `user_id` from `korisnici` where `username` = '$username'");
		$count = mysqli_num_rows($query);
		return (($count==true) ? true : false);

	}

	public  function CheckEmail($email) {

		$email = self::sanitize($email);
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$query = mysqli_query($conn, "select `email` from `korisnici` where `email` = '$email'");
		$count = mysqli_num_rows($query);
		return (($count==true) ? true : false);

	}

	public function user_id_from_username($username){
		$username = self::sanitize($username);
		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		return $query = mysqli_query($conn, "select `user_id` from `korisnici` where `username` = '$username'");

	}

	public function login($username, $password){
		$user_id = self::user_id_from_username($username);
		$username = self::sanitize($username);
		$password = md5($password);

		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
			$query = mysqli_query($conn, "select `user_id` from `korisnici` where `username` = '$username' and `password` = '$password'");
			$count = mysqli_num_rows($query);
			return (($count==true) ? true : false);

	}

	public function logged_in(){
		session_start();
		return (isset($_SESSION['user_id'])) ? true : false;
	}

	public function register_user($register_data) {
		array_walk($register_data, self::array_sanitize());
		$register_data['password'] = md5($register_data['password']);
		
		$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
		$data = '\'' . implode('\', \'', $register_data) . '\'';

		$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);
		$query = mysqli_query($conn,"INSERT INTO `korisnici` ($fields) VALUES ($data)");
	}


	public function output_errors($errors){
		return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
	}
	public function output_message($message){
		return '<ul><li>' . implode('</li><li>', $message) . '</li></ul>';
	}

}


