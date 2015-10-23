<?php include( 'head.php' ); ?>

<?php

if ( empty( $_GET['tickets_id'] ) ) {
	?>
	<div class="alert alert-danger">
		Ticket was not found! <a href="/~group4/secure/dashboard.php">Back to Dashboard</a>
	</div>
	<?php
} else {
	?>
	<div class="page-header">
		<h1>
			My Ticket: ID <?php echo $_GET['tickets_id'] ?>
		</h1>
		<?php
		$closed = rand( 1, 2 ) % 2 == 0;
		if ( ! $closed ) {
			?>
			<span class="label label-warning">Open</span>
			<span class="label label-danger">More Than 1 Week Old</span>
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
				<img class="profile-picture" src="/~group4/images/shelgon.png"/>

				<p><strong>Tester</strong></p>

				<p><strong><?php echo date( 'M d, Y h:i A', strtotime( '-2 day' ) ) ?></strong></p>
			</div>
			<div class="col-sm-10">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla blandit elit libero, ac suscipit est pretium at.
				Donec placerat, dolor sit amet accumsan auctor, arcu augue imperdiet neque, in iaculis lacus dui et dui. Nullam
				eu purus at nulla laoreet varius. Nullam in dui venenatis, porttitor libero a, tempus tellus. Donec sed ex non
				sodales magna eu, congue tortor. Sed ac magna id nulla elementum rutrum. Vestibulum bibendum odio enim, et
				feugiat nunc varius sit amet. Sed ut eros id felis cursus egestas. Duis suscipit venenatis ex in dictum. Nunc
				sagittis ante turpis. Fusce vel eros lectus.
			</div>
		</div>
	</div>

	<?php
	$replies = array( 1 );
	foreach ( $replies as $reply ) {
		?>
		<div class="row">
			<div class="well clearfix">
				<div class="col-sm-2 text-center">
					<img class="profile-picture" src="/~group4/images/psyduck.jpg"/>

					<p><strong>Staff Member</strong></p>

					<p><span class="label label-default">Trusted Staff Member</span></p>

					<p><strong><?php echo date( 'M d, Y h:i A', strtotime( '-1 day + 3 hours + 12 minutes' ) ) ?></strong></p>
				</div>
				<div class="col-sm-10">
					Well, it seems you have a fair bit of knowledge about lorem ipsum generation.
				</div>
			</div>
		</div>
		<?php
	}
	?>

	<form id="update-ticket-form" class="form" onsubmit="BackEnd.updateTicket(); return false;"
	      enctype="multipart/form-data">

		<hr/>

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
				<img class="profile-picture" src="/~group4/images/shelgon.png"/>
			</div>
			<div class="col-sm-6">
				<label for="inputName">Name</label>
				<input type="text" id="inputName" class="form-control" value="Tester" disabled required autofocus>
			</div>
			<div class="col-sm-4">
				<label for="inputDate">Date</label>
				<input type="text" id="inputDate" class="form-control" value="<?php echo date( 'M d, Y' ) ?>" disabled
				       required autofocus>
			</div>
		</div>

		<label for="inputMessage">Add a message to this ticket:</label>
		<textarea id="inputMessage" class="form-control" required></textarea>

		<label for="inputAttachment">Attachment (optional):</label>
		<input id="inputAttachment" type="file" name="attachment" class="form-control" />

		<div class="row">
			<div class="col-sm-6">
				<?php
				if(! $closed ) {
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
