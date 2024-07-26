<?php
/**
 * ------------------------------------------------------------------------
 * JA Multilingual J2x-J3x.
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2016 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

defined('_JEXEC') or die;
use Joomla\CMS\Object\CMSObject;
use Joomla\Filesystem\Folder;
use Joomla\CMS\Factory;
use Joomla\Filesystem\File;

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class JaExtUpdatehelper extends CMSObject
{
	public static $extension = 'com_jaextmanager';

	public static function isJoomla3x() {
		return version_compare(JVERSION, '3.0', 'ge');
	}

	public static function isJoomla32() {
		return version_compare(JVERSION, '3.2', 'ge');
	}

	static public function isInstalled($extension)
	{
		$db = Factory::getDbo();
		$db->setQuery("SELECT ".$db->quoteName('extension_id')." FROM #__extensions WHERE ".$db->quoteName('type')." = 'component' AND ".$db->quoteName('element')." = ".$db->quote($extension));
		$id = $db->loadResult();
		return $id;
	}

	public function update() {
		$path = JPATH_COMPONENT_ADMINISTRATOR . '/installer/sql/';
		if(!is_dir($path)) {
			Folder::create($path, 0755);
		}
		$versions = array('100');
		foreach($versions as $version) {
			$file = $path.'upgrade_v'.$version.'.log';
			if(!is_file($file)) {
				$func = 'updateVersion'.$version;
				if(method_exists($this, $func)) {
					$result = call_user_func_array(array($this, $func), array());
					
					//processing code here
					$dbfile = $path.'upgrade_v'.$version.'.sql';
					$this->parseSQLFile($dbfile);
					
					$log = 'Updated on: '.date('Y-m-d H:i:s');
					File::write($file, $log);
				}
			}
		}
	}
	
	protected function parseSQLFile($file) {
		try {
			if(is_file($file)) {
				$buffer = file_get_contents($file);
				if($buffer) {
					$db = Factory::getDbo();
					$queries = $db->splitSql($buffer);
					foreach ($queries as $query) {
						$query = trim($query);
						if(empty($query)) continue;

						$db->setQuery($query);
						@$db->execute();
					}
				}
			}
		} catch(Exception $e) {
			//echo $e->getMessage();
		}
	}
	
	protected function updateVersion100() {
		return true;
	}
}
