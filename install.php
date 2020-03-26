<?php 
require_once "config.php";

$conn = mysqli_connect(System::_DBHOST,System::_DBUSER,System::_DBPASS,System::_DBNAME);

// ---------------- kreiranje tabela

mysqli_query($conn, "
	CREATE TABLE `firme` (
	`id_firma` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`naziv_firme` varchar(45) DEFAULT NULL,
	PRIMARY KEY (`id_firma`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Tabela firme uspesno kreirana";


mysqli_query($conn, "
	CREATE TABLE `kupci` (
	`sifra_kupca` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`naziv_kupca` varchar(255) CHARACTER SET utf8 NOT NULL,
	`active` tinyint(4) DEFAULT NULL,
	PRIMARY KEY (`sifra_kupca`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Tabela kupci uspesno kreirana";


mysqli_query($conn, "
	CREATE TABLE `korisnici` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(32) NOT NULL,
	`password` varchar(32) NOT NULL,
	`first_name` varchar(32) NOT NULL,
	`last_name` varchar(32) NOT NULL,
	`email` varchar(32) NOT NULL,
	PRIMARY KEY (`user_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Tabela korisnici uspesno kreirana";


mysqli_query($conn, "
	CREATE TABLE `fakture` (
	`sifra_fakture` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
	`firme_id_firma` int(10) unsigned NOT NULL,
	`kupci_sifra_kupca` int(10) unsigned NOT NULL,
	`iznos_zaduzuje` int(10) unsigned NOT NULL,
	`datum` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`sifra_fakture`,`firme_id_firma`,`kupci_sifra_kupca`),
	KEY `faktura_sa_kupcem` (`kupci_sifra_kupca`),
	KEY `faktura_za_firmu` (`firme_id_firma`),
	KEY `sifra_fakture` (`sifra_fakture`) USING BTREE,
	CONSTRAINT `fk1_faktura_za_firmu` FOREIGN KEY (`firme_id_firma`) REFERENCES `firme` (`id_firma`),
	CONSTRAINT `fk2_faktura_sa_kupcem` FOREIGN KEY (`kupci_sifra_kupca`) REFERENCES `kupci` (`sifra_kupca`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Tabela fakture uspesno kreirana";


mysqli_query($conn, "
	CREATE TABLE `izvodi` (
	`broj_izvoda` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
	`kupci_sifra_kupca` int(10) unsigned NOT NULL,
	`firme_id_firma` int(10) unsigned NOT NULL,
	`iznos_potrazuje` int(10) unsigned DEFAULT NULL,
	`datum` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`broj_izvoda`,`kupci_sifra_kupca`,`firme_id_firma`),
	KEY `izvod_firme` (`firme_id_firma`),
	KEY `izvod_kupca` (`kupci_sifra_kupca`),
	CONSTRAINT `fk1_izvod_firme` FOREIGN KEY (`firme_id_firma`) REFERENCES `firme` (`id_firma`),
	CONSTRAINT `fk2_	izvod_kupca` FOREIGN KEY (`kupci_sifra_kupca`) REFERENCES `kupci` (`sifra_kupca`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Tabela izvodi uspesno kreirana";


// -------- inicijalni podaci



// inicijalni korisnici - admin
$user = 'admin';
$password = md5('admin');
mysqli_query($conn, "
	INSERT INTO `korisnici` VALUES (1,'{$user}','{$password}','Dusan','Miljkovic','dushan990@gmail.com');
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Uspesno ste insertovali korisnike";


// inicijalne firme
mysqli_query($conn, "
	INSERT INTO `firme` VALUES (1,'BIG BIF 016 DOO'),(2,'BIG TEAM 016 DOO');
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Uspesno ste insertovali firme";



// inicijalni kupci
mysqli_query($conn, "
	INSERT INTO `kupci` VALUES (100118025,'STRIP AKSA',1),(100201545,'GROS TRADE',1),(100225673,'KRISTAL',1),(101023877,'MAVIJAN',1);
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Uspesno ste insertovali kupce";


// inicijalni podaci fakture
mysqli_query($conn, "
	INSERT INTO `fakture` (`sifra_fakture`, `firme_id_firma`, `kupci_sifra_kupca`, `iznos_zaduzuje`, `datum`) VALUES
	('001', 1, 100118025, 1000, '2020-02-29 23:00:00'),
	('001', 2, 100118025, 2000, '2020-03-01 23:00:00');
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]=" Uspesno ste insertovali fakture";


// inicijalni podaci izvodi
mysqli_query($conn, "
	INSERT INTO `izvodi` (`broj_izvoda`, `kupci_sifra_kupca`, `firme_id_firma`, `iznos_potrazuje`, `datum`) VALUES
	('001', 100118025, 1, 500, '2020-03-24 23:00:00'),
	('001', 100118025, 2, 500, '2020-03-24 23:00:00');
");
mysqli_error($conn)?$errors[]= mysqli_error($conn): $message[]="Uspesno ste insertovali izvode";




// ------ obavestenje
$check = new User();
if ($errors) {
	
	echo "<h4> Pokusali smo da izvrsimo upit ali: </h4>";
	echo $check->output_errors($errors);
}

if ($message) {
	
	echo $check->output_message($message);
}  


 ?>