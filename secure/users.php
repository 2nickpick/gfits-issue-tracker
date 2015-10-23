<?php include( 'head.php' ); ?>
<?php
$users = User::loadAll();
?>

<div class="page-header">
	<h1>Users (<?php echo count($users); ?>)</h1>
	<a type="button" class="btn btn-success" href="javascript:BackEnd.addUserForm();"><span class="glyphicon glyphicon-plus" ></span> New User</a>
</div>

<div class="table-responsive">
	<table class="table table-striped table-hover table-condensed tickets">
		<thead>
		<tr>
			<th class="hidden-xs hidden-sm">
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('id')">ID #</a>
			</th>
			<th>
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('name')">Name</a>
			</th>
			<th>
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('role')">Role</a>
			</th>
			<th class="hidden-xs hidden-sm">
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('email_address')">Email</a>
			</th>
			<th class="hidden-xs hidden-sm hidden-md">
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('phone_number')">Phone</a>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($users)) {
			foreach($users as $user) {
				$classes = [];
				?>
				<tr onclick="BackEnd.openUser('<?php echo $user->getId() ?>');" class="<?php echo implode( ' ', $classes ) ?>">
					<td class="hidden-xs hidden-sm">
						<?php echo $user->getId(); ?>
					</td>
					<td class="title"><?php echo $user->getFirstName() . ' ' . $user->getLastName() ?></td>
					<td><?php echo $user->getType() ? $user->getType()->getName() : 'N/A'; ?></td>
					<td class="hidden-xs hidden-sm ">
						<?php
						if(!empty($user->getEmailAddress())) {
							?>
							<a href="mailto:<?php echo $user->getEmailAddress(); ?>">
								<?php echo $user->getEmailAddress(); ?>
							</a>
							<?php
						}
						?>
					</td>
					<td class="hidden-xs hidden-sm hidden-md"><?php echo $user->getPhoneNumber() ?></td>
				</tr>
				<?php
			}
		}
		?>
		</tbody>
	</table>
</div>
<?php include( 'foot.php' ); ?>
