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
class BookingAdminModelLodgeAvailability extends JModelList
{
    
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'roomid','bookingyear','roomnight'
                
            );
        }
        
        parent::__construct($config);
    }
    
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
 
		// Create the base select statement.
		//$query->select('o.*,date_format(DateBooked,\'%d-%m-%y\') as datebookingmade,date_format(DatePaid,\'%d-%m-%y\') as datebookingpaid,concat(m.MemberFirstname,\' \',m.MemberSurname) as membername,t.TableName as tablename');
		//$query->from('osc50bookings AS o');
		
		$query->select('roomnight, count(\'roomnight\') as roomnightcount');
		$query->from('booking_rooms');
		$query->where('roomnight like \'2018%\'');
		$query->where('bookingref > 0');
        $query->group('roomnight');
        
        // Filter on booking year
        $bookingyear = $this->getState('filter.bookingyear');
        JFactory::getApplication()->enqueueMessage("bookingyear".$bookingyear);
        if ($bookingyear > 0)
        {
            $bookinglike = $db->quote( $bookingyear . '%');
            JFactory::getApplication()->enqueueMessage("bookinglike".$bookinglike);
            $query->where('roomnight LIKE ' . $bookinglike);
        }
        
        JFactory::getApplication()->enqueueMessage('Lodge Availability search query = '.$query);
		return $query;
	}
	
	//override default list
	protected function populateState($ordering = null, $direction = null)
	{
	    // Initialise variables.
	    $app = JFactory::getApplication();
	    
	    // List state information
	    $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
	    
	    $limit = 2000;  // set list limit
	    
	}
}
