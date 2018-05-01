<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
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
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_COST') ;?>
				</th>
				
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_DATEIN') ;?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_BOOKINGADMIN_WINTERBOOKING_DATEOUT') ;?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php	foreach ( $this->items as $i => $row ) : ?>
		<tr>
			<td><?php echo $row->memguest; ?></td>
			<td><?php echo $row->guestfirstname.' '.$row->guestsurname; ?></td>
			<td><?php echo $row->cost; ?></td>
			<td><?php echo $row->datein; ?></td>
			<td><?php echo $row->dateout; ?></td>
		</tr>

		<?php endforeach; ?>
		
		
		</tbody>
</table>



<?php else:
	echo "No booking information";?>
<?php endif; ?>