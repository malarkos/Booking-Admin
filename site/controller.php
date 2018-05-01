<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/**
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
class BookingAdminController extends JControllerLegacy
{
	/*
	 * Function to delete an entry - by changing memberid to 0.
	 */
	public function deleteentry()
	{
			
		$app    = JFactory::getApplication();
		
		
		$jinput = $app->input;
		$bookingid = $jinput->get('bookingid','','text');
		$app->enqueueMessage('Delete called from main controller with id.'.$bookingid);
		
		if ($bookingid > 1)  // ensure have valid booking id TODO more rigorous check
		{
			// Get current memberid
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true );
			
			$query->select ( 'MemberID' );
			$query->from ( 'osc50bookings' );
			$query->where ( 'id = ' . $bookingid );
				
			$db->setQuery ( $query );
			$db->execute ();
			$memberID = $db->loadResult ();
			$app->enqueueMessage('Have memberid of .'.$memberID);
		// Set oldMemberid = memberid
			$query = $db->getQuery ( true );
			$fields = array('oldMemberID = '. $db->quote($memberID)
			);
			$conditions = array('id = '. $bookingid );
			$query->update('osc50bookings');
			$query->set($fields);
			$query->where($conditions);
				
			$db->setQuery ( $query );
			$db->execute (); // TODO check return value
		// Set memberid = 0
			$zeroval = '0';
			$query = $db->getQuery ( true );
			$fields = array('MemberID = '. $db->quote($zeroval)
			);
			$conditions = array('id = '. $bookingid );
			$query->update('osc50bookings');
			$query->set($fields);
			$query->where($conditions);
			
			$db->setQuery ( $query );
			$db->execute (); // TODO check return value
		}
		// re-route to view
		
		$this->setRedirect(JRoute::_('index.php?option=com_bookingadmin&view=50thbooking', false));
	}  // end detelete
}