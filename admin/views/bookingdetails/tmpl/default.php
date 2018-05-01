<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_bookingadmin
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$jinput = JFactory::getApplication()->input;
$bookingref = $jinput->get('bookingref','','text');
// set session variable
$session = JFactory::getSession();
$session->set('bookingref', $bookingref);
?>
<h2>Details for booking: <?php echo $bookingref; ?></h2>
<h3>Booking Summary</h3>
<table class="table table-striped table-hover">
		<thead>
			<tr>
			<th><?php echo JText::_('COM_BOOKINGADMIN_DETAIL_BOOKINGMADE'); ?></th>
			<th><?php echo JText::_('COM_BOOKINGADMIN_DETAIL_BOOKINGSTATUS'); ?></th>
			<th><?php echo JText::_('COM_BOOKINGADMIN_DETAIL_BOOKINGCOST'); ?></th>
			<th><?php echo JText::_('COM_BOOKINGADMIN_DETAIL_AMOUNTPAID'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php if (!empty($this->bookingsummary)) : ?>

		<tr>
			<td><?php echo $this->bookingsummary->bookingmade;?></td>
			<td><?php echo $this->bookingsummary->bookingstatus;?></td>
			<td><?php echo $this->bookingsummary->bookingcost;?></td>
			<td><?php echo $this->bookingsummary->amountpaid;?></td>
		</tr>

	<?php endif; ?>
		</tbody>
</table>
<h3>Booking Details</h3>
<form action="index.php?option=com_bookingadmin&view=bookingdetails" method="post" id="adminForm" name="adminForm">
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_BOOKINGADMIN_NUM'); ?></th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_EDITBOOKING'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_MEMGUEST'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_GUESTFIRSTNAME_LABEL') ;?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_GUESTSURNAME_LABEL') ;?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_AGE_LABEL') ;?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_GENDER_LABEL') ;?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_VEG_LABEL') ;?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_DATEIN') ;?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_DATEOUT'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_ROOM_LABEL') ;?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_COST_LABEL'); ?>
			</th>
			
			
			
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : 
					$link = JRoute::_('index.php?option=com_bookingadmin&task=bookingdetail.edit&id=' . $row->id.'&bookingref='.$bookingref);
				?>
 
					<tr>
						<td><?php echo $this->pagination->getRowOffset($i); ?></td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
								<a href="<?php echo $link; ?>">
									Edit
								</a>
						</td>
						<td align="center">
							<?php echo $row->memguest; ?>	</td>
						<td align="center">
							<?php echo $row->guestfirstname; ?>
						</td>
						<td align="center">
							<?php echo $row->guestsurname; ?>
						</td>
							<td align="center">
							<?php echo $row->age; ?>
						</td>
							<td align="center">
							<?php echo $row->gender; ?>
						</td>
							<td align="center">
							<?php echo $row->vegetarian; ?>
						</td>
						<td align="center">
							<?php echo $row->datein; ?>
						</td>
						<td align="center">
							<?php echo $row->dateout; ?>
						</td>
						<td align="center">
							<?php echo $row->room; ?>
						</td>
						<td align="center">
							<?php echo $row->cost; ?>
						</td>
					
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
</form>
<h3>Lodge Availability</h3>
