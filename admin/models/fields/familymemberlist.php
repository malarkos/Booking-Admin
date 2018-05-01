<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_lockers
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 *
 * @since  0.0.1
 */
class JFormFieldFamilyMemberList extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'FamilyMemberList';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('FamilyMemberID,concat(familymemberfirstname," ",familymembersurname) as familymembername');
		$query->from('familymembers as m');  // use new members table
		$query->where($db->quoteName('FamilyMembershiptype') . ' IN (\'Spouse\', \'Child\')');
        $query->order('familymemberfirstname, familymembersurname ASC');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();
 
		$options[] = JHtml::_('select.option', "0", "Select Family member..");
		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->FamilyMemberID, $message->familymembername);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}