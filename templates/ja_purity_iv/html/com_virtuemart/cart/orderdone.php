<?php
defined('_JEXEC') or die('');

/**
*
* Template for the shopping cart
*
* @package	VirtueMart
* @subpackage Cart
* @author Max Milbers
*
* @link https://virtuemart.net
* @copyright Copyright (c) 2004 - 2018 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
?>
<div class="vm-wrap vm-order-done mb-4">
	<div class="alert alert-success border-0 p-3" role="alert">
	<?php
	if (vRequest::getBool('display_title',true)) {
	?>
		<h3 class="mt-0 mb-2"><?php echo vmText::_('COM_VIRTUEMART_CART_ORDERDONE_THANK_YOU'); ?></h3>
	<?php
	}
	echo $this->html;
	?>
	</div>
</div>

<?php
	if (vRequest::getBool('display_loginform',true)) {
		$cuser = JFactory::getUser();
		if (!$cuser->guest) echo shopFunctionsF::getLoginForm();
	}
?>

