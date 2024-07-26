<?php
/**
 * @version		$Id: view.html.php 17858 2010-06-23 17:54:28Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die();

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Client\ClientHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Component\ComponentHelper;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Media component
 *
 * @package		Joomla.Administrator
 * @subpackage	com_media
 * @since 1.0
 */
class JaextmanagerViewRepo extends JAEMView
{

	public $folders;
	public $folders_id;

	function display($tpl = null)
	{
		// Initialise variables.
		$app = Factory::getApplication();
		
		$config = ComponentHelper::getParams(JACOMPONENT);
		
		$lang	= Factory::getLanguage();
		//$style = $app->getUserStateFromRequest('media.list.layout', 'layout', 'details', 'word');
		$style = "details";

		if (version_compare(JVERSION, '4', '<')) {
			HTMLHelper::_('behavior.framework', true);
			HTMLHelper::_('script', 'system/mootree.js');
			HTMLHelper::_('stylesheet', 'system/mootree.css', array(), true);
		}

		$assets = Uri::root() . 'administrator/components/com_jaextmanager/assets/';
		$document = Factory::getDocument();
		if (jaIsJoomla4x()) {
			$document->setBuffer($this->loadTemplate('navigation'), 'modules', 'top');
			HTMLHelper::_('stylesheet', $assets . 'repo_manager_3/' . 'repomanager.css');
		} else if(jaIsJoomla3x()){
			$document->setBuffer($this->loadTemplate('navigation'), 'modules', 'top');
			HTMLHelper::_('script', $assets . 'repo_manager_3/' . 'repomanager.js');
			HTMLHelper::_('stylesheet', $assets . 'repo_manager_3/' . 'repomanager.css');
		}else{
			$document->setBuffer($this->loadTemplate('navigation'), 'modules', 'submenu');
			HTMLHelper::_('script', $assets . 'repo_manager/' . 'repomanager.js');
			HTMLHelper::_('stylesheet', $assets . 'repo_manager/' . 'repomanager.css');
		}
		
		
		if ($lang->isRTL()) :
			HTMLHelper::_('stylesheet', 'media/mootree_rtl.css', array(), true);
		endif;
		if ($config->get('enable_flash', 0)) {
			HTMLHelper::_('behavior.uploader', 'file-upload', array('onAllComplete' => 'function(){ MediaManager.refreshFrame(); }'));
		}
		
		if (DS == '\\') {
			$base = str_replace(DS, "\\\\", JA_WORKING_DATA_FOLDER);
		} else {
			$base = JA_WORKING_DATA_FOLDER;
		}
		
		$js = "
			var basepath = '" . $base . "';
			var viewstyle = '" . $style . "';
		";
		$document->addScriptDeclaration($js);
		
		/*
		 * Display form for FTP credentials?
		 * Don't set them here, as there are other functions called before this one if there is any file write operation
		 */
		jimport('joomla.client.helper');
		$ftp = !ClientHelper::hasCredentials('ftp');
		$session 	= Factory::getSession();
		$state 		= $this->get('state');
		$folderTree = $this->get('folderTree');
		$this->assignRef('session', $session);
		$this->assignRef('config', $config);
		$this->assignRef('state', $state);
		$this->assign('require_ftp', $ftp);
		$this->assign('folders_id', ' id="media-tree"');
		$this->assign('folders', $folderTree);
		
		// Set the toolbar
		$this->addToolbar();
		
		parent::display($tpl);
	}


	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		// Get the toolbar object instance
		$bar = ToolBar::getInstance('toolbar');
		
		// Set the titlebar text
		// ToolBarHelper::title(Text::_('JOOMLART_EXTENSIONS_MANAGER'), 'generic');
		
		if(jaIsJoomla3x()) {
			// Add a upload button
			$title = Text::_('UPLOAD');
			$dhtml = "<button href=\"#\" onclick=\"jaOpenUploader(); return false;\" class=\"toolbar btn btn-small btn-success\">
						<i class=\"icon-plus icon-white\" title=\"$title\"></i>
						$title</button>";
			
			$bar->appendButton('Custom', $dhtml, 'upload');
			
			// Add a delete button
			$title = Text::_('DELETE');
			$dhtml = "<button href=\"#\" onclick=\"multiDelete(); return false;\" class=\"toolbar btn btn-small\">
						<i class=\"icon-remove\" title=\"$title\"></i>
						$title</button>";
			$bar->appendButton('Custom', $dhtml, 'delete');
		} else {
			// Add a upload button
			$title = Text::_('UPLOAD');
			$dhtml = "<a href=\"#\" onclick=\"jaOpenUploader(); return false;\" class=\"toolbar btn btn-small btn-success\">
						<span class=\"icon-32-upload\" title=\"$title\" type=\"Custom\"></span>
						$title</a>";
			
			$bar->appendButton('Custom', $dhtml, 'upload');
			
			// Add a delete button
			$title = Text::_('DELETE');
			$dhtml = "<a href=\"#\" onclick=\"multiDelete(); return false;\" class=\"toolbar\">
						<span class=\"icon-32-delete\" title=\"$title\" type=\"Custom\"></span>
						$title</a>";
			$bar->appendButton('Custom', $dhtml, 'delete');
		}
	}


	function getFolderLevel($folder)
	{
		$txt = null;
		if (isset($folder['children']) && count($folder['children'])) {
			$tmp = $this->folders;
			$this->folders = $folder;
			if(jaIsJoomla3x()) {
				$txt = $this->loadTemplate('folders30');
			} else {
				$txt = $this->loadTemplate('folders');
			}
			
			$this->folders = $tmp;
		}
		return $txt;
	}
}
