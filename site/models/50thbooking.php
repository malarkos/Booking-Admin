
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
class BookingAdminModel50thBooking extends JModelForm
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
	
	public function getTable($type = '50thBooking', $prefix = 'BookingAdminTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	public function getBookings()
	{
		// TODO - function to return all 50th bookings for the member 
		$bookings = array();  // initialise to a null array.
		$memid=0;
		
		// get user and email
		// get member id
		// Get logged in user info
		$user = JFactory::getUser();
		
		$useremail = $user->email;
		
		
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query->select('MemberID');
		$query->from('members');
		$query->where('memberemail = '.$db->quote($useremail));
		
		$db->setQuery($query);
		
		try  // ensure in a try block for any errors.
		{
			//$row = $db->loadAssoc();
			$memid = $db->loadResult();
		}
		catch (RuntimeException $e)
		{
			$this->setError(JText::sprintf('COM_MEMBERS_DATABASE_ERROR', $e->getMessage()), 500);
		
			return false;
		}
		// get all records from osc50bookings with that memberID and return
		//JFactory::getApplication()->enqueueMessage(JText::_('Member id = '.$memid));
		
		if ($memid > 0) // check we have a valid memberid
		{
			$query = $db->getQuery ( true );
			
			$query->select ( '*,date_format(DateBooked,\'%d-%m-%y\') as bookingdate' );
			$query->from ( 'osc50bookings' );
			$query->where ( 'MemberID = ' . $memid);
			
			$db->setQuery ( $query );
			$db->execute ();
			$num_rows = $db->getNumRows ();
			$bookings = $db->loadObjectList ();
			//JFactory::getApplication()->enqueueMessage(JText::_('Row returned:'.$num_rows));
		}
		
		
		return $bookings;
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_bookingadmin.50thbooking', '50thbooking', array('control' => 'jform', 'load_data' => $loadData));
	
		if (empty($form))
		{
			return false;
		}
	
		// return form variable
		return $form;
	} // getForm
	
	public function getData()
	{
		
		
		// get id from URL. 
		// if no id, return a blank array
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		// Get query info from input
		$jinput = JFactory::getApplication()->input;
		$bookingid = $jinput->get('bookingid');
		//JFactory::getApplication()->enqueueMessage(JText::_('Booking id = '.$bookingid));
		
		if ($bookingid > 0) // have valid data
		{
			$query->select('*');
			$query->from('osc50bookings');
			$query->where('id = '.$db->quote($bookingid));
			
			$db->setQuery($query);
			
			try  // ensure in a try block for any errors.
			{
			
				$row = $db->loadObject();
			}
			catch (RuntimeException $e)
			{
				$this->setError(JText::sprintf('COM_MEMBERS_DATABASE_ERROR', $e->getMessage()), 500);
			
				return false;
			}
		}
		
			
		return $row;
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
		$data = $this->getData();
	
		$this->preprocessData('com_bookingadmin.50thbooking', $data);
	
		return $data;
	} // loadFormData
	
	/*
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  mixed  The user id on success, false on failure.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		
		$date = JFactory::getDate();
		$user = JFactory::getUser();
		$id = $data['id'] ;
		
		JFactory::getApplication()->enqueueMessage(JText::_('Table id = '.$id));
		
		// get the table
		$table = $this->getTable("50thBooking");
		
		if (!isset($data['id']))
		{
			JFactory::getApplication()->enqueueMessage(JText::_('new entry'));
			$data['DateBooked'] = $date->toSql();
			$useremail = $user->email;
				
				
			$db    = JFactory::getDBO();
			$query = $db->getQuery(true);
				
			$query->select('MemberID');
			$query->from('members');
			$query->where('memberemail = '.$db->quote($useremail));
				
			$db->setQuery($query);
				
			try  // ensure in a try block for any errors.
			{
				//$row = $db->loadAssoc();
				$memid = $db->loadResult();
			}
			catch (RuntimeException $e)
			{
				$this->setError(JText::sprintf('COM_MEMBERS_DATABASE_ERROR', $e->getMessage()), 500);
					
				return false;
			}
			$data['MemberID'] = $memid;
			JFactory::getApplication()->enqueueMessage(JText::_('Member id = '.$memid));
		} // if
		
		$data['lastModified'] =  $date->toSql();
	
		// save the data
		if (!$table->save( $data )) {
			return false;
		}
	
		// need to update email and login id if email address has changed
	
		//if (!$this->store()) {
		//	return false;
		//}
	
		/* $db = $this->getDbo();
			$query = $db->getQuery(true);
	
			$memid = 351;
			//$firstname = $data->MemberFirstname;
			$firstname = $data['MemberFirstname'];
			//$firstname='Geoffrey';
	
			//$query->update($db->quoteName('oscmembers'))
			//->set($db->quoteName('MemberFirstname') . ' = ' . $db->quoteName($firstname))
			//->where($db->quoteName('id') . ' = ' . $db->quoteName($memid));
			//->where('id = ' . $memid);
	
			// Create the base update statement.
			$query->update('oscmembers')->set('MemberFirstname = ' . $firstname)->where('id = ' . $memid);
	
			// Set the query and execute the update.
			$db->setQuery($query);
	
			try
			{
			$db->execute();
			}
			catch (RuntimeException $e)
			{
			JError::raiseWarning(500, $e->getMessage());
	
			return false;
			}
			*/
		return true;
	
	} // save
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();
		$id = $table->id ;
		
		JFactory::getApplication()->enqueueMessage(JText::_('Table id = '.$bookingid));
		
		if (!isset($table->id))
		{
			JFactory::getApplication()->enqueueMessage(JText::_('new booking'));
			$table->DateBooked = $date->toSql();
			$useremail = $user->email;
			
			
			$db    = JFactory::getDBO();
			$query = $db->getQuery(true);
			
			$query->select('MemberID');
			$query->from('members');
			$query->where('memberemail = '.$db->quote($useremail));
			
			$db->setQuery($query);
			
			try  // ensure in a try block for any errors.
			{
				//$row = $db->loadAssoc();
				$memid = $db->loadResult();
			}
			catch (RuntimeException $e)
			{
				$this->setError(JText::sprintf('COM_MEMBERS_DATABASE_ERROR', $e->getMessage()), 500);
			
				return false;
			}
			$table->MemberID = $memid;
			JFactory::getApplication()->enqueueMessage(JText::_('Member id = '.$memid));
		} // if
		
		$table->lastModified =  $date->toSql();
	} // function
	
	
	
} // class
