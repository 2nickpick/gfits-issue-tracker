<?php
include('../config.inc.php');

$response['success'] = false;

if(!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['message'])) {
	$success = User::contactUs($_POST['name'], $_POST['email'], $_POST['message']);
	if($success) {
		$response['success'] = true;
	} else {
		$response['error'] = "Required Field Missing";
	}
} else {
	$response['error'] = "You must provide your name, email address and a message.";
}

echo json_encode($response);
