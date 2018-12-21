<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_bookingadmin
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\Utilities\ArrayHelper;
 
/**
 * HelloWorld Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @since       0.0.9
 */
class BookingAdminControllerBookingDetail extends JControllerForm
{
	public function save($key = null, $urlVar = null) {
	    
	    // Override default save for an individual guest.

	    JFactory::getApplication()->enqueueMessage('In local save');
		// Get data
		$app    = JFactory::getApplication();  // get instance of app
		$data         = $this->input->post->get('jform', array(), 'array');  // get data from the form
		$context = "$this->option.edit.$this->context";
		$recordId = $this->input->getInt($urlVar);
		$model        = $this->getModel(); // get model
		$jinput = $app->input;
		//JFactory::getApplication()->enqueueMessage('$jinput  = '.$jinput.":");
		$bookingdetailid = $jinput->get('id','','text'); 
		// index.php?option=com_bookingadmin&view=bookingdetail&layout=edit&id=7709
		/*if ($bookingdetailid > 0) {
			$returnfailurl = 'index.php?option=com_bookingadmin&view=bookingdetail&layout=edit&id='.$bookingdetailid;
		}else {
			$returnfailurl = 'index.php?option=com_bookingadmin&view=bookingdetail&layout=edit';
		}
		$this->setRedirect($returnfailurl);*/
		// Save the data in the session.
		$app->setUserState($context . '.data', $data);
		// get booking reference from the session variable
		$session = JFactory::getSession();
		$bookingref = $session->get('bookingref');
		$cost = $data['cost']; //$jinput->get('cost','0','float'); // 
		JFactory::getApplication()->enqueueMessage('$cost  = '.$cost.":");
		
		if (strlen($cost) == 0) {
		    $data['cost']=0;  // set a default cost.
		    JFactory::getApplication()->enqueueMessage('setting cost to zero');
		}
		// Set redirection back to edit screen for error conditions.
		$this->setRedirect(
		    JRoute::_(
		        'index.php?option=' . $this->option . '&view=' . $this->view_item
		        . $this->getRedirectToItemAppend($recordId, $urlVar), false
		        )
		    );
		
		
		
		
	
		// Get values
		
			
		// data validation
		// if Member and no member selected
		if ($data['memguest'] == 'm' && $data['memberval'] == 0) {
			JError::raiseError( 1000, 'For Guest Type of Member, you need to select a Member!' );
			return false;
		}
		// if Family Member and no family member selected
		if ($data['memguest'] == 'f' && $data['fammemberval'] == 0) {
			JError::raiseError( 1000, 'For Guest Type of Family Member, you need to select a Family Member!' );
			return false;
		}
		// if buddy or guest and firstname and/or lastname are blank
		if ($data['memguest'] == 'b' || $data['memguest'] == 'g' ) {
			if ( strlen($data['guestfirstname']) == 0 || strlen($data['guestsurname']) == 0 )  {
		
				JError::raiseError( 1000, 'For Buddy and Guests, please enter both First name and Last name.' );
				return false;
			}
		}
		
		JFactory::getApplication()->enqueueMessage('Date in = '.$data['datein'].':');
		JFactory::getApplication()->enqueueMessage('Date out = '.$data['dateout'].':');
		// if Date in is blank = error
		if (strlen($data['datein']) == 0) {
			JError::raiseError( 1000, 'Please enter a valid Date In.' );
			return false;
		}
		// if Date out is blank = error
		if (strlen($data['dateout']) == 0) {
			JError::raiseError( 1000, 'Please enter a valid Date Out.' );
			return false;
		}
		// need to ensure proper dates
		
		// if Date in >= Date out = error
		$datein  = DateTime::createFromFormat('Y-m-d', $data['datein']);
		$dateout  = DateTime::createFromFormat('Y-m-d', $data['dateout']);
		JFactory::getApplication()->enqueueMessage('Datein  = '.$datein->format('Y-m-d'));
		JFactory::getApplication()->enqueueMessage('Dateout  = '.$dateout->format('Y-m-d'));
		if ($dateout <= $datein) {
			JError::raiseError( 1000, 'Date Out must be later than Date In.' );
			return false;
		}
		
		// get booking cost
		$bookingcost = BookingsHelper::bookingCost($datein, $dateout, $data['age'], $data['memguest'],$data['memberval'],$data['fammemberval']);
		JFactory::getApplication()->enqueueMessage('$bookingcost  = '.$bookingcost.":");
		
		// update additional values in the table or form
		$wpdisc = BookingsHelper::workpartyDiscount($data['memguest'],$data['memberval']);
		$bookingcost = ((100 - $wpdisc) / 100) * $bookingcost;  // apply work party discount
		$data['cost']=$bookingcost;
		$session->set('bookingcost',$bookingcost);
		// update overall booking cost
		
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'bookingcost' );
		$query->from ( 'booking_summary' );
		$query->where ( 'bookingref = ' . $bookingref );
		$db->setQuery ( $query );
		$bookingtotalcost = $db->loadResult();
		
		$bookingtotalcost += (float)$bookingcost - $cost;
		JFactory::getApplication()->enqueueMessage('$bookingtotalcost  = '.$bookingtotalcost.":");
		
		$query = $db->getQuery ( true );
		$fields = array('bookingcost = '. $db->quote($bookingtotalcost)
		);
		$conditions = array('bookingref = '. $bookingref );
		$query->update('booking_summary');
		$query->set($fields);
		$query->where($conditions);
		
		$db->setQuery ( $query );
		$db->execute ();
		
		
		// Get booking status
		$query = $db->getQuery ( true );
		$query->select ( 'bookingstatus' );
		$query->from ( 'booking_summary' );
		$query->where ( 'bookingref = ' . $bookingref );
		$db->setQuery ( $query );
		$bookingstatus= $db->loadResult();
		
		
		// calculate guestnum
		
		$guestnum = $data['guestnum'];
		if ($guestnum > 0)   // if we already have a number ignore
		{
		    // do nothing
		    $session->set('guestnum',$guestnum);
		}
		else {
		    $query = $db->getQuery ( true );
		    $query->select ( 'max(guestnum) as maxguestnum' );
		    $query->from ( 'booking_main' );
		    $query->where ( 'bookingref = ' . $bookingref );
		    $db->setQuery ( $query );
		    $ret = $db->loadObject();
		    $curmaxguestname = $ret->maxguestnum + 1; // increment
		    $session->set('guestnum',$curmaxguestname);
		    JFactory::getApplication()->enqueueMessage('guestnum  = '.$curmaxguestname.":");
		    $guestnum = $ret->maxguestnum + 1;
		}
		// add to room list
		JFactory::getApplication()->enqueueMessage('About to loop through room nights.');
		// delete any entries
		$query = $db->getQuery ( true );
		$fields = array('bookingref = 0');  // set booking ref = 0 for any existing entries.
		$conditions = array('bookingref = '. $bookingref ,'guestnum = '.$guestnum);
		$query->update('booking_rooms');
		$query->set($fields);
		$query->where($conditions);
		
		$db->setQuery ( $query );
		$db->execute ();
		
		$datein  = DateTime::createFromFormat('Y-m-d', $data['datein']);
		$dateout  = DateTime::createFromFormat('Y-m-d', $data['dateout']);
		$dateval = $datein;
		$interval = DateInterval::createfromdatestring('+1 day');
		JFactory::getApplication()->enqueueMessage('Datein  = '.$datein->format('Y-m-d'). ' dateval = '.$dateval->format('Y-m-d'). ' dateout = '.$dateout->format('Y-m-d'));
		$n=0;
		$gender = $data['gender'];
		$room = $data['room'];
		$memguest = $data['memguest'];
		$memid = $data['memberval'];
		$guestfirstname = $data['guestfirstname'];
		$guestsurname = $data['guestsurname'];
		while ( $dateval < $dateout) {
		    
		    JFactory::getApplication()->enqueueMessage('In to loop through room nights. n = '.$n.'dateval = '.$dateval->format('Y-m-d'));
		    
		    $query = $db->getQuery(true);
		    
		    $datevalload = (string)$dateval->format('Y-m-d');
		    
		    //$query->columns($db->quoteName('bookingref'),$db->quoteName('roomnight'),$db->quoteName('oldbookingref'),$db->quoteName('gender'),$db->quoteName('room'),$db->quoteName('memguest'),$db->quoteName('memid'),$db->quoteName('guestfirstname'),$db->quoteName('guestsurname'));
		    //$query->values($db->quote($bookingref),      $db->quote($dateval),       $db->quote($bookingref),        $db->quote($gender),     $db->quote($room),     $db->quote($memguest),     $db->quote($memid),     $db->quote($guestfirstname),     $db->quote($guestsurname));
		    
		    $columns = array('bookingref','oldbookingref','gender','room','memguest','memid','guestfirstname','guestsurname'); //'roomnight',
		    
		    $values = array($bookingref,            $bookingref,        $gender,     $room,     $memguest,     $memid,     $guestfirstname,     $guestsurname); // $datevalload,
		    
		    $query->insert('booking_rooms')
		    ->columns(array($db->quoteName('bookingref'),$db->quoteName('roomnight'),$db->quoteName('oldbookingref'),$db->quoteName('gender'),$db->quoteName('room'),$db->quoteName('memguest'),$db->quoteName('guestnum'),$db->quoteName('memid'),$db->quoteName('guestfirstname'),$db->quoteName('guestsurname'),$db->quoteName('bookingstatus')))
		    ->values($db->quote($bookingref). ', ' .    $db->quote($datevalload)  . ', ' .          $db->quote($bookingref). ', ' .        $db->quote($gender). ', ' .      $db->quote($room). ', ' .    $db->quote($memguest). ', ' .    $db->quote($guestnum). ', ' .     $db->quote($memid). ', ' .     $db->quote($guestfirstname). ', ' .    $db->quote($guestsurname). ', ' .    $db->quote($bookingstatus));
		    JFactory::getApplication()->enqueueMessage('query = '.$query);
		    $db->setQuery($query);
		    try
		    {
		        $db->execute();
		    }
		    catch (RuntimeException $e)
		    {
		        $this->setError($e->getMessage());
		        
		        return false;
		    }
		    
		    /*
		     * 
		     * $db    = JFactory::getDBO();
		
		
		// if $id > 0 then update, otherwise insert
		if ($id > 0) {
			$query->update('oscbookingmain');
			$query->set('guestfirstname ='.$db->quote($guestfirstname));
			$query->set('guestsurname ='.$db->quote($guestsurname));
			$query->where('id = '.$db->quote($id));
			$db->setQuery((string)$query);
		 	
		 	
		} else {
			$query->insert('oscbookingmain');
			$query->columns($db->quoteName('guestfirstname'),$db->quoteName('guestsurname'));
			$query->values($db->quote($guestfirstname),$db->quote($guestsurname));
			$db->setQuery((string)$query);
		}
		
		// execute the query
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
		     */
		    
		    $n++;
		    $dateval->add($interval);
		}
		
		$return = parent::save($key, $urlVar);
		// Need to update booking cost, increment id
		// Set return URL on success
		$returnsuccessurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
		$this->setRedirect($returnsuccessurl);
		return $return;
	}
	
	public function cancel($key = null, $urlVar = null) {
	
		// override return to go back to the right place
		//$app    = JFactory::getApplication();
		//$jinput = $app->input;
		//$bookingref = $jinput->get('bookingref','','text');
		$session = JFactory::getSession();
		$bookingref = $session->get('bookingref');
		$return = parent::cancel($key, $urlVar);
		$returnurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
	
		$this->setRedirect($returnurl);
		return $return;
	}
	
	public function deleteguest($key = null, $urlVar = null) {
	    
	    
	    // Check for request forgeries.
	    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
	    
	    // Get all selected items
	    $ids = $this->input->get('cid', array(), 'array');
	   
	    // Load database objects
	    $db = JFactory::getDbo ();
	    $session = JFactory::getSession();
	    $bookingref = $session->get('bookingref');
	
	    if(!empty($ids))
	    {
	        $model = $this->getModel();
	        
	        $ids = ArrayHelper::toInteger($ids);
	        foreach ($ids as $id) {
	            JFactory::getApplication()->enqueueMessage('ID to delete is  = '.$id.":");
	            
	            // Update booking cost
	            $query = $db->getQuery ( true );
	            $query->select ( 'cost' );
	            $query->from ( 'booking_main' );
	            $query->where ( 'id = ' . $id );
	            $db->setQuery ( $query );
	            $cost = $db->loadResult();
	            JFactory::getApplication()->enqueueMessage($query);
	            
	            $query = $db->getQuery ( true );
	            $query->select ( 'bookingcost' );
	            $query->from ( 'booking_summary' );
	            $query->where ( 'bookingref = ' . $bookingref );
	            $db->setQuery ( $query );
	            JFactory::getApplication()->enqueueMessage($query);
	            $bookingcost = $db->loadResult();
	            
	            $bookingtotalcost = $bookingcost - $cost;
	            
	            JFactory::getApplication()->enqueueMessage($cost.":".$bookingcost.":".$bookingtotalcost);
	            
	            $query = $db->getQuery ( true );
	            $fields = array('bookingcost = '. $db->quote($bookingtotalcost)
	            );
	            $conditions = array('bookingref = '. $bookingref );
	            $query->update('booking_summary');
	            $query->set($fields);
	            $query->where($conditions);
	            
	            $db->setQuery ( $query );
	            $db->execute ();
	            $query = $db->getQuery ( true );
	            $fields = array('bookingref = 0');
	            $conditions = array( 'id = ' . $id  );
	            $query->update('booking_main');
	            $query->set($fields);
	            $query->where($conditions);
	            
	            $db->setQuery ( $query );
	            $db->execute ();
	            
	            // Change bookingref to zero
	        }
	    }
	    
		$session = JFactory::getSession();
		$bookingref = $session->get('bookingref');
		//$return = parent::delete($key, $urlVar);
		$returnurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
	
		$this->setRedirect($returnurl);
		return $return;
	}
	
	
}
