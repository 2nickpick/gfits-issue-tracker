<?php
include('../config.inc.php');

global $currentUser;

$response['success'] = false;

if(!empty($_POST['email']) && !empty($_POST['password'])) {
	$login = User::login($_POST['email'], $_POST['password']);
	if(!empty($login)) {
		$currentUser = $login;
		$_SESSION['users_id'] = $currentUser->getId();

		$response['success'] = true;
	} else {
		$response['error'] = "Invalid Email or Password.";
	}
} else {
	$response['error'] = "You must provide an email and password.";
}

echo json_encode($response);
