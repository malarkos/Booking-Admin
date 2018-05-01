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
class BookingAdminModelBookingSummary extends JModelAdmin
{
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'BookingSummary', $prefix = 'BookingAdminTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
				'com_bookingadmin.bookingsummary',
				'bookingsummary',
				array(
						'control' => 'jform',
						'load_data' => $loadData
				)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
				'com_bookingadmin.edit.bookingsummary.data',
				array()
		);

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}
	
	/*
	 * Function to update the table values before saving
	 */
	protected function prepareTable($table) //prepareTable(&$table)
	{
	    
	    $dt = new DateTime();
	    $session = JFactory::getSession();
	    $db = JFactory::getDbo ();
	    $query = $db->getQuery ( true );
		$bookid = $table->bookid;
		//JFactory::getApplication()->enqueueMessage('Bookid = '.$bookid);
		if (strlen($bookid) > 1) 
		{
		    // do nothing
		    $bookingref = $table->bookingref;
		    $session = JFactory::getSession();
		    
		    $session->set('bookingref', $bookingref);
		}
		else 
		{
        		//$session = JFactory::getSession();
        		//$bookingref = $session->get('bookingref');
        		//$table->bookingref=$bookingref;
        		// update valid in table
        		
		    $memid = $table->memid;
		    // Get the booking reference ID for member NextBookingNum
		    $query->select ( 'NextBookingNum' );
		    $query->from ( 'members' );
		    $query->where ( 'MemberID = ' . $memid );
		    $db->setQuery ( $query );
		    $nextbookingnum = $db->loadResult();
		    
		    // create booking reference
		    $yearval = date('Y');
		    $bookingref = sprintf("%04d%04d%03d",$yearval,$memid,$nextbookingnum);
		    //JFactory::getApplication()->enqueueMessage('Bookingref = '.$bookingref);
		    
		    // Add booking reference to the table
		    $table->bookingref = $bookingref ;
		    
		    // Set session variable to pass back to save function
		    $session = JFactory::getSession();
		   
		    $session->set('bookingref', $bookingref);
		    
		    // Update count in member table
		    $nextbookingnum++;
		    $query = $db->getQuery ( true );
		    $fields = array('NextBookingNum = '. $db->quote($nextbookingnum)
		    );
		    $conditions = array('MemberId = '. $memid );
		    $query->update('members');
		    $query->set($fields);
		    $query->where($conditions);
		    
		    $db->setQuery ( $query );
		    $db->execute ();
        		$dt->format('Y-m-d');
        		$table->bookingmade = date('Y-m-d');
        		$table->bookingstatus = 'Draft';
        		$table->numentries = 0;
        		$table->bookingpaid = 'No';
        		$table->entrynum=0;
		}
		$dt->format('Y-m-d H:i:s');
		$table->lastmodified = $dt;
	}
}