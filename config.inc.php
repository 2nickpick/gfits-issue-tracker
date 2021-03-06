<?php

session_start();
date_default_timezone_set('America/New_York');

/* set up PDO connection */
define('DB_NAME', 'group4');
define('DB_USER', 'group4');
define('DB_PASS', 'Fall2015376549');
define('DB_HOST', 'localhost');

global $con;
try {
	$con = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASS);
	$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$con->exec("SET CHARACTER SET utf8");  //  return all sql requests as UTF-8
}
catch (PDOException $err) {
	echo "An error occurred setting up the database: " . $err->getMessage() . "<br/>";
	die();  //  terminate connection
}

/* Set up defines */
$_SERVER['DOCUMENT_ROOT'] = '/home/group4/public_html';

/* Include relevant classes */
include 'includes/Users.inc.php';
include 'includes/Tickets.inc.php';

/* Handle User Authentication */
global $currentUser;
if(!empty($_SESSION['users_id'])) {
	$currentUser = User::loadById($_SESSION['users_id']);
}

