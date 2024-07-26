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

defined('JPATH_BASE') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\ToolbarHelper;

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');
jimport('joomla.filesystem.path');

class JaextmanagerControllerServices extends JaextmanagerController
{

	function __construct($default = array())
	{
		parent::__construct($default);
		
		$task = $this->input->get('task', '');
		switch ($task) {
			case 'add':
			case 'save':
			case 'apply':
			case 'edit':
				ToolBarHelper::apply();
				ToolBarHelper::save();
				ToolBarHelper::cancel();
				break;
			default:
				ToolBarHelper::makeDefault('publish', 'Save Service');
				break;
		}
		// Register Extra tasks
		$this->input->set('view', 'services');
		$this->registerTask('add', 'edit');
		$this->registerTask('apply', 'save');
		$this->registerTask('publish', 'setDefault');
	}


	function display($cachable = false, $urlparams = false)
	{	
		$user = Factory::getUser();
		$task = $this->getTask();
		switch ($task) {
			case 'edit':
				$this->input->set('layout', 'form');
				break;
			case 'config':
				$this->input->set('layout', 'config');
				break;
		}
		if ($user->id == 0) {
			$app = Factory::getApplication();
			$app->enqueueMessage(Text::_("YOU_MUST_BE_SIGNED_IN"), 'warning');
			$this->setRedirect(Route::_("index.php?option=com_user&view=login"));
			
			return;
		}
		
		parent::display();
	}


	function cancel()
	{
		$this->setRedirect('index.php?option=com_jaextmanager&view=services');
		
		return TRUE;
	}


	/**
	 * Save service settings
	 *
	 * @param array $errors
	 * @return mixed - return false if there is error, otherwise return service object
	 */
	function save(&$errors = array())
	{
		$task = $this->getTask();
		
		$model = $this->getModel('services');
		$post = JRequest::get('post');
		
		$post['ws_name'] = JRequest::getString('ws_name', '');
		$post['ws_mode'] = JRequest::getString('ws_mode', 'remote');
		$post['ws_uri'] = JRequest::getString('ws_uri', '');
		$post['ws_user'] = JRequest::getString('ws_user', '');
		$post['ws_pass'] = JRequest::getString('ws_pass', '');
		$post['ws_default'] = JRequest::getInt('ws_default');
		
		$model->setState('request', $post);
		$row = $model->store();
		$rowId = $row->get('id');

		if (!isset($rowId)) {
			$errors[] = $row;
			return FALSE;
		
		}
		return $row;
	}


	/**
	 * save service settings and return data  to browser as ajax response text.
	 *
	 */
	function saveIFrame()
	{
		$input = Factory::getApplication()->input;
		$errors = array();
		if ($input->get('id')) {
			$row = $this->save($errors); // return false if no $row
			$input->def('sid', $row->get('id'));
			$this->status();
		} else {
			$this->addService();
		}
	}


	function saveConfig()
	{
		if (count($_POST)) {
			$post = JRequest::get('request', JREQUEST_ALLOWHTML);
			$number = $post['number'];
			$errors = array();
			$row = $this->save($errors);
			
			$backUrl = JRequest::getVar('backUrl', '');
			if (!empty($backUrl)) {
				$backUrl = urldecode($backUrl);
				$this->setRedirect($backUrl);
			} else {
				$this->setRedirect('index.php?option=com_jaextmanager&view=services');
			}
		}
	}


	function saveorder()
	{
		$model = $this->getModel('services');
		$app = Factory::getApplication();
		$msg = '';
		if (!$model->saveOrder()) {
			$app->enqueueMessage(Text::_('ERROR_OCCURRED_DATA_NOT_SAVED'), 'warning');
		} else {
			$msg = Text::_('SAVE_DATA_SUCCESSFULLY');
		}
		$this->setRedirect('index.php?option=com_jaextmanager&view=services', $msg);
	}


	/**
	 * set default service.
	 * It will be used if there is no service is specified for extension.
	 *
	 */
	function setDefault()
	{
		$model = $this->getModel('services');
		$createdate = JRequest::getInt('createdate', 0);
		$app = Factory::getApplication();

		if (!$model->setDefault(1)) {
			$app->enqueueMessage(Text::_('ERROR_OCCURRED_DATA_NOT_SAVED'), 'warning');
		} else {
			$msg = Text::_('SAVE_DATA_SUCCESSFULLY');
		}
		$link = 'index.php?option=com_jaextmanager&view=services';
		if ($createdate)
			$link .= "&createdate=" . $createdate;
		$this->setRedirect($link, $msg);
	}


	/**
	 * Remove service
	 *
	 */
	function remove()
	{
		$model = $this->getModel('services');
		$cids = JRequest::getVar('cid', null, 'post', 'array');
		$error = array();
		$app = Factory::getApplication();

		foreach ($cids as $cid) {
			if (!$model->delete($cid))
				$error = $cid;
		}
		if (count($error) > 0) {
			$err = implode(",", $error);
			$app->enqueueMessage(Text::_('ERROR_OCCURRED_UNABLE_TO_DELETE_THE_ITEMS_WITH_ID') . ': ' . " [$err]", 'warning');
		} else
			$msg = Text::_("DELETE_DATA_SUCCESSFULLY");
		$this->setRedirect('index.php?option=com_jaextmanager&view=services', $msg);
	}
	
	/**
	 * Get login status
	 */
	
	function status() {
		global $jauc;
		$input = Factory::getApplication()->input;
		$sid = $input->get('sid', 0);
		$result = new stdClass();
		$result->sid = $sid;
		$result->status = 0;
		$result->msg = 'WRONG_USERNAME_AND_PASSWORD_LOGIN_FAILED_PLEASE_TRY_AGAIN';
		
		if (!empty($sid)) {
			$model = $this->getModel('services');
			$row2 = $model->getRow2($sid);
			$service = new stdClass();
			$service->ws_uri = $row2->get('ws_uri');
			$service->ws_user = $row2->get('ws_user');
			$service->ws_pass = $row2->get('ws_pass');
			$response = $jauc->getLoginStatus($service);

			//authenticate service account
			if ($row2->get('ws_mode') == 'local' || (!empty($response) && $response->response)) {
				$result->status = 1;
				$result->msg = 'YOUR_SETTING_IS_SUCCESSFULLY_SAVED';
			}
		}
		
		echo json_encode($result);
		die;
	}
	
	function addService() {
		$app = Factory::getApplication();
		$input = $app->input;
		$result = new stdClass();
		$service = new stdClass();
		$service->ws_uri = $input->getString('ws_uri');
		$service->ws_user = $input->getString('ws_user');
		$service->ws_pass = base64_encode($input->getString('ws_pass'));
		
		global $jauc;
		$response = $jauc->getLoginStatus($service);
		if ((!empty($response) && $response->response)) {
			$this->save();
			// added successfully
			$result->status = 2;
			$result->msg = 'NEW_SERVICE_SUCCESSFULLY_ADDED';
		} else {
			// added failed, check login info
			$result->status = 3;
			$result->msg = 'WRONG_USERNAME_AND_PASSWORD_LOGIN_FAILED_PLEASE_TRY_AGAIN';
		}
		
		echo json_encode($result);
		die;
	}

}