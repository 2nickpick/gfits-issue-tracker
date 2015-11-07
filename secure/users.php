<?php include( 'head.php' ); ?>
<?php
$users = User::loadAll();
?>

<div class="page-header">
	<h1>Users (<span id="user_count"><?php echo count( $users ); ?></span>)</h1>
	<a type="button" class="btn btn-success" href="javascript:BackEnd.addUserForm();"><span
			class="glyphicon glyphicon-plus"></span> New User</a>
</div>

<div class="row search-users">
	<div class="col-lg-1 col-lg-offset-5">
		<div id="throbber"></div>
	</div>
	<div class="col-lg-6">
		<div class="input-group">
			<input id="search-users" name="search" type="text" class="form-control" placeholder="Search for..."/>
				<span class="input-group-btn">
					<button class="btn btn-default" type="button"
					        onclick="BackEnd.searchUsers(jQuery('#search').val());">Go!
					</button>
				</span>
		</div>
		<!-- /input-group -->
	</div>
	<!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="table-responsive">
	<table class="table table-striped table-hover table-condensed users">
		<thead>
		<tr>
			<th class="hidden-xs hidden-sm">
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('tUser.UserID')">ID #</a>
			</th>
			<th>
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('tUser.FirstName, tUser.LastName')">Name</a>
			</th>
			<th>
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('tLogin.TypeID')">Role</a>
			</th>
			<th class="hidden-xs hidden-sm">
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('tUser.EmailAddress')">Email</a>
			</th>
			<th class="hidden-xs hidden-sm hidden-md">
				<a href="javascript:;"
				   onclick="BackEnd.sortUsers('tUser.PhoneNumber')">Phone</a>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$classes = [ ];
				?>
				<tr onclick="BackEnd.openUser('<?php echo $user->getId() ?>');"
				    class="<?php echo implode( ' ', $classes ) ?>">
					<td class="hidden-xs hidden-sm">
						<?php echo $user->getId(); ?>
					</td>
					<td class="title"><?php echo $user->getFirstName() . ' ' . $user->getLastName() ?></td>
					<td><?php echo $user->getType() ? $user->getType()->getName() : 'N/A'; ?></td>
					<td class="hidden-xs hidden-sm ">
						<?php
						if ( ! empty( $user->getEmailAddress() ) ) {
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
