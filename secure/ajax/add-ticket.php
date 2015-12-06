<?php
include('../../config.inc.php');

global $currentUser;

$response['success'] = false;
$errors = array();

if(empty($currentUser)) {
	$errors[] = 'You must be logged in to perform this action.';
}

if(empty($_POST['message'])) {
	$errors[] = 'Message is required';
}

if(empty($errors)) {
	$ticket = new Ticket(
		array(
			'issue_title' => $_POST['title'],
			'description' => $_POST['message'],
			'opened_by' => array('id'=>$currentUser->getId()),
			'category' => array('id'=>1),
			'date_opened' => time()
		)
	);

	if($ticket->add()) {
		$response['success'] = true;
		$response['tickets_id'] = $ticket->getId();
	} else {
		$response['error'] = "Adding the new ticket failed.";
	}
} else {
	$response['error'] = implode("<br />", $errors);
}

echo json_encode($response);
