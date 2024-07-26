<?php
/**
 * @desc Modify from component Media Manager of Joomla
 *
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Path;
use Joomla\Filesystem\Folder;
use Joomla\CMS\Client\ClientHelper;

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Weblinks Weblink Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class JaextmanagerControllerFile extends JaextmanagerController
{


	/**
	 * Upload a file
	 *
	 * @since 1.5
	 */
	function upload()
	{
		// Initialise variables.
		$mainframe = Factory::getApplication('administrator');
		
		// Check for request forgeries
		JRequest::checkToken('request') or jexit('Invalid Token');
		
		$file = JRequest::getVar('Filedata', '', 'files', 'array');
		$folder = JRequest::getVar('folder', '', '', 'path');
		$format = JRequest::getVar('format', 'html', '', 'cmd');
		$return = JRequest::getVar('return-url', null, 'post', 'base64');
		$err = null;
		
		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		ClientHelper::setCredentialsFromRequest('ftp');
		
		// Make the filename safe
		jimport('joomla.filesystem.file');
		$file['name'] = File::makeSafe($file['name']);
		$app = Factory::getApplication();
		
		if (isset($file['name'])) {
			$filepath = Path::clean(JA_WORKING_DATA_FOLDER .'/'. $folder .'/'. strtolower($file['name']));
			
			if (!RepoHelper::canUpload($file, $err)) {
				if ($format == 'json') {
					jimport('joomla.error.log');
					$log = JLog::getInstance('upload.error.php');
					$log->addEntry(array('comment' => 'Invalid: ' . $filepath . ': ' . $err));
					header('HTTP/1.0 415 Unsupported Media Type');
					jexit('Error. Unsupported Media Type!');
				} else {
					$app->enqueueMessage(Text::_($err), 'notice');
					// REDIRECT
					if ($return) {
						$mainframe->redirect(base64_decode($return) . '&folder=' . $folder);
					}
					return;
				}
			}
			
			if (is_file($filepath)) {
				if ($format == 'json') {
					jimport('joomla.error.log');
					$log = JLog::getInstance('upload.error.php');
					$log->addEntry(array('comment' => 'File already exists: ' . $filepath));
					header('HTTP/1.0 409 Conflict');
					jexit('Error. File already exists');
				} else {
					$app->enqueueMessage(Text::_('ERROR_FILE_ALREADY_EXISTS'), 'notice');
					// REDIRECT
					if ($return) {
						$mainframe->redirect(base64_decode($return) . '&folder=' . $folder);
					}
					return;
				}
			}
			
			if (!File::upload($file['tmp_name'], $filepath)) {
				if ($format == 'json') {
					jimport('joomla.error.log');
					$log = JLog::getInstance('upload.error.php');
					$log->addEntry(array('comment' => 'Cannot upload: ' . $filepath));
					header('HTTP/1.0 400 Bad Request');
					jexit('Error. Unable to upload file');
				} else {
					$app->enqueueMessage(Text::_('ERROR_UNABLE_TO_UPLOAD_FILE'), 'warning');
					// REDIRECT
					if ($return) {
						$mainframe->redirect(base64_decode($return) . '&folder=' . $folder);
					}
					return;
				}
			} else {
				if ($format == 'json') {
					jimport('joomla.error.log');
					$log = JLog::getInstance();
					$log->addEntry(array('comment' => $folder));
					jexit('Upload complete');
				} else {
					$mainframe->enqueueMessage(Text::_('UPLOAD_COMPLETE'));
					// REDIRECT
					if ($return) {
						$mainframe->redirect(base64_decode($return) . '&folder=' . $folder);
					}
					return;
				}
			}
		} else {
			$mainframe->redirect('index.php', 'Invalid Request', 'error');
		}
	}


	/**
	 * Deletes paths from the current path
	 *
	 * @param string $listFolder The image directory to delete a file from
	 * @since 1.5
	 */
	function delete()
	{
		$mainframe = Factory::getApplication('administrator');
		
		JRequest::checkToken('request') or jexit('Invalid Token');
		
		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		ClientHelper::setCredentialsFromRequest('ftp');
		
		// Get some data from the request
		$tmpl = JRequest::getCmd('tmpl');
		$paths = JRequest::getVar('rm', array(), '', 'array');
		$folder = JRequest::getVar('folder', '', '', 'path');
		
		// Initialize variables
		$msg = array();
		$ret = true;
		$app = Factory::getApplication();
		
		if (count($paths)) {
			foreach ($paths as $path) {
				if ($path !== File::makeSafe($path)) {
					$app->enqueueMessage(Text::_('UNABLE_TO_DELETE') . htmlspecialchars($path, ENT_COMPAT, 'UTF-8') . ' ' . Text::_('WARNFILENAME'), 'warning');
					continue;
				}
				
				$fullPath = Path::clean(JA_WORKING_DATA_FOLDER .'/'. $folder .'/'. $path);
				if (is_file($fullPath)) {
					$ret |= !File::delete($fullPath);
				} else if (is_dir($fullPath)) {
					$files = Folder::files($fullPath, '.', true);
					$canDelete = true;
					foreach ($files as $file) {
						if ($file != 'index.html') {
							$canDelete = false;
						}
					}
					if ($canDelete) {
						$ret |= !Folder::delete($fullPath);
					} else {
						//allow remove folder not empty on local repository
						$ret2 = Folder::delete($fullPath);
						$ret |= !$ret2;
						if ($ret2 == false) {
							$app->enqueueMessage(Text::_('UNABLE_TO_DELETE') . $fullPath, 'warning');
						}
					}
				}
			}
		}
		if ($ret) {
			$app->enqueueMessage(Text::_('SUCCESSFULLY_DELETE_A_SELETED_ITEMS'));
		}
		if ($tmpl == 'component') {
			// We are inside the iframe
			$mainframe->redirect('index.php?option=com_jaextmanager&view=repolist&folder=' . $folder . '&tmpl=component');
		} else {
			$mainframe->redirect('index.php?option=com_jaextmanager&view=repolist&folder=' . $folder);
		}
	}


	function download()
	{
		$mainframe = Factory::getApplication('administrator');
		
		JRequest::checkToken('request') or jexit('Invalid Token');
		
		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		ClientHelper::setCredentialsFromRequest('ftp');
		
		// Get some data from the request
		$tmpl = JRequest::getCmd('tmpl');
		$paths = JRequest::getVar('rm', array(), '', 'array');
		$folder = JRequest::getVar('folder', '', '', 'path');
		
		// Initialize variables
		$msg = array();
		$ret = true;
		
		if (count($paths)) {
			foreach ($paths as $path) {
				$fullPath = Path::clean(JA_WORKING_DATA_FOLDER .'/'. $folder .'/'. $path);
				if (is_file($fullPath) && File::getExt($fullPath) == 'zip') {
					// Set headers
					header("Cache-Control: public");
					header("Content-Description: File Transfer");
					header("Content-Disposition: attachment; filename=$fullPath");
					header("Content-Type: application/zip");
					header("Content-Transfer-Encoding: binary");
					// Read the file from disk
					readfile($fullPath);
					exit();
				}
			}
		}
		if ($tmpl == 'component') {
			// We are inside the iframe
			$mainframe->redirect('index.php?option=com_jaextmanager&view=repolist&folder=' . $folder . '&tmpl=component');
		} else {
			$mainframe->redirect('index.php?option=com_jaextmanager&view=repolist&folder=' . $folder);
		}
	}
}
