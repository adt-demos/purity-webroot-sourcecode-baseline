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
 * @subpackage	Media
 * @since 1.5
 */
class JaextmanagerControllerFolder extends JaextmanagerController
{


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
					$app->enqueueMessage(Text::_('UNABLE_TO_DELETE') . htmlspecialchars($path, ENT_COMPAT, 'UTF-8') . ' ' . Text::_('WARNDIRNAME'), 'warning');
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


	/**
	 * Create a folder
	 *
	 * @param string $path Path of the folder to create
	 * @since 1.5
	 */
	function create()
	{
		$mainframe = Factory::getApplication('administrator');
		
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		ClientHelper::setCredentialsFromRequest('ftp');
		
		$folder = JRequest::getCmd('foldername', '');
		$folderCheck = JRequest::getVar('foldername', null, '', 'string', JREQUEST_ALLOWRAW);
		$parent = JRequest::getVar('folderbase', '', '', 'path');
		
		JRequest::setVar('folder', $parent);
		
		if (($folderCheck !== null) && ($folder !== $folderCheck)) {
			$mainframe->redirect('index.php?option=com_jaextmanager&view=repolist&folder=' . $parent, Text::_('WARNDIRNAME'));
		}
		
		if (strlen($folder) > 0) {
			$path = Path::clean(JA_WORKING_DATA_FOLDER .'/'. $parent .'/'. $folder);
			if (!is_dir($path) && !is_file($path)) {
				jimport('joomla.filesystem.*');
				Folder::create($path);
				$content = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
				File::write($path ."/index.html", $content);
			}
			JRequest::setVar('folder', ($parent) ? $parent . '/' . $folder : $folder);
		}
		$mainframe->redirect('index.php?option=com_jaextmanager&view=repolist&folder=' . $parent);
	}
}
