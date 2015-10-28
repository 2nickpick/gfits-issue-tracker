<?php
include('../../config.inc.php');

global $currentUser;

$response['success'] = false;
$errors = array();

if(empty($currentUser)) {
	$errors[] = "You must be logged in to perform this action.";
}

if(!empty($errors) &&
   !empty($_FILES) &&
   !empty($_POST['users_id'])
) {
	$file = $_FILES['profile-picture'];

	if($file['size'] > 0) {
		$user = User::loadById($_POST['users_id']);
	}
}

$response['success'] = true;
$response['users_id'] = $_POST['users_id'];
echo json_encode($response);
