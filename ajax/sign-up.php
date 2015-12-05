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
		$subject = "Thank You for Registering with GFITS!";

		$msg_body = "<html><head></head><body>";
		$msg_body .= "<font face=\"Verdana\" size=\"2\"><p>Thank you for registering with GFITS! ";
		$msg_body .= "We are confident that you will enjoy your user experience on our web site.</p>";
		$msg_body .= "<p>Below is your registration information:</p>";

		$msg_body .= "<div style=\"width:400px;padding:5px;border-style:solid;border-color:#333333;border-width:0.5px;\">";
		$msg_body .= "<b>Name:</b> " . htmlentities($_POST['first_name'] . ' ' .  $_POST['last_name']) . "<br>";
		$msg_body .= "<b>Email:</b>  <a href=\"mailto:" . htmlentities($_POST['email_address']) . "\">" . htmlentities($_POST['email_address']) . "</a><br>";
		$msg_body .= "<b>Cell Phone:</b>  " . htmlentities($cell) . "<br>";
		$msg_body .= "<b>Cell Phone Carrier:</b>  " . htmlentities($cell_phone_carrier->getName()) . "</div>";

		$msg_body .= "<p>Please remember to vote for us!</p>";
		$msg_body .= "</font></body></html>";

		// required header info
		$header_info = "MIME-Version: 1.0\r\n";
		$header_info .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$header_info .= "From: GFITS <website@gfits.com>";

		// send the message via email
		mail($_POST['email_address'], $subject, $msg_body, $header_info);

		// Send a text to phone, if info was provided
		if (!empty($cell_phone_carrier) && !empty($cell))
		{
			$cell_email = $cell . "@" . $cell_phone_carrier->getEmailDomain();
			$subject = "Thank you for registering!";

			$msg_body = "Thank you for registering with GFITS!\r\n";
			$msg_body .= "We are confident that you will enjoy your user experience on our web site.\r\n";
			$msg_body .= "\r\nBelow is your registration information:\r\n";

			$msg_body .= "Name: " . htmlentities($_POST['first_name'] . ' ' .  $_POST['last_name']) . "\r\n";
			$msg_body .= "Email: " . htmlentities($_POST['email_address']) . "\r\n";
			$msg_body .= "Cell Phone: " . htmlentities($cell) . "\r\n";
			$msg_body .= "Cell Phone Carrier:" . htmlentities($_POST['cell_carrier']) . "\r\n";

			$msg_body .= "\r\nPlease remember to vote for us!\r\n";

			$header_info = "MIME-Version: 1.0\r\n";
			$header_info .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$header_info .= "From: website@gfits.com";
			mail($cell_email, $subject, $msg_body, $header_info);
		}
	} else {
		$response['error'] = "User could not be created at this time.";
	}
} else {
	$response['error'] = implode("\n", $response['error']);
}

echo json_encode($response);

