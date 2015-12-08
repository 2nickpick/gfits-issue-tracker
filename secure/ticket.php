<?php include( 'head.php' ); ?>
<?php
global $currentUser;
$ticket = null;
if ( ! empty( $_GET['tickets_id'] ) ) {
	$ticket = Ticket::loadById( $_GET['tickets_id'] );
}
?>

<?php
if ( empty( $ticket ) ) {
	?>
	<div class="alert alert-danger">
		Ticket was not found! <a href="/~group4/secure/dashboard.php">Back to Dashboard</a>
	</div>
	<?php
} else {
	?>
	<div class="page-header">
		<h1>
			<?php echo htmlentities( $ticket->getIssueTitle() ); ?>
		</h1>
		<?php
		if ( $ticket->isOpen() ) {
			?>
			<span class="label label-warning">Open</span>
			<?php
		} else {
			?>
			<span class="label label-success">Closed</span>
			<?php
		}
		?>
	</div>

	<div class="row">
		<div class="well clearfix">
			<div class="col-sm-2 text-center">

				<img class="profile-picture" src="<?php
					if(!empty($ticket->getOpenedBy()->getProfilePicture())) {
						echo '/~group4/images/uploads/'.$ticket->getOpenedBy()->getProfilePicture();
					} else {
						echo '/~group4/images/default.png';
					}
				?>" />

				<p><strong><?php echo htmlentities( $ticket->getOpenedBy()->getFirstName() . ' '
				                                    . $ticket->getOpenedBy()->getLastName() ) ?></strong></p>

				<p><strong><?php echo date( 'M d, Y h:i A', $ticket->getDateOpened() ) ?></strong></p>
			</div>
			<div class="col-sm-10">
				<?php echo htmlentities($ticket->getDescription(), ENT_QUOTES, 'UTF-8') ?>
			</div>
		</div>
	</div>

	<?php
	$notes = $ticket->getNotes();
	foreach ( $notes as $note ) {
		?>
		<div class="row">
			<div class="well clearfix">
				<div class="col-sm-2 text-center">
					<img class="profile-picture" src="<?php
						if(!empty($note->getUser()->getProfilePicture())) {
							echo '/~group4/images/uploads/'.$note->getUser()->getProfilePicture();
						} else {
							echo '/~group4/images/default.png';
						}
					?>" />

					<p>
						<strong>
							<?php echo htmlentities($note->getUser()->getFirstName() . ' ' . $note->getUser()->getLastName()) ?>
						</strong>
					</p>

					<p><span class="label label-default">Trusted Staff Member</span></p>

					<p><strong><?php echo date( 'M d, Y h:i A', $note->getDate()) ?></strong></p>
				</div>
				<div class="col-sm-10">
					<?php echo htmlentities($note->getNoteText()) ?>
				</div>
			</div>
		</div>
		<?php
	}
	?>

	<form id="update-ticket-form" class="form" onsubmit="BackEnd.updateTicket(); return false;"
	      enctype="multipart/form-data">
		<input type="hidden" name="tickets_id" id="inputTicketsId" value="<?php echo $ticket->getId() ?>" />

		<hr/>

		<div id="errors-container">
			<div class="alert alert-warning">
				<strong>Required Field Missing!</strong>
			</div>
		</div>

		<h3>Add a Response</h3>

		<div id="errors-container">
			<div class="alert alert-warning">
				<strong>Required Field Missing!</strong> Your message is too short! Make it longer to show success!
			</div>
		</div>

		<div id="success-container">
			<div class="alert alert-success">
				<strong>Success!</strong> We have received your ticket and a support specialist will respond shortly!
			</div>
		</div>

		<div class="row">
			<div class="col-sm-2">
				<img class="profile-picture" src="<?php
				if(!empty($currentUser->getProfilePicture())) {
					echo '/~group4/images/uploads/'.$currentUser->getProfilePicture();
				} else {
					echo '/~group4/images/default.png';
				}
				?>" />
			</div>
			<div class="col-sm-6">
				<label for="inputName">Name</label>
				<input type="text" id="inputName" class="form-control"
				       value="<?php echo htmlentities($currentUser->getFirstName() . ' ' . $currentUser->getLastName()) ?>"
				       disabled required autofocus>
			</div>
			<div class="col-sm-4">
				<label for="inputDate">Date</label>
				<input type="text" id="inputDate" class="form-control" value="<?php echo date( 'M d, Y' ) ?>" disabled
				       required autofocus>
			</div>
		</div>

		<label for="inputMessage">Add a message to this ticket:</label>
		<textarea id="inputMessage" class="form-control" required></textarea>

		<div class="row">
			<div class="col-sm-6">
				<?php
				if ( $ticket->isOpen() ) {
					?>
					<button class="btn btn-lg btn-success btn-block" type="submit">Add Note and Close Ticket</button>
					<?php
				} else {
					?>
					<button class="btn btn-lg btn-warning btn-block" type="submit">Add Note and Reopen Ticket</button>
					<?php
				}
				?>
			</div>
			<div class="col-sm-6">
				<button class="btn btn-lg btn-primary btn-block" type="submit">Add Note</button>
			</div>
		</div>

	</form>
	<?php
}

?>
<?php include( 'foot.php' ); ?>
