<?php include( 'head.php' ); ?>

<div class="page-header">
	<h1>My Account</h1>
</div>

<form id="add-ticket-form" class="form" onsubmit="BackEnd.addTicket(); return false;" enctype="multipart/form-data">

	<div id="errors-container">
		<div class="alert alert-warning">
			<strong>Required Field Missing!</strong>
		</div>
	</div>

	<div id="success-container">
		<div class="alert alert-success">
			<strong>Success!</strong> We have received your ticket and a support specialist will respond shortly!
		</div>
	</div>

	<h3>New Ticket</h3>

	<form id="add-ticket-form" class="form" onsubmit="BackEnd.addTicket(); return false;"
	      enctype="multipart/form-data">

		<div class="row">
			<div class="col-sm-2">
				<img class="profile-picture" src="/~group4/images/default.png"/>
			</div>
			<div class="col-sm-6">
				<label for="inputName">Created By</label>
				<input type="text" id="inputName" class="form-control" value="Tester" disabled required autofocus>
			</div>
			<div class="col-sm-4">
				<label for="inputDate">Date</label>
				<input type="text" id="inputDate" class="form-control" value="<?php echo date( 'M d, Y' ) ?>" disabled
				       required autofocus>
			</div>
		</div>

		<label for="inputTitle">Title:</label>
		<input id="inputTitle" class="form-control" required />

		<label for="inputMessage">Please describe your issue here:</label>
		<textarea id="inputMessage" class="form-control" required></textarea>

		<label for="inputAttachment">Attachment (optional):</label>
		<input id="inputAttachment" type="file" name="attachment" class="form-control" />

		<button class="btn btn-lg btn-primary btn-block" type="submit">Submit New Ticket</button>

	</form>

</form>

<?php include( 'foot.php' ); ?>
