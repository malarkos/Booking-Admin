<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h3><?php echo $this->msg; ?></h3>
<?php 
	// Create links
	$winterlink = JRoute::_ ( 'index.php?option=com_bookingadmin&view=winterbookings' );
	$summerlink = JRoute::_ ( 'index.php?option=com_bookingadmin&view=summerbookings' );
	

?>
Members can manage all of their bookings from this page.
<ul>
<li><a href="<?php echo $winterlink; ?>">Winter Bookings</a> - all bookings during the normal ski season.</li>
<li><a href="<?php echo $summerlink; ?>">Summer Bookings</a> - off season bookings.</li>
</ul>