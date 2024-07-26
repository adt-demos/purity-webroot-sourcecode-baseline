<?php
/**
 * @version		$Id: install.php 18650 2010-08-26 13:28:49Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\Path;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
use Joomla\CMS\Installer\InstallerHelper;

// Import library dependencies


jimport('joomla.application.component.model');
jimport('joomla.installer.installer');
jimport('joomla.installer.helper');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
/**
 * @desc modify from "Extension Manager Install Model" of "Installer Component"
 */

#[AllowDynamicProperties]
class JaextmanagerModelUploader extends JAEMModel
{
	/** @var object JTable object */
	var $_table = null;
	
	/** @var object JTable object */
	var $_url = null;


	/**
	 * Overridden constructor
	 * @access	protected
	 */
	function __construct()
	{
		parent::__construct();
	
	}


	function upload()
	{
		// Initialise variables.
		$app = Factory::getApplication('administrator');
		
		$this->setState('action', 'upload');
		
		switch (JRequest::getWord('installtype')) {
			case 'folder':
				$package = $this->_getPackageFromFolder();
				break;
			
			case 'upload':
				$package = $this->_getPackageFromUpload();
				break;
			
			case 'url':
				$package = $this->_getPackageFromUrl();
				break;
			
			default:
				$app->enqueueMessage(Text::_('NO_UPLOAD_TYPE_FOUND'), 'warning');
				return false;
				break;
		}
		
		// Was the package unpacked?
		if (!$package) {
			$app->enqueueMessage(Text::_('UNABLE_TO_FIND_INSTALL_PACKAGE'), 'warning');
			return false;
		}
		
		// Get an ja extension uploader instance
		$uploader = jaExtUploader::getInstance();
		$result = $uploader->upload($package['dir']);
		if (!$result) {
			// There was an error uploading the package
			$msg = Text::sprintf('THERE_WAS_AN_ERROR_UPLOADING_THE_PACKAGE_S', $package['type']);
			$app->enqueueMessage($msg, 'notice');
		} else {
			// Package uploaded sucessfully
			$msg = Text::sprintf('COM_INSTALLER_INSTALL_SUCCESS', $package['type']);
		}
		
		// Cleanup the install files
		if (!is_file($package['packagefile'])) {
			$config = Factory::getConfig();
			$package['packagefile'] = $config->get('tmp_path').'/'.$package['packagefile'];
		}
		
		InstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);
		
		return $result;
	}


	/**
	 * Works out an installation package from a HTTP upload
	 *
	 * @return package definition or false on failure
	 */
	protected function _getPackageFromUpload()
	{
		// Get the uploaded file information
		$userfile = JRequest::getVar('install_package', null, 'files', 'array');
		$app = Factory::getApplication();
		echo '<pre>';print_r($userfile);echo '</pre>';die('pr debug!');
		
		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads')) {
			$app->enqueueMessage(Text::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLFILE'), 'warning');
			return false;
		}
		
		// Make sure that zlib is loaded so that the package can be unpacked
		if (!extension_loaded('zlib')) {
			$app->enqueueMessage(Text::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLZLIB'), 'warning');
			return false;
		}
		
		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile)) {
			$app->enqueueMessage(Text::_('COM_INSTALLER_MSG_INSTALL_NO_FILE_SELECTED'), 'notice');
			return false;
		}
		
		// Check if there was a problem uploading the file.
		/* if ($userfile['error'] || $userfile['size'] < 1) {
			throw new Exception(Text::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLUPLOADERROR'), 500);
		} */
		
		// Build the appropriate paths
		$config = Factory::getConfig();
		$tmp_dest = $config->get('tmp_path').'/'.$userfile['name'];
		$tmp_src = $userfile['tmp_name'];
		
		// Move uploaded file
		jimport('joomla.filesystem.file');
		$uploaded = File::upload($tmp_src, $tmp_dest,false,true);
		
		// Unpack the downloaded package file
		$package = InstallerHelper::unpack($tmp_dest);
		
		return $package;
	}


	/**
	 * Install an extension from a directory
	 *
	 * @return	Package details or false on failure
	 * @since	1.5
	 */
	protected function _getPackageFromFolder()
	{
		// Get the path to the package to install
		$p_dir = JRequest::getString('install_directory');
		$p_dir = Path::clean($p_dir);
		$app = Factory::getApplication();
		
		// Did you give us a valid directory?
		if (!is_dir($p_dir)) {
			$app->enqueueMessage(Text::_('COM_INSTALLER_MSG_INSTALL_PLEASE_ENTER_A_PACKAGE_DIRECTORY'), 'warning');
			return false;
		}
		
		// Detect the package type
		$type = InstallerHelper::detectType($p_dir);
		
		// Did you give us a valid package?
		if (!$type) {
			$app->enqueueMessage(Text::_('COM_INSTALLER_MSG_INSTALL_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE'), 'warning');
			return false;
		}
		
		$package['packagefile'] = null;
		$package['extractdir'] = null;
		$package['dir'] = $p_dir;
		$package['type'] = $type;
		
		return $package;
	}


	/**
	 * Install an extension from a URL
	 *
	 * @return	Package details or false on failure
	 * @since	1.5
	 */
	protected function _getPackageFromUrl()
	{
		// Get a database connector
		$db = Factory::getDbo();
		
		// Get the URL of the package to install
		$url = JRequest::getString('install_url');
		$app = Factory::getApplication();
		
		// Did you give us a URL?
		if (!$url) {
			$app->enqueueMessage(Text::_('COM_INSTALLER_MSG_INSTALL_ENTER_A_URL'), 'warning');
			return false;
		}
		
		// Download the package at the URL given
		$p_file = InstallerHelper::downloadPackage($url);
		
		// Was the package downloaded?
		if (!$p_file) {
			$app->enqueueMessage(Text::_('COM_INSTALLER_MSG_INSTALL_INVALID_URL'), 'warning');
			return false;
		}
		
		$config = Factory::getConfig();
		$tmp_dest = $config->get('tmp_path');
		
		// Unpack the downloaded package file
		$package = InstallerHelper::unpack($tmp_dest.'/'.$p_file);
		
		return $package;
	}
}