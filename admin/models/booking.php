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
class BookingAdminModelBooking extends JModelList
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
 
		$jinput = JFactory::getApplication()->input;
		$bookingref = $jinput->get('bookingref','','text');
		
		$session = JFactory::getSession();
		$session->set('bookingref', $bookingref);
		
		if (isset($bookingref))
		{
		      //$query->select('*')->from($db->quoteName('booking_summary'));
		    $query->select('b.*,concat(m.MemberFirstname,\' \',m.MemberSurname) as membername')
		    ->from('booking_summary as b');
		    $query->leftJoin('members AS m ON b.memid = m.MemberID');
		    $query->where($db->quoteName('bookingref').' = '.$db->quote($bookingref));
		}
		
		
		
		return $query;
	}
	
	public function getBookingDetails() {
	    // Initialize variables.
	    $db = JFactory::getDbo ();
	    $query = $db->getQuery ( true );
	    
	    //$session = JFactory::getSession();
	    //$bookingref = $session->get('bookingref');
	    $jinput = JFactory::getApplication()->input;
	    $bookingref = $jinput->get('bookingref','','text');
	    //JFactory::getApplication()->enqueueMessage('Bookingref ='.$bookingref);
	    $bookingsummary = array();
	    
	    if (strlen($bookingref) > 0 ) {  // check we have a valid
	        
	        $query->select ( '*,date_format(datein,\'%d %b \') as formatdatein, date_format(dateout,\'%d %b \') as formatdateout' );
	        $query->from ( 'booking_main' );
	        $query->where ( 'bookingref = ' . $bookingref );
	        $db->setQuery ( $query );
	        $bookingsummary = $db->loadObjectList();
	    }
	    
	    
	    return $bookingsummary;
	}
}
