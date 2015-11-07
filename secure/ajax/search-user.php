<?php
include( '../../config.inc.php' );

global $currentUser;

$errors = array();
$json   = array();

$users = array();
if ( empty( $_POST['search'] ) ) {
	$users = User::loadAll('', array(), true, @$_POST['order_by']);
} else {
	$users = User::loadBySearch( $_POST['search'], @$_POST['order_by'] );
}

foreach ( $users as $i => $user ) {
	$json[ $i ] = array(
		'id'            => $user->getId(),
		'first_name'    => $user->getFirstName(),
		'last_name'     => $user->getLastName(),
		'email_address' => $user->getEmailAddress(),
		'phone_number'  => $user->getPhoneNumber(),
		'role'          => $user->getType()->getName()
	);
}

echo json_encode( $json );

