<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

//use Joomla\CMS\Language\Text;
//use Joomla\CMS\MVC\View\HtmlView;
//use Joomla\CMS\Toolbar\ToolbarHelper;
//use Joomla\CMS\Toolbar\Toolbar;

/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class BookingAdminViewWinterBookings extends JViewLegacy
{
    
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->msg = 'Winter Lodge Bookings';  // get default message

		$this->items = $this->get('Items');  // get the items
		
		//$this->renderToolbar();
		
		// Display the view
		parent::display($tpl);
	}
	
	protected function renderToolbar(){
	    
	    JLoader::register('JToolbarHelper', JPATH_ADMINISTRATOR.'/includes/toolbar.php');
	    
	    
	    $app = JFactory::getApplication();
	    //$app->enqueueMessage('render toolbar');
	    
	    $title = JText::_('COM_BOOKINGADMIN_WINTERBOOKINGS_MENU');
	    
	    JToolbarHelper::title($title);
	    JToolbarHelper::addNew('winterbooking.createnew', 'COM_BOOKINGADMIN_WINTERBOOKINGS_CREATEBOOKING');
	    //JToolBarHelper::addNew('invoic.add', 'JTOOLBAR_NEW');
	    //ToolbarHelper::back();
	    //ToolbarHelper::help('JHELP_COMPONENTS_ACTIONLOGS');
	    
	    $this->toolbar = JToolbar::getInstance();
	    
	    return $this->toolbar;
	}
}