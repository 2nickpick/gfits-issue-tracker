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

$ticket = Ticket::loadByID(@$_POST['tickets_id']);
if(empty($ticket)) {
	$errors[] = 'No ticket was found.';
}

if(empty($errors)) {
	$ticket_note = new TicketNote(
		array(
			'ticket' => array('id' => $_POST['tickets_id']),
			'user' => array('id' => $currentUser->getId()),
			'status' => array('id' => 1),
			'note_text' => $_POST['message'],
			'date' => time()
		)
	);

	if($ticket_note->add()) {
		$response['success'] = true;
		$response['ticket_notes_id'] = $ticket_note->getId();
		$response['tickets_id'] = $ticket->getId();
	} else {
		$response['error'] = "Adding the new ticket failed.";
	}
} else {
	$response['error'] = implode("<br />", $errors);
}

echo json_encode($response);
