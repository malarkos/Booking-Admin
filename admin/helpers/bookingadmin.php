<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_reference
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class  BookingAdminHelper extends JHelperContent
{
    public static function addSubmenu($vName)
    {
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_BOOKINGS'),
            'index.php?option=com_bookingadmin&view=bookings',
            $vName == 'bookings'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_SUMMERBOOKINGS'),
            'index.php?option=com_bookingadmin&view=summerbookings',
            $vName == 'summerbookings'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_BOOKINGSINTEGRITYCHECK'),
            'index.php?option=com_bookingadmin&view=bookingintegrity',
            $vName == 'bookingintegrity'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_BOOKINGSMAP'),
            'index.php?option=com_bookingadmin&view=bookingsmap',
            $vName == 'bookingsmap'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_LODGEAVAILABILITY'),
            'index.php?option=com_bookingadmin&view=lodgeavailability',
            $vName == 'lodgeavailability'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_ROOMALLOCATION'),
            'index.php?option=com_bookingadmin&view=roomallocation',
            $vName == 'roomallocation'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_BEDLIST'),
            'index.php?option=com_bookingadmin&view=bedlist',
            $vName == 'bedlist'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_PRESDATES'),
            'index.php?option=com_bookingadmin&view=presweekend',
            $vName == 'presweekend'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_BOOKINGADMIN_STUDENTDATES'),
            'index.php?option=com_bookingadmin&view=studentweek',
            $vName == 'studentweek'
            );
        
    }// function
}