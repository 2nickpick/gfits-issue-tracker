<?php include( 'head.php' ); ?>

<?php
$tickets = Ticket::loadAll();
?>
<div class="page-header">
	<h1>My Tickets (<span id="ticket_count"><?php echo count( $tickets ); ?></span>)</h1>
</div>

<div class="row search-tickets">
	<div class="col-lg-1 col-lg-offset-5">
		<div id="throbber"></div>
	</div>
	<div class="col-lg-6">
		<div class="input-group">
			<input id="search-tickets" name="tickets" type="text" class="form-control" placeholder="Search for...">
				<span class="input-group-btn">
				<button class="btn btn-default" type="button"
				        onclick="BackEnd.searchTickets(jQuery('#search-tickets').val());">Go!
				</button>
				</span>
		</div>
		<!-- /input-group -->
	</div>
	<!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="table-responsive">
	<table class="table table-striped table-hover table-condensed tickets">
		<thead>
		<tr>
			<th class="hidden-xs hidden-sm">
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('tTicket.TicketID')">ID #</a>
			</th>
			<th>
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('tTicket.IssueTitle')">Title</a>
			</th>
			<th>
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('jOpenedBy.LastName, jOpenedBy.FirstName')">Opened By</a>
			</th>
			<th class="hidden-xs hidden-sm">
				<a href="javascript:;"
				   onclick="BackEnd.sortTickets('tTicket.DateOpened DESC')">Date</a>
			</th>
			<th class="hidden-xs hidden-sm hidden-md">
				Last Reply
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($tickets as $i => $ticket) {
			$classes            = array();

			if ( ! $ticket->isOpen() ) {
				$classes[] = 'success';
			}
			?>
			<tr onclick="BackEnd.openTicket('<?php echo $ticket->getId() ?>');" class="<?php echo implode( ' ', $classes ) ?>">
				<td class="hidden-xs hidden-sm">
					<?php
					if ( ! $ticket->isOpen() ) {
						?>
						<span title="Ticket is closed!" class="glyphicon glyphicon-ok"></span>
						<?php
					}

					echo intval($ticket->getId());
					?>
				</td>
				<td class="title"><?php echo htmlentities($ticket->getIssueTitle()) ?></td>
				<td><?php echo htmlentities($ticket->getOpenedBy()->getFirstName() . ' ' . $ticket->getOpenedBy()->getLastName()) ?></td>
				<td><?php echo date('M d, Y h:i A', $ticket->getDateOpened()) ?></td>
				<td class="hidden-xs hidden-sm hidden-md">
					<?php
						if(!empty($ticket->getDateLastReplied())) {
							echo date( 'M d, Y h:i A', $ticket->getDateLastReplied() );
						} else {
							echo 'N/A';
						}
					?>
				</td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
</div>
<?php include( 'foot.php' ); ?>
