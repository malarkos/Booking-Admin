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
JHtml::_('formbehavior.chosen', 'select');


?>
<form action="index.php?option=com_bookingadmin&view=booking" method="post" id="adminForm" name="adminForm">
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php foreach ($this->items as $i => $row) : ?>
	<?php $bookingreference = $row->bookingref;  ?>
		<h1>Summary for booking <?php echo $row->bookingref; ?></h1>
	<?php endforeach; ?>
	
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_NUM'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DATE'); ?>
			</th>
			
			
			<th width="15%">
				<?php echo JText::_('COM_BOOKINGADMIN_MEMBER'); ?>
			</th>
			
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_STATUS'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_COST'); ?>
			</th>
			
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_AMOUNTPAID'); ?>
			</th>
			<th width="7%">
				<?php echo JText::_('COM_BOOKINGADMIN_BOOKINGPAID'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_PAYMENTMETHOD'); ?>
			</th>
			<th width="20%">
				<?php echo JText::_('COM_BOOKINGADMIN_COMMENT_LABEL'); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : 
					$link = JRoute::_('index.php?option=com_bookingadmin&task=bookingsummary.edit&bookid=' . $row->bookid);
					$linkdetails = JRoute::_('index.php?option=com_bookingadmin&view=bookingsummary&bookingref=' . $row->bookingref);
				?>
 
					<tr>
						<td>
						<a href="<?php echo $link; ?>">
									Edit
								</a>
						</td>
						<td align="center">
							<?php echo $row->bookingmade; ?>
						</td>
						
						
						<td align="center">
							<?php echo $row->membername; ?>	</td>
						
						<td align="center">
							<?php echo $row->bookingstatus; ?>
						</td>
						<td align="right">
							$<?php echo $row->bookingcost; ?>
						</td>
						
						<td align="right">
							$<?php echo $row->amountpaid; ?>
						</td>
						<td align="center">
							<?php echo $row->bookingpaid; ?>
						</td>
						<td align="center">
							<?php 
							
							 if ($row->paymentmethod == "internettransfer") {
							 	echo "I/T";
							 }
							 if ($row->paymentmethod == "cheque") {
							 	echo "Chq";
							 }
							?>
						</td>
						<td >
							<?php echo $row->comment; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>

	<?php echo JHtml::_('form.token'); ?>
	
	<h2>Guest Details</h2>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%">
				<?php echo JText::_('COM_BOOKINGADMIN_NUM'); ?>
			</th>
			<th width="1%">
				<?php echo JText::_('COM_BOOKINGADMIN_NUM'); ?>
			</th>
			<th width="1%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_MEMGUEST_LABEL'); ?>
			</th>
			<th width="1%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_GUESTNUM_LABEL'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_GUESTFIRSTNAME_LABEL'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_GUESTSURNAME_LABEL'); ?>
			</th>
			
			
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_AGE'); ?>
			</th>
			<th width="1%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_GENDER'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_DATEIN'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_DATEOUT'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_ROOM_LABEL'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_COST_LABEL'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_VEG_LABEL'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_FIRSTNIGHT_LABEL'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKINGADMIN_DETAIL_BOOKINGLISTDISPLAY_LABEL'); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (!empty($this->bookingdetails)) : ?>
				<?php foreach ($this->bookingdetails as $i => $row) : 
				    $link = JRoute::_('index.php?option=com_bookingadmin&task=bookingdetail.edit&id=' . $row->id);
					$linkdetails = JRoute::_('index.php?option=com_bookingadmin&view=bookingdetail&bookingreference='.$bookingreference.'&id=' . $row->id);
				?>
				<tr>
						<td><?php //echo $this->pagination->getRowOffset($i); ?>
							<a href="<?php echo $link; ?>">
									Edit
								</a>
								</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td align="center">
							<?php echo $row->memguest; ?>
						</td>
						<td align="center">
							<?php echo $row->guestnum; ?>
						</td>
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
							<?php echo $row->formatdatein; ?>
						</td>
						<td align="center">
							<?php echo $row->formatdateout; ?>
						</td>
						<td align="center">
							<?php echo $row->room; ?>
						</td>
						<td align="center">
							$<?php echo $row->cost; ?>
						</td>
						<td align="center">
							<?php echo $row->vegetarian; ?>
						</td>
						<td align="center">
							<?php echo $row->fridaydinner; ?>
						</td>
						<td align="center">
							<?php echo $row->bookinglistdisplay; ?>
						</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
		
	</table>
	
</div>
</form>
