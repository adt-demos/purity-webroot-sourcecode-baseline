<?php
/**
 * @version		$Id: default_navigation.php 18340 2010-08-06 06:48:12Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	com_media
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$app	= Factory::getApplication();
//$style = $app->getUserStateFromRequest('media.list.layout', 'layout', 'details', 'word');
$style = "details";
?>
<div id="submenu-box">
	<div class="t">
		<div class="t">
			<div class="t"></div>
		</div>
	</div>
	<div class="m">
		<div class="submenu-box">
			<div class="submenu-pad">
				<ul id="submenu" class="media">
					<li><a title="" href="index.php?option=com_jaextmanager&extionsion_type=&search="> <?php echo Text::_("EXTENSIONS_MANAGER"); ?></a></li>
					<li><a title="" href="index.php?option=com_jaextmanager&view=services"> <?php echo Text::_("SERVICES_MANAGER"); ?></a></li>
					<li><a title="" class="active" href="index.php?option=com_jaextmanager&view=repo"> <?php echo Text::_("REPOSITORY_MANAGER"); ?></a></li>
					<li><a title="" href="index.php?option=com_jaextmanager&view=default&layout=config_service"> <?php echo Text::_("CONFIGURATIONS"); ?></a></li>
					<li><a title="" href="index.php?option=com_jaextmanager&view=default&layout=help_support"> <?php echo Text::_("HELP_AND_SUPPORT"); ?></a></li>
				</ul>
				<div class="clr"></div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>