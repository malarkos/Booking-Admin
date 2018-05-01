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
class BookingAdminViewLodgeAvailability extends JViewLegacy
{
    protected $items;
    protected $pagination;
    protected $state;
    public $filterForm;
    public $activeFilters;
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
	    
	    // Get application
	    $app = JFactory::getApplication();
	    $context = "bookingadmin.list.admin.lodgeavailability";
	    
		// Get data from the model
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state			= $this->get('State');
		$this->filterForm    	= $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
 
			return false;
		}
		// Helper file with code to build side menu
		require_once JPATH_COMPONENT . '/helpers/bookingadmin.php';
		// Call to build the sub menu
		BookingAdminHelper::addSubmenu("lodgeavailability");
		// render the sub menu on the screen.
		$this->sidebar = JHtmlSidebar::render();
		// Set the toolbar

		$this->addToolBar();
		
		// Display the template
		parent::display($tpl);
	}
	
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_BOOKINGADMIN_LODGEAVAILABILITY'));
		//JToolBarHelper::addNew('bookingintegrity.add');
		//JToolBarHelper::editList('summerbooking.edit');
		//JToolBarHelper::deleteList('', '50thbooking.delete');
	}
}
