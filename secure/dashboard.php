<?php include( $_SERVER['DOCUMENT_ROOT'] . '/group4/secure/head.php' ); ?>

<?php

$lorem_ipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla blandit elit libero, ac suscipit est pretium at. Donec placerat, dolor sit amet accumsan auctor, arcu augue imperdiet neque, in iaculis lacus dui et dui. Nullam eu purus at nulla laoreet varius. Nullam in dui venenatis, porttitor libero a, tempus tellus. Donec sed ex non ligula rutrum blandit eget eu arcu. Fusce sem eros, porta ut est vitae, euismod malesuada nibh. Morbi vel ex eleifend, gravida ipsum id, fermentum neque. Morbi semper nisi vitae tortor sodales, in mattis enim pretium. Mauris egestas vel leo eu cursus. Etiam ac odio et orci aliquet finibus vitae vitae sapien. Duis in augue tincidunt, sodales magna eu, congue tortor. Sed ac magna id nulla elementum rutrum. Vestibulum bibendum odio enim, et feugiat nunc varius sit amet.
Sed ut eros id felis cursus egestas. Duis suscipit venenatis ex in dictum. Nunc sagittis ante turpis. Fusce vel eros lectus. Cras molestie dolor non erat viverra ullamcorper. Aliquam feugiat neque sit amet libero pharetra, id facilisis massa rhoncus. Sed non ligula luctus, consequat arcu ac, placerat dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut risus elit, porttitor eget neque ac, tempor vulputate eros. In ac lectus consequat, pharetra dolor sed, varius sem. Integer sed ligula placerat, condimentum justo vitae, ornare felis. Proin ut pharetra massa, in tincidunt metus. In tincidunt fermentum sapien, non convallis nisl elementum in. Morbi non lacus vel augue fringilla auctor et non neque. Morbi leo ex, facilisis id sollicitudin id, tristique id lorem. Vestibulum at risus aliquet, hendrerit quam sit amet, feugiat orci.
Phasellus a metus ipsum. Morbi varius odio eget varius tempus. Etiam non tincidunt risus. Nam pellentesque tortor eu nunc auctor iaculis ut ut turpis. Nullam volutpat ornare pulvinar. Phasellus non mauris tincidunt, tincidunt nulla nec, lobortis augue. Praesent gravida congue nibh, eget blandit turpis eleifend at. Sed pulvinar quam a purus iaculis pretium. Sed scelerisque odio et ultrices faucibus. Fusce imperdiet vestibulum arcu ac imperdiet. Curabitur sit amet gravida odio. Aenean venenatis elementum metus, eu finibus felis viverra semper. Nullam quis vulputate dolor.
Aenean aliquam ex a sem accumsan aliquam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean hendrerit dolor sit amet purus imperdiet pulvinar. Cras sollicitudin massa eget semper vulputate. Praesent blandit purus eu nisi egestas, vitae laoreet lorem iaculis. Sed ac est ac justo cursus interdum. Donec lorem mi, fermentum sit amet felis quis, vehicula auctor ex. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis quis posuere lorem, id facilisis urna. Suspendisse rhoncus nunc quis orci semper, eu dignissim nisl mollis. Donec gravida et lorem nec elementum. Curabitur venenatis volutpat velit, vel auctor nulla porttitor eget. Nullam non efficitur neque, quis pulvinar erat. Donec sit amet enim vulputate, tempor dui eu, elementum nisl. In interdum, leo ut consequat malesuada, orci elit faucibus mauris, et mattis urna turpis eget ipsum.
Curabitur ultricies leo non pulvinar congue. Etiam pharetra vitae erat nec volutpat. Vivamus et turpis rhoncus, venenatis lacus rutrum, consequat lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc turpis felis, varius sed urna non, porta accumsan magna. Sed egestas aliquet magna. Aenean felis turpis, gravida at mattis ac, pharetra ac ligula. Nullam quis ullamcorper dolor. Ut sagittis rhoncus porttitor. Curabitur eu turpis id felis blandit posuere. Integer cursus, libero et faucibus tempus, est sapien ullamcorper est, non convallis dui mauris et eros. Nulla sed eros at libero laoreet ultrices in in nisl. Fusce vulputate semper ante vel tincidunt.';

$column_count = 2;
$ticket_count = rand( 3, 8 );
?>
<div class="page-header">
	<h1>My Tickets (<?php echo $ticket_count; ?>)</h1>
</div>

<div class="row search-tickets">
	<div class="col-lg-6">
		&nbsp;
	</div><!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<div class="input-group">
			<input id="search" type="text" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button" onclick="BackEnd.searchTickets(jQuery('#search').val());">Go!</button>
      </span>
		</div><!-- /input-group -->
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="table-responsive">
	<table class="table table-striped table-hover table-condensed tickets">
		<thead>
		<tr>
			<th class="hidden-xs hidden-sm">
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('id')">ID #</a>
			</th>
			<th>
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('title')">Title</a>
			</th>
			<th>
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('submitted_by')">Submitted By</a>
			</th>
			<th class="hidden-xs hidden-sm">
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('date')">Date</a>
			</th>
			<th class="hidden-xs hidden-sm hidden-md">
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('last_reply')">Last Reply</a>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ( $i = 0; $i < $ticket_count; $i ++ ) {
			$random_timestamp   = mt_rand( strtotime( 'Jan 15, 2012' ), strtotime( 'Jan 15, 2016' ) );
			$random_timestamp_2 = mt_rand( strtotime( 'Jan 15, 2012' ), strtotime( 'Jan 15, 2016' ) );
			$open               = rand( 0, 10 ) % 2;
			$title              = substr( $lorem_ipsum, rand( 0, 250 ), 50 ) . '...';
			$reply_count        = rand( 0, 4 );
			$submitted_by       = rand( 0, 1 ) % 2 == 0 ? 'Tester' : 'Tester 2';
			$id                 = rand( 1, 100 );
			$classes            = array();

			if(!$open) {
				$classes[] = 'success';
			}
			?>
			<tr onclick="BackEnd.openTicket('<?php echo $id ?>');" class="<?php echo implode(' ', $classes) ?>">
				<td class="hidden-xs hidden-sm">
					<?php
					if ( ! $open ) {
						?>
						<span title="Ticket is closed!" class="glyphicon glyphicon-ok"></span>
						<?php
					}

					echo $id;

					?>
				</td>
				<td class="title"><?php echo $title ?></td>
				<td><?php echo $submitted_by; ?></td>
				<td class="hidden-xs hidden-sm "><?php echo date( 'M d, Y h:i A', $random_timestamp ); ?></td>
				<td class="hidden-xs hidden-sm hidden-md"><?php echo date( 'M d, Y h:i A', $random_timestamp_2 ); ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
</div>
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/group4/secure/foot.php' ); ?>
