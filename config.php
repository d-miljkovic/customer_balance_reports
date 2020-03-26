<?php 

function my_autoloader($class) {
    require 'classes/' . $class . '.class.php';
}

spl_autoload_register('my_autoloader');

// 
error_reporting(0);


session_start();
?>