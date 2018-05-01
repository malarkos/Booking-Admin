
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
class BookingAdminModelWinterBookings extends JModelList
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

	protected function getListQuery() // function to return required bookings
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
	
		// Create the base select statement.
		$query->select('*');
		$query->from('booking_summary');
		$query->where('memid=351 and bookingstatus = \'Confirmed\'');
		$query->order('bookingmade DESC');
	
		return $query;
	}
} // class
