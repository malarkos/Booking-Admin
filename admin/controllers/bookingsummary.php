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
 
/**
 * HelloWorld Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @since       0.0.9
 */
class BookingAdminControllerBookingSummary extends JControllerForm
{
	/*
	 * Function to override save by creating the booking reference id
	 */
	public function saveclose($key = null, $urlVar = null) {
		
		$app    = JFactory::getApplication();  // get instance of app
		$data         = $this->input->post->get('jform', array(), 'array');  // get data from the form
		
		// Call parent to save
		$return = parent::save($key, $urlVar);
		
		
		// Get session variable from prepar
		$session = JFactory::getSession();
		$bookingref = $session->get('bookingref');
		$session->clear('bookingref');
		//JFactory::getApplication()->enqueueMessage('Bookingref in='.$bookingref);
		// Set return URL to the newly created booking
		
		$returnsuccessurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
		$this->setRedirect($returnsuccessurl);
		
		// return from the function
		return $return;
	}
	
	public function cancel($key = null, $urlVar = null) {
	    
	    // override return to go back to the right place
	    $app    = JFactory::getApplication();
	    $data         = $this->input->post->get('jform', array(), 'array');  // get data from the form
	   
	    $bookingref = $data['bookingref'];
	    $return = parent::cancel($key, $urlVar);
	    $returnurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
	    
	    $this->setRedirect($returnurl);
	    return $return;
	}
	
	/*public function paybooking ()
	{
	    JFactory::getApplication()->enqueueMessage('In Paybooking');
	    $jinput = JFactory::getApplication()->input;
	    $bookingref = $jinput->get('bookingref','','text');
	    JFactory::getApplication()->enqueueMessage('Bookingref ='.$bookingref);
	}*/
	public function SendMemberEmail ()
	 {
        	 JFactory::getApplication()->enqueueMessage('In SendMemberEmail');
        	 //$jinput = JFactory::getApplication()->input;
        	 //$bookingref = $jinput->get('bookingref','','text');
        	 //JFactory::getApplication()->enqueueMessage('Bookingref ='.$bookingref);
        	 
        	 // Save any changes
        	 parent::save($key, $urlVar);
        	 
        	 // Set up mail
        	 // Get mailer object
        	 $mailer = JFactory::getMailer();
        	 
        	 // Set Sender
        	 $config = JFactory::getConfig();
        	 $sender = array(
        	     $config->get( 'mailfrom' ),
        	     $config->get( 'fromname' )
        	 );
        	 
        	 $mailer->setSender($sender);
        	 
        	 // Set recipient
        	 $recipient = 'geoffm@labyrinth.net.au';
        	 $mailer->addRecipient($recipient);
       
        	 // Create message body
        	 $body = "this is the mail message";
        	 $siteURL  = JUri::root() . 'administrator/index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
        	 
        	 $mailer->setSubject('Test message');
        	 $mailer->setBody($siteURL);
        	 
        	 // Send the message
        	 $send = $mailer->Send();
        	 if ( $send !== true ) {
        	     echo 'Error sending email: ';
        	 } else {
        	     echo 'Mail sent';
        	 }
        	 
        	 // set return value
        	 $session = JFactory::getSession();
        	 $bookingref = $session->get('bookingref');
        	 $returnurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
        	 
        	 $this->setRedirect($returnurl);
        	 return $return;
	 }
	 public function BookingPaid ()
	 {
	     /*
	      * Function to:
	      * 1. Set Amount paid = Booking cost
	      * 2. Set status = confirmed
	      * 3. Set paid = yes
	      */
	     JFactory::getApplication()->enqueueMessage('In Booking Paid');
	     //$jinput = JFactory::getApplication()->input;
	     //$bookingref = $jinput->get('bookingref','','text');
	     //JFactory::getApplication()->enqueueMessage('Bookingref ='.$bookingref);
	     // set return value
	     $session = JFactory::getSession();
	     $bookingref = $session->get('bookingref');
	     
	     
	     // update values
	     $db = JFactory::getDbo ();
	     $query = $db->getQuery ( true );
	     
	     $query->select ( 'bookingcost' );
	     $query->from ( 'booking_summary' );
	     $query->where ( 'bookingref = ' . $bookingref );
	     $db->setQuery ( $query );
	     $bookingcost= $db->loadResult();
	     
	     
	     $query = $db->getQuery ( true );
	     $fields = array('amountpaid = '. $db->quote($bookingcost),
	         'bookingstatus = '. $db->quote('Confirmed'),
	         'bookingpaid =  '. $db->quote('Yes')	     );
	     $conditions = array('bookingref = '. $bookingref );
	     $query->update('booking_summary');
	     $query->set($fields);
	     $query->where($conditions);
	     JFactory::getApplication()->enqueueMessage('query ='.$query);
	     $db->setQuery ( $query );
	     try
	     {
	         $db->execute();
	     }
	     catch (RuntimeException $e)
	     {
	         $this->setError($e->getMessage());
	         
	         return false;
	     }
	     
	     $returnurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
	     $this->setRedirect($returnurl);
	     return $return;
	 }
	 
	 public function ApproveBooking ()
	 {
	     
	     // Function to set booking status to Approved, create finance entry and email Member
	     
	     //JFactory::getApplication()->enqueueMessage('in Approve Booking');
	     $session = JFactory::getSession();
	     $bookingref = $session->get('bookingref');
	     
	     // Set status to Approved
	     // update values
	     $db = JFactory::getDbo ();
	     $query = $db->getQuery ( true );
	     
	     $query->select ( 'bookingcost' );
	     $query->from ( 'booking_summary' );
	     $query->where ( 'bookingref = ' . $bookingref );
	     $db->setQuery ( $query );
	     $bookingcost= $db->loadResult();
	     $query = $db->getQuery ( true );
	     $query->select ( 'bookingstatus' );
	     $query->from ( 'booking_summary' );
	     $query->where ( 'bookingref = ' . $bookingref );
	     $db->setQuery ( $query );
	     $bookingstatus= $db->loadResult();
	     
	     // Bookings go from Draft -> Approved -> Confirmed (when paid)
	     if ( $bookingstatus == "Draft") 
	     {
    	     $query = $db->getQuery ( true );
    	     $fields = array('bookingstatus = '. $db->quote('Approved'));
    	     $conditions = array('bookingref = '. $bookingref );
    	     $query->update('booking_summary');
    	     $query->set($fields);
    	     $query->where($conditions);
    	     //JFactory::getApplication()->enqueueMessage('query ='.$query);
    	     $db->setQuery ( $query );
    	     try
    	     {
    	         $db->execute();
    	     }
    	     catch (RuntimeException $e)
    	     {
    	         $this->setError($e->getMessage());
    	         
    	         return false;
    	     }
    	     
    	     // Add Finance entry
    	     
    	     // Email member
    	     
    	     
	     } // if booking status == draft
	     else
	     {
	         JFactory::getApplication()->enqueueMessage('Only Draft bookings can be approved.');
	     }
	    
	     
	    
	     $returnurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
	     
	     $this->setRedirect($returnurl);
	     return $return;
	 }
	 
	 public function cancelBooking ()
	 {
	     // Get booking ref from session variable
	     $session = JFactory::getSession();
	     $bookingref = $session->get('bookingref');
	     
	     $app    = JFactory::getApplication();  // get instance of app
	     $jinput = $app->input;
	     //JFactory::getApplication()->enqueueMessage('$jinput  = '.$jinput.":");
	     $refund = $jinput->get('refund','','text'); 
	     
	     JFactory::getApplication()->enqueueMessage('Refund =  '.$refund.":");
	     
	     // Set status to Cancelled
	     // Delete any room bookings
	     // Is it 0% refund, 80% refund or 100% refund
	     
	     // Set return URL
	     $returnurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
	     
	     $this->setRedirect($returnurl);
	     return $return;
	 }
}
