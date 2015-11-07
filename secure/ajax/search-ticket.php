<?php
include( '../../config.inc.php' );

global $currentUser;

$errors = array();
$json   = array();

$tickets = array();
if ( empty( $_POST['search'] ) ) {
	$tickets = Ticket::loadAll( '', array(), true, @$_POST['order_by'] );
} else {
	$tickets = Ticket::loadBySearch( $_POST['search'], @$_POST['order_by'] );
}

foreach ( $tickets as $i => $ticket ) {

	if ( ! empty( $ticket->getDateLastReplied() ) ) {
		$last_reply = date( 'M d, Y h:i A', $ticket->getDateLastReplied() );
	} else {
		$last_reply = 'N/A';
	}

	$json[ $i ] = array(
		'id'          => $ticket->getId(),
		'title'       => $ticket->getIssueTitle(),
		'opened_by'   => $ticket->getOpenedBy()->getFirstName() . ' ' . $ticket->getOpenedBy()->getLastName(),
		'date_opened' => date( 'M d, Y h:i A', $ticket->getDateOpened() ),
		'category'    => $ticket->getCategory()->getDescription(),
		'description' => $ticket->getDescription(),
		'last_reply'  => $last_reply,
		'open'        => $ticket->isOpen()
	);
}

echo json_encode( $json );

