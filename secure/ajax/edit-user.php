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

$user = null;
if(empty($_POST['users_id'])) {
	$errors[] = 'User ID was not provided.';
} else {
	$user = User::loadById($_POST['users_id']);
	if(empty($user)) {
		$errors[] = 'User could not be found. May have been deleted.';
	}
}

if(empty($errors)) {
	$user->setFirstName($_POST['first_name']);
	$user->setLastName($_POST['last_name']);
	$user->setEmailAddress($_POST['email_address']);
	$user->setPhoneNumber($_POST['phone_number']);
	$user->setCellPhoneCarrierId($_POST['cell_phone_carrier_id']);
	$user->setPassword($_POST['password']);
	$user->setTypeId($_POST['type_id']);

	if($user->update()) {

		$response['success'] = true;
		$response['users_id'] = $user->getId();
	} else {
		$response['error'] = "Updating the user failed.";
	}
} else {
	$response['error'] = implode("<br />", $errors);
}

echo json_encode($response);
