<?php
/**
 * ------------------------------------------------------------------------
 * JA Extension Manager Component
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2018 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

use Joomla\CMS\Language\Text;

$item = $this->item;
$itemId = $item->get('id');
$ws_uri = $item->get('ws_uri');
$ws_core = $item->get('ws_core');
$ws_mode = $item->get('ws_mode');
$ws_name = $item->get('ws_name');
$ws_user = $item->get('ws_user');
$ws_default = $item->get('ws_default');

?>
<form name="adminForm" id="service_info" action="index.php" method="post">
  <input type="hidden" name="option" value="com_jaextmanager" />
  <input type="hidden" name="view" value="services" />
  <input type="hidden" name="task" value="saveIFrame" />
  <input type="hidden" name="tmpl" value="component" />
  <input type="hidden" name='id' id='id' value="<?php echo $itemId; ?>">
  <input type="hidden" name='cid[]' id='cid[]' value="<?php echo $itemId; ?>">
  <input type="hidden" name="number" value="<?php echo $this->number; ?>">
  
  <input type="hidden" id="ws_core" name="ws_core" value="<?php echo $ws_core; ?>" />
  <input type="hidden" id="ws_default" name="ws_default" value="<?php echo $ws_default; ?>" />
  <input type="hidden" id="ws_mode" name="ws_mode" value="<?php echo $ws_mode; ?>" />
    <fieldset>
        <legend> <?php echo Text::_('SERVICES_INFORMATION' ); ?> </legend>
        <table class="admintable" width="100%">
          <tr>
            <td width="30%" class="key" align="right" valign="top"><?php echo Text::_('SERVICE_NAME' ); ?>: <span class="required">*</span></td>
            <td width="70%">
      			<input type="text" id="ws_name" name="ws_name" size='50' value="<?php echo $ws_name; ?>" />            </td>
          </tr>
  		  <?php if($ws_mode != 'local'): ?>
          <tr>
            <td class="key" align="right" valign="top"><?php echo Text::_('SERVICE_URL' ); ?>: <span class="required">*</span></td>
            <td>
      			<input type="text" id="ws_uri" name="ws_uri" size='50' value="<?php echo $ws_uri; ?>" />            </td>
          </tr>
          <?php endif; ?>
    	</table>
  </fieldset>
  <?php if($ws_mode != 'local'): ?>
  <fieldset>
        <legend> <?php echo Text::_('AUTHENTICATION' ); ?> </legend>
        <table class="admintable" width="100%">
          <tr>
            <td colspan="2"><?php echo Text::_('LEAVE_BLANK_IF_THIS_SERVICE_DO_NOT_REQUIRE_AUTHENTICATION'); ?></td>
          </tr>
          <tr>
            <td width="30%"  class="key" align="right" valign="top"><?php echo Text::_('USERNAME' ); ?>: </td>
            <td width="70%">
      			<input type="text" id="ws_user" name="ws_user" size='30' value="<?php echo $ws_user; ?>" />            </td>
          </tr>
          <tr>
            <td class="key" align="right" valign="top"><?php echo Text::_('PASSWORD' ); ?>: </td>
            <td>
      			<input type="password" id="ws_pass" name="ws_pass" size='30' value="" />
                <?php if($itemId != 0): ?>
                <label for="ws_pass"><small><?php echo Text::_('LEAVE_BLANK_IF_NO_REQUIRE_CHANGE' ); ?></small></label>
                <?php endif; ?>            
            </td>
          </tr>
    	</table>
  </fieldset>
  <?php endif; ?>
</form>