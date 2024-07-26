<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.t4_blank
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

$app             = Factory::getApplication();
$doc             = Factory::getDocument();
$user            = Factory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if ($task == "edit" || $layout == "form") {
  $fullWidth = 1;
} else {
  $fullWidth = 0;
}

// Add JavaScript Frameworks
HTMLHelper::_('bootstrap.framework');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title><?php echo $this->title; ?> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/jpages.css" type="text/css" />

  <!-- Load Google font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

  <link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

</head>

<body class="error-page site <?php echo $option
                                . ' view-' . $view
                                . ($layout ? ' layout-' . $layout : ' no-layout')
                                . ($task ? ' task-' . $task : ' no-task')
                                . ($itemid ? ' itemid-' . $itemid : '')
                                . ($params->get('fluidContainer') ? ' fluid' : '');
                              ?>">

  <!-- Body -->
  <div class="error-page-wrap">
    <div id="outline">
      <div id="errorbox-outline">
        <span class="error-code"><?php echo Text::_('TPL_ERROR_CODE'); ?></span>
        <div class="error-other-info">
          <div class="error-msg">
            <h2><?php echo $this->error->getMessage() ?></h2>
            <?php if (Factory::getConfig()->get('devmode')) : ?>
              <p class="alert alert-error"><code><?php echo $this->error->getFile() ?> (<?php echo $this->error->getLine() ?>)</code></p>
            <?php endif ?>
          </div>
          <p><strong><?php echo Text::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>
          <div class="page-redirect">
            <a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo Text::_('JERROR_LAYOUT_HOME_PAGE'); ?>"><?php echo Text::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php echo $doc->getBuffer('modules', 'debug', array('style' => 'none')); ?>
</body>

</html>