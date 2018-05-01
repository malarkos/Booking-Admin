
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
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class BookingAdminModelWinterBooking extends JModelList
{
	/**
	 * @var string message
	 */
	protected $message;

	/**
	 * Get the message
	 * @return  string  The message to be displayed to the user
	 */
	public function getMsg()
	{
		$this->message = "50th Anniversary Booking";

		return $this->message;
	} // getMsg

	protected function getListQuery() // function to show details on nominated booking
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
	
		// get booking reference from input
		//$bookingref = $_POST['bookingref'];
		$jinput = JFactory::getApplication()->input;
		$bookingref = $jinput->get('bookingref','','text');
		
		
		// Create the base select statement.
		
		if (isset($bookingref))
		{
			$query->select('*')
			->from($db->quoteName('booking_main'));
			$query->where($db->quoteName('bookingref').' = '.$db->quote($bookingref));
			return $query;
		}
		else {
			return ""; // TODO: better error return
		}
		
	} // getListQuery
	
	public function getBookingDetail()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$bookingdetail = array();
		
		// Get input
		$jinput = JFactory::getApplication()->input;
		$bookingref = $jinput->get('bookingref','','text');
		
		// get all rows from booking_main
		// need to set the guestfirstname and guestsurname fields
		$query->select('*');
		$query->from($db->quoteName('booking_main'));
		$query->where($db->quoteName('bookingref').' = '.$db->quote($bookingref));
		$db->setQuery ( $query );
		$db->execute ();
		$num_rows = $db->getNumRows ();
		$bookingdetail = $db->loadObjectList ();
		for($i = 0; $i < $num_rows; $i ++) {
			$memguest = $bookingdetail[$i]->memguest;  // could be m, f, s, c, b, g
			$memberval = $bookingdetail[$i]->memberval;
			// if m = member get member
			if ($memguest == 'm') 
			{
					
				
				$query = $db->getQuery ( true );
				$query->select ( 'MemberFirstname' );
				$query->from ( 'members' );
				$query->where ( 'MemberID = ' . $memberval );
					
				$db->setQuery ( $query );
				$db->execute ();
				$memberfirstname = $db->loadResult ();
				$bookingdetail[$i]->guestfirstname = $memberfirstname;
				
				$query = $db->getQuery ( true );
				$query->select ( 'MemberSurname' );
				$query->from ( 'members' );
				$query->where ( 'MemberID = ' . $memberval );
					
				$db->setQuery ( $query );
				$db->execute ();
				$membersurname = $db->loadResult ();
				$bookingdetail[$i]->guestsurname = $membersurname;
			}
			// if f = family, s = spouse, c = child get from family member
			if($memguest == 's' || $memguest == 'f' || $memguest == 'c') {
				$query = $db->getQuery ( true );
				$query->select ( 'FamilyMemberFirstname' );
				$query->from ( 'familymembers' );
				$query->where ( 'FamilyMemberID = ' . $memberval );
					
				$db->setQuery ( $query );
				$db->execute ();
				$memberfirstname = $db->loadResult ();
				$bookingdetail[$i]->guestfirstname = $memberfirstname;
				
				$query = $db->getQuery ( true );
				$query->select ( 'FamilyMemberSurname' );
				$query->from ( 'familymembers' );
				$query->where ( 'FamilyMemberID = ' . $memberval );
					
				$db->setQuery ( $query );
				$db->execute ();
				$membersurname = $db->loadResult ();
				$bookingdetail[$i]->guestsurname = $membersurname;
			}
			// if (b)uddy or (g)uest - assume ok
			
		} // for
		
		return $bookingdetail;
	}
} // class
