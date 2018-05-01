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

$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);

?>
<form action="index.php?option=com_bookingadmin&view=bookings" method="post" id="adminForm" name="adminForm">
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<div class="row-fluid">
		<div class="span6">
			<?php echo JText::_('COM_BOOKINGADMIN_FILTER'); ?>
			<?php
				echo JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
				);
			?>
		</div>
	</div>
	<h1>Winter Bookings</h1>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_BOOKINGADMIN_NUM'); ?></th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKINGADMIN_DATE'); ?>
			</th>
			<th width="10%">		
			<?php echo JText::_('COM_BOOKINGADMIN_REFERENCE'); ?>		
					
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
					$link = JRoute::_('index.php?option=com_bookingadmin&task=booking.edit&bookid=' . $row->bookid);
					$linkdetails = JRoute::_('index.php?option=com_bookingadmin&view=booking&bookingref=' . $row->bookingref);
				?>
 
					<tr>
						<td><?php echo $this->pagination->getRowOffset($i); ?></td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->bookid); ?>
						</td>
						<td align="center">
							<?php echo $row->bookingmade; ?>
						</td>
						<td>
								<a href="<?php echo $linkdetails; ?>" title="<?php echo JText::_('COM_BOOKINGADMIN_EDIT_BOOKING'); ?>">
									<?php echo $row->bookingref; ?>
								</a>
						</td>
						
						<td align="center">
							<?php echo $row->membername; ?>	</td>
						
						<td align="center">
							<?php echo $row->bookingstatus; ?>
						</td>
						<td align="right">
							<?php echo $row->bookingcost; ?>
						</td>
						
						<td align="right">
							<?php echo $row->amountpaid; ?>
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
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>
