<?php 
require_once "config.php";

$form = new FormHelper("POST","login.php");
$form->open_tag();

echo "Korisnicko ime: <br>";
$form->input('', 'text', 'username','', '', '' , 'form-control');
echo "<br><br>";

echo "Lozinka: <br>";
$form->input('', 'password', 'password','', '', '' , 'form-control');
echo "<br><br>";

$form->input('' ,'submit', 'btn_submit', 'Prijavi se', '', '', 'btn btn-secondary mb-2 form-control');  



if($_POST['btn_submit'])
{
	echo $check->output_errors($errors);
}

?>


