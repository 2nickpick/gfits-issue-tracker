<?php include( $_SERVER['DOCUMENT_ROOT'] . '/group4/secure/head.php' ); ?>

<?php $lorem_ipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla blandit elit libero, ac suscipit est pretium at. Donec placerat, dolor sit amet accumsan auctor, arcu augue imperdiet neque, in iaculis lacus dui et dui. Nullam eu purus at nulla laoreet varius. Nullam in dui venenatis, porttitor libero a, tempus tellus. Donec sed ex non ligula rutrum blandit eget eu arcu. Fusce sem eros, porta ut est vitae, euismod malesuada nibh. Morbi vel ex eleifend, gravida ipsum id, fermentum neque. Morbi semper nisi vitae tortor sodales, in mattis enim pretium. Mauris egestas vel leo eu cursus. Etiam ac odio et orci aliquet finibus vitae vitae sapien. Duis in augue tincidunt, sodales magna eu, congue tortor. Sed ac magna id nulla elementum rutrum. Vestibulum bibendum odio enim, et feugiat nunc varius sit amet.
Sed ut eros id felis cursus egestas. Duis suscipit venenatis ex in dictum. Nunc sagittis ante turpis. Fusce vel eros lectus. Cras molestie dolor non erat viverra ullamcorper. Aliquam feugiat neque sit amet libero pharetra, id facilisis massa rhoncus. Sed non ligula luctus, consequat arcu ac, placerat dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut risus elit, porttitor eget neque ac, tempor vulputate eros. In ac lectus consequat, pharetra dolor sed, varius sem. Integer sed ligula placerat, condimentum justo vitae, ornare felis. Proin ut pharetra massa, in tincidunt metus. In tincidunt fermentum sapien, non convallis nisl elementum in. Morbi non lacus vel augue fringilla auctor et non neque. Morbi leo ex, facilisis id sollicitudin id, tristique id lorem. Vestibulum at risus aliquet, hendrerit quam sit amet, feugiat orci.
Phasellus a metus ipsum. Morbi varius odio eget varius tempus. Etiam non tincidunt risus. Nam pellentesque tortor eu nunc auctor iaculis ut ut turpis. Nullam volutpat ornare pulvinar. Phasellus non mauris tincidunt, tincidunt nulla nec, lobortis augue. Praesent gravida congue nibh, eget blandit turpis eleifend at. Sed pulvinar quam a purus iaculis pretium. Sed scelerisque odio et ultrices faucibus. Fusce imperdiet vestibulum arcu ac imperdiet. Curabitur sit amet gravida odio. Aenean venenatis elementum metus, eu finibus felis viverra semper. Nullam quis vulputate dolor.
Aenean aliquam ex a sem accumsan aliquam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean hendrerit dolor sit amet purus imperdiet pulvinar. Cras sollicitudin massa eget semper vulputate. Praesent blandit purus eu nisi egestas, vitae laoreet lorem iaculis. Sed ac est ac justo cursus interdum. Donec lorem mi, fermentum sit amet felis quis, vehicula auctor ex. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis quis posuere lorem, id facilisis urna. Suspendisse rhoncus nunc quis orci semper, eu dignissim nisl mollis. Donec gravida et lorem nec elementum. Curabitur venenatis volutpat velit, vel auctor nulla porttitor eget. Nullam non efficitur neque, quis pulvinar erat. Donec sit amet enim vulputate, tempor dui eu, elementum nisl. In interdum, leo ut consequat malesuada, orci elit faucibus mauris, et mattis urna turpis eget ipsum.
Curabitur ultricies leo non pulvinar congue. Etiam pharetra vitae erat nec volutpat. Vivamus et turpis rhoncus, venenatis lacus rutrum, consequat lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc turpis felis, varius sed urna non, porta accumsan magna. Sed egestas aliquet magna. Aenean felis turpis, gravida at mattis ac, pharetra ac ligula. Nullam quis ullamcorper dolor. Ut sagittis rhoncus porttitor. Curabitur eu turpis id felis blandit posuere. Integer cursus, libero et faucibus tempus, est sapien ullamcorper est, non convallis dui mauris et eros. Nulla sed eros at libero laoreet ultrices in in nisl. Fusce vulputate semper ante vel tincidunt.';

?>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
			        aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">GFITS</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="/group4/secure/my-account.php">My Account</a></li>
				<li><a href="/group4/contact-us.php">Contact Us</a></li>
				<li><a href="/group4/secure/log-out.php">Log Out</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="new-ticket btn btn-success">
					<a href="/group4/secure/add-ticket.php">
						<span class="glyphicon glyphicon-plus"></span> New Ticket
					</a>
				</li>
			</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
</nav>

<div class="container theme-showcase" role="main">

	<?php
	$column_count = 2;
	$ticket_count = rand( 3, 8 );
	?>
	<div class="page-header">
		<h1>My Tickets (<?php echo $ticket_count; ?>)</h1>
	</div>
	<?php for ( $i = 0; $i < $ticket_count; $i ++ ) {
		$random_timestamp = mt_rand( strtotime( 'Jan 15, 2012' ), strtotime( 'Jan 15, 2016' ) );
		$open             = rand( 0, 10 ) % 2;
		$content          = substr( $lorem_ipsum, rand( 0, 250 ), 150 ) . '...';
		$reply_count      = rand( 0, 4 );
		$id      = rand( 1, 100 );
		?>
		<?php
		if ( $i % $column_count == 0 ) {
			?>
			<div class="tickets row">
			<?php
		}
		?>
		<div class="col-sm-6">
			<div class="panel panel-<?php echo $open ? 'primary' : 'success'; ?>">
				<div class="panel-heading">
					<h3 class="panel-title">
						Submitted:
						<strong>
							<?php
							echo date( 'M d, Y h:i A', $random_timestamp );
							?>
						</strong>
						<?php
						if ( ! $open ) {
							?>
							<span title="Ticket is closed!" class="glyphicon glyphicon-ok"></span>
							<?php
						}
						?>
					</h3>
				</div>
				<div class="panel-body">
					<div class="well">
						<p><?php echo $content; ?></p>
					</div>
					<a href="/group4/secure/ticket.php?tickets_id=<?php echo $id ?>" class="btn btn-default view-replies">
						View Ticket
						<?php
						if ( $reply_count > 0 ) {
							?>
							<span class="badge">
								<?php
								echo $reply_count . ' ' . ($reply_count > 1 ? 'Replies' : 'Reply'); ?>
							</span>
							<?php
						}
						?>
						&raquo;
					</a>
				</div>
			</div>
		</div>
		<?php
		if ( $i % $column_count == $column_count - 1 || $i == $ticket_count - 1 ) {
			?>
			</div>
			<!-- /.col-sm-6 -->
			<?php
		}
		?>
		<?php
	}
	?>
</div>

<div class="well">
		<span>
			Developed by Group 4, Internet Programming - University of North Florida
		</span>
</div>


</div> <!-- /container -->


<?php include( $_SERVER['DOCUMENT_ROOT'] . '/group4/secure/foot.php' ); ?>
