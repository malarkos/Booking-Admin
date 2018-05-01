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
class BookingAdminModelBookingDetail extends JModelAdmin
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
	public function getTable($type = 'BookingDetail', $prefix = 'BookingAdminTable', $config = array())
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
				'com_bookingadmin.bookingdetail',
				'bookingdetail',
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
				'com_bookingadmin.edit.bookingdetail.data',
				array()
		);

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}
	
	protected function prepareTable($table)
	{
	    // update last modified
	    $dt = new DateTime();
	    $dt->format('Y-m-d H:i:s');
	    $db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		// populate values
		// set the booking reference
		$session = JFactory::getSession();
		$bookingref = $session->get('bookingref');
		$guestcost = $session->get('bookingcost');
		$guestnum = $session->get('guestnum');
		$table->guestnum = $guestnum;
		JFactory::getApplication()->enqueueMessage('guestnum = '.$guestnum.':');
		$table->cost = $guestcost;
		$table->bookingref = $bookingref;
		$table->oldbookingref = $bookingref;
		// set guestnum
		
		// Set Firstname and lastname
		// Get membership type. If Member or Family member, do the lookup.
		$memtype = $table->memguest;
		if ($memtype == "m") {
			$memid=$table->memberval;
			$query->select ( 'MemberFirstname,MemberSurname' );
			$query->from ( 'members' );
			$query->where ( 'MemberID = ' . $memid );
			$db->setQuery ( $query );
			$memberdetail = $db->loadObject();
			$table->guestfirstname = $memberdetail->MemberFirstname;
			$table->guestsurname = $memberdetail->MemberSurname;
			$table->wpdisc = BookingsHelper::workpartyDiscount($memtype,$memid);
			JFactory::getApplication()->enqueueMessage('Member work party discount = '.$table->wpdisc.':');
		}
		if ($memtype == "f") {
			$memid=$table->fammemberval;
			$query->select ( 'FamilyMemberFirstname,FamilyMemberSurname' );
			$query->from ( 'familymembers' );
			$query->where ( 'FamilyMemberID = ' . $memid );
			$db->setQuery ( $query );
			$memberdetail = $db->loadObject();
			$table->guestfirstname = $memberdetail->FamilyMemberFirstname;
			$table->guestsurname = $memberdetail->FamilyMemberSurname;
			$table->wpdisc = BookingsHelper::workpartyDiscount($memtype,$memid);
		}
		
		
		$table->lastmodified = $dt;
	
	}
	
	
}