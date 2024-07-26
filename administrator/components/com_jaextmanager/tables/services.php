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
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

class TableServices extends Table
{
	/** @var int */
	public $id = 0;
	/** @var string */
	public $ws_name = '';
	/** @var string - setting for all new services are remote*/
	public $ws_mode = 'remote';
	/** @var string */
	public $ws_uri = '';
	/** @var string */
	public $ws_user = '';
	/** @var string */
	public $ws_pass = '';
	/** @var string */
	//var $params='';
	/** @var tinyint */
	public $ws_default = 0;
	/** @var tinyint */
	public $ws_core = 0;


	function __construct(&$db)
	{
		parent::__construct('#__jaem_services', 'id', $db);
	}


	function bind($array, $ignore = '')
	{
		if (key_exists('params', $array) && is_array($array['params'])) {
			$registry = new Registry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}
		return parent::bind($array, $ignore);
	}


	function check()
	{
		$error = array();
		/** check error data */
		if ($this->ws_name == '')
			$error[] = Text::_("PLEASE_ENTER_SERVICE_NAME");
		if ($this->ws_mode == '')
			$error[] = Text::_("PLEASE_SELECT_SERVICE_MODE");
		if (!isset($this->id))
			$error[] = Text::_("ID_MUST_NOT_BE_NULL");
		elseif (!is_numeric($this->id))
			$error[] = Text::_("ID_MUST_BE_NUMBER");
		
		return $error;
	}
}
?>
