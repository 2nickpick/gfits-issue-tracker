<?php include( 'head.php' ); ?>
<?php global $currentUser; ?>

<?php

if ( empty( $_GET['users_id'] ) ) {
	?>
	<div class="alert alert-danger">
		User was not found! <a href="/~group4/secure/users.php">Back to Users</a>
	</div>
	<?php
} else {
	$user = User::loadById( $_GET['users_id'] );
	?>
	<div class="page-header">
		<h1>
			Edit User: <?php echo $user->getFirstName() . ' ' . $user->getLastName() ?>
		</h1>
	</div>

	<form id="add-ticket-form" class="form" onsubmit="BackEnd.updateUser(); return false;"
	      enctype="multipart/form-data">

		<div class="row">
			<label for="inputProfilePicture">Profile Picture</label>

			<div class="col-sm-6">
				<img class="profile-picture" src="/~group4/images/shelgon.png"/>
			</div>
			<div class="col-sm-6">
				<input type="file" class="form-control" id="inputProfilePicture" name="profile-picture"/>
			</div>
			<div class="col-sm-6">
				<label for="inputFirstName">First Name</label>
				<input type="text" id="inputFirstName" name="first_name" class="form-control"
				       value="<?php echo $user->getFirstName() ?>">
			</div>
			<div class="col-sm-6">
				<label for="inputLastName">Last Name</label>
				<input type="text" id="inputLastName" name="last_name" class="form-control"
				       value="<?php echo $user->getLastName() ?>">
			</div>
			<div class="col-sm-6">
				<label for="inputEmailAddress">Email Address</label>
				<input type="text" id="inputEmailAddress" name="email_address" class="form-control"
				       value="<?php echo $user->getEmailAddress() ?>">
			</div>
			<div class="col-sm-6">
				<label for="inputPhoneNumber">Phone Number</label>
				<input type="text" id="inputPhoneNumber" name="phone_number" class="form-control"
				       value="<?php echo $user->getPhoneNumber() ?>">
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
								if ( $user->getTypeId() == $role_id ) {
									$selected = 'selected="selected"';
								}
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
							if ( $user->getCellPhoneCarrierId() == $phone_carrier->getId() ) {
								$selected = 'selected="selected"';
							}
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

			<div class="col-sm-6">
				<input class="form-control btn btn-danger" type="submit" value="Delete User"/>
			</div>
			<div class="col-sm-6">
				<input class="form-control btn btn-primary" type="submit" value="Save User"/>
			</div>
		</div>
	</form>
	<?php
}

?>
<?php include( 'foot.php' ); ?>
