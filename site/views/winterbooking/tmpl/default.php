<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<?php $winterlink = JRoute::_ ( 'index.php?option=com_bookingadmin&view=winterbookings' );?>
<a href="<?php echo $winterlink; ?>">Back to Winter Bookings</a>

<h3><?php echo $this->msg; ?></h3>



<?php if (!empty($this->items)) : ?>


<table class="table table-striped table-hover">
		<thead>
			<tr>
				
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_MEMGUEST') ;?>
				</th>
				<th width="15%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_GUEST') ;?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_AGE') ;?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_GENDER') ;?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_COST') ;?>
				</th>
				
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_DATEIN') ;?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_DATEOUT') ;?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_ROOM') ;?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php	foreach ( $this->items as $i => $row ) : ?>
		<tr>
			<td><?php echo $row->memguest; ?></td>
			<td><?php echo $row->guestfirstname.' '.$row->guestsurname; ?></td>
			<td><?php echo $row->age; ?></td>
			<td><?php echo $row->gender; ?></td>
			<td><?php echo $row->cost; ?></td>
			<td><?php echo $row->datein; ?></td>
			<td><?php echo $row->dateout; ?></td>
			<td><?php echo $row->room; ?></td>
		</tr>

		<?php endforeach; ?>
		
		
		</tbody>
</table>



<?php else:
	echo "No booking information";?>
<?php endif; ?>