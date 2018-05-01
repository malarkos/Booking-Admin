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
 * HelloWorlds View
 *
 * @since  0.0.1
 */
class BookingAdminViewBooking extends JViewLegacy
{
    
    protected $items;
    protected $bookingdetails;
   
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
	    
			// Get data from the model
		$this->items		= $this->get('Items'); // Get summary
		$this->bookingdetails = $this->get('BookingDetails');
		
		// call to get booking details
		$this->pagination	= $this->get('Pagination');
		$this->state			= $this->get('State');
	
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
 
			return false;
		}
		// Helper file with code to build side menu
		require_once JPATH_COMPONENT . '/helpers/bookingadmin.php';
		// Call to build the sub menu
		BookingAdminHelper::addSubmenu("bookings");
		// render the sub menu on the screen.
		$this->sidebar = JHtmlSidebar::render();
		// Set the toolbar
		$this->addToolBar();
		
		// Display the template
		parent::display($tpl);
		

	}
	
	protected function addToolBar()
	{
	    
	   
		JToolBarHelper::title(JText::_('COM_HELLOWORLD_MANAGER_BOOKINGADMIN'));
		JToolBarHelper::addNew('bookingdetail.add','Add Guest');
		JToolBarHelper::editList('bookingdetail.edit','Edit Guest');
		JToolBarHelper::custom('bookingdetail.deleteguest','trash.png', 'trash_f2.png','Delete Guest',true);
		JToolBarHelper::custom('bookingsummary.bookingpaid','featured.png', 'featured_f2.png','Booking Paid',false);
		JToolBarHelper::custom('bookingsummary.sendmemberemail','featured.png', 'featured_f2.png','Send Member Email',false);
		//JToolBarHelper::deleteList('', 'bookings.delete');
	}
	
	
	
}
