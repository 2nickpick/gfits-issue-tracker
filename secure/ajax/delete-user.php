<?php
include('../../config.inc.php');

global $currentUser;

$response['success'] = false;
$errors = array();

if(empty($currentUser)) {
	$errors[] = 'You must be logged in to perform this action.';
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
	if($user->delete()) {
		$response['success'] = true;
		$response['users_id'] = $user->getId();
	} else {
		$response['error'] = "Deleting the user failed.";
	}
} else {
	$response['error'] = implode("<br />", $errors);
}

echo json_encode($response);
