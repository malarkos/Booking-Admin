<?php
// No direct access to this file

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

defined('_JEXEC') or die('Restricted access');
?>
<h3><?php echo $this->msg; ?></h3>
<p>This page allows you to make and manage your bookings for the 50th Anniversary dinner at Ormond College on Saturday 21st October 2017. </p>

<h3>Current booking</h3>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		
			Joomla.submitform(task);
		
	}
</script>

<?php if (!empty($this->bookings)) : ?>
<form action="index.php?option=com_bookingadmin&view=50thbooking" method="post" id="adminForm" name="adminForm">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
			<th>
					<?php echo JText::_('COM_BOOKINGADMIN_50THBOOKING_DATEBOOKED') ;?>
				</th>
				<th>
					<?php echo JText::_('COM_BOOKINGADMIN_50THBOOKING_GUESTNAME') ;?>
				</th>
				<th>
					<?php echo JText::_('COM_BOOKINGADMIN_50THBOOKING_TABLE') ;?>
				</th>
				<th>
					<?php echo JText::_('COM_BOOKINGADMIN_50THBOOKING_PRICE') ;?>
				</th>
				<th>
					<?php echo JText::_('COM_BOOKINGADMIN_50THBOOKING_PAID') ;?>
				</th>
				<th>
					<?php echo JText::_('COM_BOOKINGADMIN_50THBOOKING_STATUS') ;?>
				</th>
				<th>
					<?php echo JText::_('COM_BOOKINGADMIN_50THBOOKING_COMMENTS') ;?>
				</th>
				<th>
					<?php echo JText::_('COM_BOOKINGADMIN_50THBOOKING_DELETE') ;?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $bookingtotal=0; $showsubmitbooking = 0;?>
		<?php foreach ( $this->bookings as $i => $row ) : 
		
		$link = JRoute::_('index.php?option=com_bookingadmin&layout=edit&bookingid=' . $row->id);
		$deletelink = JRoute::_('index.php?option=com_bookingadmin&task=deleteentry&bookingid=' . $row->id);
		$btndeletelink = '50thbooking.deleteentry&bookingid=' . $row->id;	
		$memberid = $row->MemberID;
		?>
		
		<tr>
			<td>
				<?php echo $row->bookingdate; ?>
			</td>
			<td>
			<a href="<?php echo $link; ?>">
				<?php echo $row->GuestFirstname.' '.$row->GuestSurname; ?>
			</a>
			</td>
			<td>
				<?php echo $row->Table; ?>
			</td>
			<td>
				$<?php echo $row->Price; 
				$bookingtotal += $row->Price; ?>
			</td>
			<td>
				<?php echo $row->Paid; ?>
			</td>
		<td>
				<?php echo $row->Status; ?>
			</td>
			<td>
				<?php echo $row->Comments; ?>
			</td>
			<td>
			<?php if($row->Status == 'Draft'):?>
			<?php $showsubmitbooking = 1;?>
				<a href="<?php echo $deletelink;?>">Delete</a>
				<?php else:?>
				-
			<?php endif;?>
			<?php 
			 /*
			  * 
			  
			<button type="button" class="btn" onclick="Joomla.submitbutton('<?php echo $btndeletelink; ?>')">
					 Delete
				</button>
				*/
				?>
			</td>
		</tr>
		<?php endforeach; ?>
		
		</tbody>
	</table>
		<div class="control-group">
			<div class="controls">
				<?php if($showsubmitbooking == 1):?>
					<button type="submit" class="btn btn-primary validate">Submit booking</button>
				<?php endif;?>
				<input type="hidden" name="option" value="com_bookingadmin" />
				<input type="hidden" name="memberid" value="<?php echo $memberid;?>" />
				<input type="hidden" name="task" value="50thbooking.submitbooking" />
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>
</form>
Booking total: $<?php echo $bookingtotal;?>
<?php else:?>
No current bookings.
<?php endif; ?>
<h3>Add to booking</h3>

<?php $link = JRoute::_('index.php?option=com_bookingadmin&layout=edit');?>
<a href="<?php echo $link; ?>">
				Add to booking
			</a>
		