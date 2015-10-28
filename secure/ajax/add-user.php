<?php
include('../../config.inc.php');

global $currentUser;

$response['success'] = false;
$errors = array();

if(empty($currentUser)) {
	$errors[] = 'You must be logged in to perform this action.';
}

if(empty($_POST['first_name'])) {
	$errors[] = 'First name is required';
}

if(empty($_POST['last_name'])) {
	$errors[] = 'Last name is required';
}

if(empty($_POST['phone_number'])) {
	$errors[] = 'Phone number is required';
}

if(empty($_POST['email_address'])) {
	$errors[] = 'Email Address is required';
}

if(!empty($_POST['password'])) {
	if(strlen($_POST['password']) < 8) {
		$errors[] = 'Your password must be at least 8 characters long.';
	}

	if($_POST['password_again'] !== $_POST['password']) {
		$errors[] = 'Your passwords did not match.';
	}
}

if(empty($errors)) {
	$user = new User(
		array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email_address' => $_POST['email_address'],
			'phone_number' => $_POST['phone_number'],
			'cell_phone_carrier_id' => $_POST['cell_phone_carrier_id'],
			'type_id' => $_POST['type_id'],
			'password' => $_POST['password']
		)
	);

	if($user->add()) {
		$response['success'] = true;
		$response['users_id'] = $user->getId();
	} else {
		$response['error'] = "Adding the new user failed.";
	}
} else {
	$response['error'] = implode("<br />", $errors);
}

echo json_encode($response);
