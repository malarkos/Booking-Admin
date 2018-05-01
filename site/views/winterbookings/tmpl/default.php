<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h3><?php echo $this->msg; ?></h3>

<h3>Current Bookings</h3>

<h3>Past bookings</h3>

<?php if (!empty($this->items)) : 

	$form = "<table class=\"table table-striped table-hover\">
		<thead>";
	$form .= "<tr><th>Booking Reference</th></tr>";
	$form .= "</thead>";
	$form .= "<tbody>";
	
	foreach ( $this->items as $i => $row ) :
		$link = JRoute::_ ( 'index.php?option=com_bookingadmin&view=winterbooking&bookingref=' . $row->bookingref );
		$form .= "<tr><td>";
		$form .= "<a href=\"".$link."\">".$row->bookingref."</a>";
		$form .= "</td></tr>";
	endforeach;
	$form .= "<tbody>";
	$form .= "</table>";
	echo $form;
?>

<?php else:
	echo "No past bookings";?>
<?php endif; ?>