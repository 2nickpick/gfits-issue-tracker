<?php include( 'head.php' ); ?>
<?php global $currentUser; ?>

<div class="page-header">
	<h1>New User</h1>
</div>

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

<form id="add-user-form" class="form" onsubmit="BackEnd.addUser(); return false;"
      enctype="multipart/form-data">

	<div class="row">
		<div class="col-sm-6">
			<label for="inputFirstName">First Name</label>
			<input type="text" id="inputFirstName" name="first_name" class="form-control"
			       value="">
		</div>
		<div class="col-sm-6">
			<label for="inputLastName">Last Name</label>
			<input type="text" id="inputLastName" name="last_name" class="form-control"
			       value="">
		</div>
		<div class="col-sm-6">
			<label for="inputEmailAddress">Email Address</label>
			<input type="text" id="inputEmailAddress" name="email_address" class="form-control"
			       value="">
		</div>
		<div class="col-sm-6">
			<label for="inputPhoneNumber">Phone Number</label>
			<input type="text" id="inputPhoneNumber" name="phone_number" class="form-control"
			       value="">
		</div>
		<div class="col-sm-6">
			<?php
			if ( $currentUser->getTypeId() == 3 ) {
				?>
				<label for="selectLoginType">Role</label>
				<select id="selectLoginType" name="type_id" class="form-control">
					<option value="">Select a role...</option>
					<?php
					$roles = array(
						'SUBSCRIBER' => 1,
						'STAFF'      => 2,
						'ADMIN'      => 3
					);
					if ( ! empty( $roles ) ) {
						foreach ( $roles as $role_name => $role_id ) {
							$selected = '';
							?>
							<option value="<?php echo $role_id ?>" <?php echo $selected ?>>
								<?php echo $role_name ?>
							</option>
							<?php
						}
					}
					?>
				</select>
				<?php
			}
			?>
		</div>
		<div class="col-sm-6">
			<label for="selectPhoneCarrier">Phone Carrier</label>
			<select id="selectPhoneCarrier" name="cell_phone_carrier_id" class="form-control">
				<option value="">Select a carrier...</option>
				<?php
				$phone_carriers = CellPhoneCarrier::loadAll();
				if ( ! empty( $phone_carriers ) ) {
					foreach ( $phone_carriers as $phone_carrier ) {
						$selected = '';
						?>
						<option value="<?php echo $phone_carrier->getId() ?>" <?php echo $selected ?>>
							<?php echo $phone_carrier->getName() ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</div>

		<div class="col-sm-6">
			<label for="inputPassword">Password</label>
			<input class="form-control" type="password" name="password" value="" id="inputPassword"/>
		</div>

		<div class="col-sm-6">
			<label for="inputPasswordAgain">Password Again</label>
			<input class="form-control" type="password" name="password_again" value="" id="inputPasswordAgain"/>
		</div>

		<div class="col-sm-12">
			<input class="form-control btn btn-primary" type="submit" value="Create User"/>
		</div>
	</div>
</form>

<?php include( 'foot.php' ); ?>
