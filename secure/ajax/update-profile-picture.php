<?php
include('../../config.inc.php');
require_once('../../vendor/picture-cut/src/php/core/PictureCut.php');

global $currentUser;

$response['success'] = false;
$errors = array();

$pictureCut = PictureCut::createSingleton();

if(empty($currentUser)) {
	$errors[] = "You must be logged in to perform this action.";
}

if(empty($pictureCut)) {
	$errors[] = "Error occurred uploading picture.";
}

if(empty($errors)) {
	try {
		if($pictureCut->upload()){
			$currentUser->setProfilePicture($pictureCut->getFileNewName());
			$currentUser->update();
			print $pictureCut->toJson();
		} else {
			print $pictureCut->exceptionsToJson();
		}

	} catch (Exception $e) {
		print $e->getMessage();
	}
} else {
	echo json_encode($errors);
}

