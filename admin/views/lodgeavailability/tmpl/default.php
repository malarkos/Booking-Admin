<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_bookingadmin
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
JHtml::_('formbehavior.chosen', 'select');
?>
<form action="index.php?option=com_bookingadmin&view=lodgeavailability" method="post" id="adminForm" name="adminForm">
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
	<h1>Lodge Availability</h1>
	<?php // add code for filter??>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th><?php echo JText::_('COM_BOOKINGADMIN_LODGEAVAILABILITY_DATE'); ?></th>
			<th><?php echo JText::_('COM_BOOKINGADMIN_LODGEAVAILABILITY_GUESTCOUNT'); ?>	</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="2">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php $guestcount=0;?>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row): ?>
				<tr>
				<td >
							<?php echo $row->roomnight; ?>
						</td>
				<td align="right">
							<?php echo $row->roomnightcount; $guestcount += $row->roomnightcount;?>
						</td>
				</tr>
				
				<?php endforeach; ?>
			<?php endif; ?>
			<tr>
				<td><?php echo JText::_('COM_BOOKINGADMIN_LODGEAVAILABILITY_TOTAL'); ?></td>
				<td><?php echo $guestcount; ?></td>
				
			</tr>
		</tbody>	
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>	
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>