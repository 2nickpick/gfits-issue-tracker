<?php include( '../config.inc.php' ); ?>
<?php include( DOCUMENT_ROOT . '/secure/head.php' ); ?>

<div class="page-header">
	<h1>My Account</h1>
</div>

<form id="add-ticket-form" class="form" onsubmit="BackEnd.addTicket(); return false;" enctype="multipart/form-data">

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

	<h3>New Ticket</h3>

	<div class="row">
		<div class="col-sm-2">
			<img class="profile-picture" src="/~group4/images/shelgon.png" />
		</div>
		<div class="col-sm-6">
			<label for="inputName">Created By</label>
			<input type="text" id="inputName" class="form-control" value="Tester" disabled required autofocus>
		</div>
		<div class="col-sm-4">
			<label for="inputDate">Date</label>
			<input type="text" id="inputDate" class="form-control" value="<?php echo date('M d, Y') ?>" disabled required autofocus>
		</div>
	</div>

		<label for="inputMessage">Please describe your issue here:</label>
		<textarea id="inputMessage" class="form-control" required ></textarea>

		<button class="btn btn-lg btn-primary btn-block" type="submit">Submit New Ticket</button>


</form>

<?php include( DOCUMENT_ROOT . '/secure/foot.php' ); ?>
