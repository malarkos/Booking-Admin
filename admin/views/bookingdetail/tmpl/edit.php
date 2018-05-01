<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_bookingadmin
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

?>
<form
	action="<?php echo JRoute::_('index.php?option=com_bookingadmin&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" name="adminForm" id="adminForm">
	<div class="form-horizontal">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_BOOKINGADMIN_BOOKINGDETAIL_TABLE_DETAILS'); ?></legend>
			<div class="row-fluid">
				<div class="span6">
                   <?php echo $this->form->renderField('guestnum'); ?> 
                   <?php echo $this->form->renderField('memguest'); ?> 
                   <?php echo $this->form->renderField('memberval'); ?> 
                   <?php echo $this->form->renderField('fammemberval'); ?> 
                   <?php echo $this->form->renderField('guestfirstname'); ?>
                   <?php echo $this->form->renderField('guestsurname'); ?>
                    <?php echo $this->form->renderField('age'); ?>
                    <?php echo $this->form->renderField('gender'); ?>
                      <?php echo $this->form->renderField('wpdisc'); ?>
                </div>
				<div class="span6">
                 <?php echo $this->form->renderField('vegetarian'); ?>  
                 <?php echo $this->form->renderField('fridaydinner'); ?>   
                 <?php echo $this->form->renderField('datein'); ?>  
                 <?php echo $this->form->renderField('dateout'); ?>   
                 <?php echo $this->form->renderField('room'); ?>    
                 <?php echo $this->form->renderField('bookinglistdisplay'); ?>  
                </div>
			</div>
		</fieldset>
	</div>
	<input type="hidden" name="task" value="bookingdetail.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
