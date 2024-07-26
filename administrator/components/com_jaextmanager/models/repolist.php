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
use Joomla\CMS\Object\CMSObject;
use Joomla\Filesystem\Folder;

jimport('joomla.application.component.model');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

/**
 * Media Component List Model
 *
 * @package		Joomla
 * @subpackage	Media
 * @since 1.5
 */
class JaextmanagerModelRepolist extends JAEMModel
{


	function getState($property = null,$default = NULL)
	{
		static $set;
		if (!$set) {
			$folder = JRequest::getVar('folder', '', '', 'none');
			$this->setState('folder', $folder);
			
			$parent = str_replace("\\", "/", dirname($folder));
			$parent = ($parent == '.') ? null : $parent;
			$this->setState('parent', $parent);
			$set = true;
		}
		return parent::getState($property);
	}


	function getImages()
	{
		$list = $this->getList();
		return $list['images'];
	}


	function getFolders()
	{
		$list = $this->getList();
		return $list['folders'];
	}


	function getDocuments()
	{
		$list = $this->getList();
		return $list['docs'];
	}


	/**
	 * Build imagelist
	 *
	 * @param string $listFolder The image directory to display
	 * @since 1.5
	 */
	function getList()
	{
		static $list;
		$RepoHelper = new RepoHelper();
		// Only process the list once per request
		if (is_array($list)) {
			return $list;
		}
		
		// Get current path from request
		$current = $this->getState('folder');
		
		// If undefined, set to empty
		if ($current == 'undefined') {
			$current = '';
		}
		
		// Initialize variables
		if (strlen($current) > 0) {
			$basePath = JA_WORKING_DATA_FOLDER.'/'.$current;
		} else {
			$basePath = JA_WORKING_DATA_FOLDER;
		}
		$basePath = Path::clean($basePath.'/');
		$mediaBase = str_replace(DS, '/', JA_WORKING_DATA_FOLDER);
		
		$images = array();
		$folders = array();
		$docs = array();
		
		if (is_dir($basePath)) {
			// Get the list of files and folders from the given folder
			$fileList = Folder::files($basePath);
			$folderList = Folder::folders($basePath);
			
			$iconPath = JPATH_ADMINISTRATOR."/components/com_jaextmanager/assets/images/icons/";
			// Iterate over the files if they exist
			if ($fileList !== false) {
				foreach ($fileList as $file) {
					if (is_file($basePath.'/'.$file) && substr($file, 0, 1) != '.' && strtolower($file) !== 'index.html') {
						$tmp = new CMSObject();
						$tmp->name = $file;
						$tmp->path = str_replace(DS, '/', Path::clean($basePath.'/'.$file));
						$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
						$tmp->size = filesize($tmp->path);
						
						$ext = strtolower(File::getExt($file));
						$tmp->ext = $ext;
						switch ($ext) {
							// Image
							case 'jpg':
							case 'png':
							case 'gif':
							case 'xcf':
							case 'odg':
							case 'bmp':
							case 'jpeg':
								$info = @getimagesize($tmp->path);
								$tmp->width = @$info[0];
								$tmp->height = @$info[1];
								$tmp->type = @$info[2];
								$tmp->mime = @$info['mime'];
								
								$filesize = $RepoHelper->parseSize($tmp->size);
								
								if (($info[0] > 60) || ($info[1] > 60)) {
									$dimensions = $RepoHelper->imageResize($info[0], $info[1], 60);
									$tmp->width_60 = $dimensions[0];
									$tmp->height_60 = $dimensions[1];
								} else {
									$tmp->width_60 = $tmp->width;
									$tmp->height_60 = $tmp->height;
								}
								
								if (($info[0] > 16) || ($info[1] > 16)) {
									$dimensions = $RepoHelper->imageResize($info[0], $info[1], 16);
									$tmp->width_16 = $dimensions[0];
									$tmp->height_16 = $dimensions[1];
								} else {
									$tmp->width_16 = $tmp->width;
									$tmp->height_16 = $tmp->height;
								}
								$iconfile_32 = $iconPath . "mime-icon-32/".$ext . ".png";
								if (file_exists($iconfile_32)) {
									$tmp->icon_32 = "components/com_jaextmanager/assets/images/icons/mime-icon-32/" . $ext . ".png";
								} else {
									$tmp->icon_32 = "components/com_jaextmanager/assets/images/icons/con_info.png";
								}
								$iconfile_16 = $iconPath . "mime-icon-16/".$ext . ".png";
								if (file_exists($iconfile_16)) {
									$tmp->icon_16 = "components/com_jaextmanager/assets/images/icons/mime-icon-16/" . $ext . ".png";
								} else {
									$tmp->icon_16 = "components/com_jaextmanager/assets/images/icons/con_info.png";
								}
								$images[] = $tmp;
								break;
							// Non-image document
							default:
								$iconfile_32 = $iconPath . "mime-icon-32/".$ext . ".png";
								if (file_exists($iconfile_32)) {
									$tmp->icon_32 = "components/com_jaextmanager/assets/images/icons/mime-icon-32/" . $ext . ".png";
								} else {
									$tmp->icon_32 = "components/com_jaextmanager/assets/images/icons/con_info.png";
								}
								$iconfile_16 = $iconPath."/mime-icon-16/".$ext . ".png";
								if (file_exists($iconfile_16)) {
									$tmp->icon_16 = "components/com_jaextmanager/assets/images/icons/mime-icon-16/" . $ext . ".png";
								} else {
									$tmp->icon_16 = "components/com_jaextmanager/assets/images/icons/con_info.png";
								}
								$docs[] = $tmp;
								break;
						}
					}
				}
			}
			
			// Iterate over the folders if they exist
			if ($folderList !== false) {
				foreach ($folderList as $folder) {
					$tmp = new CMSObject();
					$tmp->name = basename($folder);
					$tmp->path = str_replace(DS, '/', Path::clean($basePath.'/'.$folder));
					$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
					$count = $RepoHelper->countFiles($tmp->path);
					$tmp->files = $count[0];
					$tmp->folders = $count[1];
					
					$folders[] = $tmp;
				}
			}
		} else {
			$app = Factory::getApplication();
			$app->enqueueMessage(Text::_("PATH_IS_NOT_A_FOLDER_OR_THIS_FOLDER_WAS_DELETED"), 'error');
		}
		
		$list = array('folders' => $folders, 'docs' => $docs, 'images' => $images);
		
		return $list;
	}
}