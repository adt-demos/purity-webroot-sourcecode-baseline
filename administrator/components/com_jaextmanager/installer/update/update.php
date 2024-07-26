<?php
use Joomla\Filesystem\File;
use Joomla\Filesystem\Path;

if(is_file(JPATH_COMPONENT."/installer/update/2.5.3/jaextmanager.xml") && is_file(JPATH_COMPONENT."/com_jaextmanager.xml")){ 
	$oldxmlfile = Path::clean(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'com_jaextmanager.xml');
	$newxmlfile =  JPATH_COMPONENT.DIRECTORY_SEPARATOR.'installer'.DIRECTORY_SEPARATOR.'update'.DIRECTORY_SEPARATOR.'2.5.3'.DIRECTORY_SEPARATOR.'jaextmanager.xml';
	
	$newxmlfilecontent = File::read($newxmlfile);
	File::write($oldxmlfile, $newxmlfilecontent);
	rename($oldxmlfile, str_replace('com_jaextmanager.xml', 'jaextmanager.xml', $oldxmlfile));
	File::delete(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'/installer/update/update.php');
}
?>