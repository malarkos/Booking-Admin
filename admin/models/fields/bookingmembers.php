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
 * Class to return list of all members who have made a booking
 *
 * @since  0.0.1
 */
class JFormFieldBookingMembers extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'BookingMembers';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		
       
        $query->select('DISTINCT b.memid as memberid,concat(m.MemberFirstname,\' \',m.MemberSurname) as membername')
        ->from('booking_summary as b');
        $query->where('b.memid > 0');
        $query->leftJoin('members AS m ON b.memid = m.MemberID');
        $query->order('membername');
        
        $db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();
 
		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->memberid, $message->membername);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}