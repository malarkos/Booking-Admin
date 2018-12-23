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
class BookingAdminModelBookings extends JModelList
{
    /**
     * 
     * function to construct filter
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'bookid','bookingref'
                
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
		$query->select('b.*,concat(m.MemberFirstname,\' \',m.MemberSurname) as membername')
                ->from('booking_summary as b');
                $query->where('b.memid > 0');
                $query->leftJoin('members AS m ON b.memid = m.MemberID');
		$query->order('b.bookid DESC');
		
		// Filter: like / search
		$search = $this->getState('filter.search');
		
		if (!empty($search))
		{
		    $like = $db->quote('%' . $search . '%');
		    $query->where('bookingref LIKE ' . $like);
		}
		
		// Filter on a specific booking
		$bookid = $this->getState('filter.bookingreference');
		
		if ($bookid)
		{
		    $query->where('b.bookid = ' . (int) $bookid);
		}
		
		// Filter on a specific member
		$memberid = $this->getState('filter.bookingmembers');
		//JFactory::getApplication()->enqueueMessage("memberid".$memberid);
		if ($memberid > 0)
		{
		    
		    $query->where('b.memid = ' . (int) $memberid);
		}
		
		// Filter on booking year
		$bookingyear = $this->getState('filter.bookingyear');
		JFactory::getApplication()->enqueueMessage("bookingyear".$bookingyear);
		if ($bookingyear > 0)
		{
		    $bookinglike = $db->quote( $bookingyear . '%');
		    JFactory::getApplication()->enqueueMessage("bookinglike".$bookinglike);
		    $query->where('bookingref LIKE ' . $bookinglike);
		}
		// Add the list ordering clause.
		//$orderCol	= $this->state->get('list.ordering', 'bookingref');
		//$orderDirn 	= $this->state->get('list.direction', 'asc');
		
		//$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		//JFactory::getApplication()->enqueueMessage($query);
		
		// TODO: add a filter for Booking status
		return $query;
	}
}
