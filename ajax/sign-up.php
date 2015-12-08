<?php
include('../config.inc.php');

global $currentUser;

$response['success'] = false;

if(empty($_POST['first_name'])) {
	 $response['error'][] = 'First Name is required';
}
if(empty($_POST['last_name'])) {
	 $response['error'][] = 'Last Name is required';
}
if(empty($_POST['email_address'])) {
	 $response['error'][] = 'Email is required';
}

$cell = $_POST['cell'];
if(empty($_POST['cell'])) {
	$response['error'][] = 'Cell Phone is required';
} else {
	$cell = str_replace('-', '', $cell); //replace dashes from phone number
	$cell = str_replace('(', '', $cell); //replace open paren from phone number
	$cell = str_replace(')', '', $cell); //replace close paren from phone number
	$cell = str_replace(' ', '', $cell); //replace spaces from phone number
}

$cell_phone_carrier_id = $_POST['cell_carrier'];
$cell_phone_carrier = NULL;
if(empty($_POST['cell_carrier'])) {
	$response['error'][] = 'Cell Phone Carrier is required';
} else {
	$cell_phone_carrier_id = $_POST['cell_carrier'];
	$cell_phone_carrier = CellPhoneCarrier::loadById($cell_phone_carrier_id);
}

if(empty($_POST['password'])) {
	$response['error'][] = 'Password is required';
}
if(empty($_POST['password_confirm'])) {
	$response['error'][] = 'Confirm Password is required';
}
if($_POST['password'] != $_POST['password_confirm']) {
	$response['error'][] = 'Passwords do not match';
}

if(empty($response['error'])) {

	$user = new User(
		array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email_address' => $_POST['email_address'],
			'phone_number' => $cell,
			'cell_phone_carrier_id' => $_POST['cell_carrier'],
			'password' => $_POST['password'],
			'password_again' => $_POST['password_confirm'],
			'type_id' => 1
		)
	);

	if($user->add()) {
		$response['success'] = true;

		// email and text a welcome message
		$email = $_POST['email_address'];
		$subject = "Thank you for registering!";

		$msg_body = "Thank you for registering with GFITS! ";
		$msg_body .= "We are confident that you will enjoy your user experience on our web site. ";
		$msg_body .= "Here is your registration information: ";
		$msg_body .= "Name: " . htmlentities($_POST['first_name'] . ' ' .  $_POST['last_name']) . " | ";
		$msg_body .= "Email: " . htmlentities($_POST['email_address']) . " | ";
		$msg_body .= "Cell Phone: " . htmlentities($cell) . " | ";
		$msg_body .= "Cell Phone Carrier:" . htmlentities($cell_phone_carrier->getName()) . " | ";

		$msg_body .= "Please remember to vote for us!";

		// Send a text to phone, if info was provided
		if (!empty($cell_phone_carrier) && !empty($cell))
		{
			$cell_email = $cell . "@" . $cell_phone_carrier->getEmailDomain();
		}
		$response['success_url'] = "http://candidcarter.com/cop4813_mail.php?email=".$email."&subject=".$subject."&body=".$msg_body."&email2=".$cell_email;
	} else {
		$response['error'] = "User could not be created at this time.";
	}
} else {
	$response['error'] = implode("\n", $response['error']);
}

echo json_encode($response);

