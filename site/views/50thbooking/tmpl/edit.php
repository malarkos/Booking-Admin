<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

?>
    <h2>Edit booking</h2>
 
   <form id="50thbooking" action="<?php echo JRoute::_('index.php?option=com_bookingadmin&task=50thbooking.save'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
	<?php // Iterate through the form fieldsets and display each one. ?>
	<?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
		<?php $fields = $this->form->getFieldset($group); ?>
		<?php if (count($fields)) : ?>
		<fieldset>
			<?php // If the fieldset has a label set, display it as the legend. ?>
			<?php if (isset($fieldset->label)) : ?>
			<legend>
				<?php echo JText::_($fieldset->label); ?>
			</legend>
			<?php endif;?>
			<?php // Iterate through the fields in the set and display them. ?>
			<?php foreach ($fields as $field) : ?>
					<div class="control-group">
						<div class="control-label">
							<?php echo $field->label; ?>
						</div>
						<div class="control-input">
							<?php echo $field->input; ?>
						</div>
					</div>
			<?php endforeach;?>
		</fieldset>
		<?php endif;?>
	<?php endforeach;?>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
				<a class="btn" href="<?php echo JRoute::_('index.php?option=com_bookingadmin&view=50thbooking', false); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
				<input type="hidden" name="option" value="com_bookingadmin" />
				<input type="hidden" name="task" value="50thbooking.save" />
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>