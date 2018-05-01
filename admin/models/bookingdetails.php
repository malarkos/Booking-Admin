<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HelloWorldList Model
 *
 * @since  0.0.1
 */
class BookingAdminModelBookingDetails extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		//$bookingref = $_POST['bookingref'];
		$jinput = JFactory::getApplication()->input;
		$bookingref = $jinput->get('bookingref','','text');
		JFactory::getApplication()->enqueueMessage('Bookingref ='.$bookingref);
 
		// Create the base select statement.
		$query->select('*')
                ->from($db->quoteName('booking_main'));
		if (isset($bookingref))
		{
			$query->where($db->quoteName('bookingref').' = '.$db->quote($bookingref));
		}
                
 
		return $query;
	}
	
	public function getBookingSummary() {
		// Initialize variables.
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
	
		$session = JFactory::getSession();
		$bookingref = $session->get('bookingref');
		$bookingsummary = array();
		
		if (strlen($bookingref) > 0 ) {  // check we have a valid
			
			$query->select ( '*' );
			$query->from ( 'booking_summary' );
			$query->where ( 'bookingref = ' . $bookingref );
			$db->setQuery ( $query );
			$bookingsummary = $db->loadObject();
		}
			
		
		return $bookingsummary;
	}
	
	public function getLodgeAvailability() {
		// Initialize variables.
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
	
		// get input values
		/*$app = JFactory::getApplication ();
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );*/
		
		return;
	}
}
