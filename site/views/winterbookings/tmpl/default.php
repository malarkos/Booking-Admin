<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>


<h3><?php echo $this->msg; ?></h3>

<h4>Current Bookings</h4>
<?php $this->renderToolbar()->render(); ?>

<h4>Past bookings</h4>
<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th><?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKINGS_BOOKINGREFERENCE') ;?></th>
				<th><?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKINGS_BOOKINGSTATUS') ;?></th>
				<th><?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKINGS_BOOKINGDATE') ;?></th>
				<th><?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKINGS_BOOKINGCOST') ;?></th>
				<th><?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKINGS_BOOKINGAMOUNTPAID') ;?></th>
				<th><?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKINGS_BOOKINGPAID') ;?></th>
			</tr>
		</thead>
		<tbody>

<?php if (!empty($this->items)) : 

	//$form = "<table class=\"table table-striped table-hover\">
	//	<thead>";
	//$form .= "<tr><th>Booking Reference</th></tr>";
	//$form .= "</thead>";
	//$form .= "<tbody>";
	$form = ""; //initialise

	foreach ( $this->items as $i => $row ) :
		$link = JRoute::_ ( 'index.php?option=com_bookingadmin&view=winterbooking&bookingref=' . $row->bookingref );
		$form .= "<tr>";
		$form .= "<td><a href=\"".$link."\">".$row->bookingref."</a></td>";
		$form .= "<td>". $row->bookingstatus."</td>";
		$form .= "<td>". $row->bookingmade."</td>";
		$form .= "<td>". $row->bookingcost."</td>";
		$form .= "<td>". $row->amountpaid."</td>";
		$form .= "<td>". $row->bookingpaid."</td>";
		
		$form .= "</tr>";
	endforeach;
	//$form .= "<tbody>";
	//$form .= "</table>";
	echo $form;
?>
</tbody>
</table>

<?php else:
	echo "No past bookings";?>
<?php endif; ?>