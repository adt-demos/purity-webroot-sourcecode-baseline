<?php

/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\AuthenticationHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();

// Add JavaScript Frameworks
HTMLHelper::_('bootstrap.framework');

require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';

$twofactormethods = UsersHelper::getTwoFactorMethods();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/jpages.css" type="text/css" />
  <jdoc:include type="head" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Load Google font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

  <?php if ($this->direction == 'rtl') : ?>
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/offline_rtl.css" type="text/css" />
  <?php endif; ?>
</head>

<body class="offline">

  <div id="frame" class="outline ">
    <jdoc:include type="message" />

    <!-- Offline Image -->
    <?php if ($app->get('offline_image')) : ?>
      <div class="offline-image">
        <?php echo HTMLHelper::_('image', $app->get('offline_image'), $app->get('sitename'), [], false, 0); ?>
      </div>
    <?php endif; ?>
    <!-- // Offline Image -->

    <div class="form-wrap">
      <div class="offline-header">

        <!-- Site name -->
        <h1><?php echo htmlspecialchars($app->get('sitename')); ?></h1>

        <!-- Offline message -->
        <?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) != '') : ?>
          <p class="offline-message"><?php echo $app->get('offline_message'); ?></p>
        <?php elseif ($app->get('display_offline_message', 1) == 2 && str_replace(' ', '', Text::_('JOFFLINE_MESSAGE')) != '') : ?>
          <p class="offline-message"><?php echo Text::_('JOFFLINE_MESSAGE'); ?></p>
        <?php endif; ?>
        <!-- // Offline message -->

      </div>

      <form action="<?php echo Route::_('index.php', true); ?>" method="post" id="form-login">
        <fieldset class="input">
          <!-- Username -->
          <p id="form-login-username">
            <input name="username" id="username" type="text" class="inputbox" alt="<?php echo Text::_('JGLOBAL_USERNAME'); ?>" size="18" placeholder="<?php echo Text::_('JGLOBAL_USERNAME'); ?>" />
          </p>

          <!-- Password -->
          <p id="form-login-password">
            <input type="password" name="password" class="inputbox" size="18" alt="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>" id="passwd" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>" />
          </p>

          <?php if (count($twofactormethods) > 1) : ?>
            <p id="form-login-secretkey">
              <label for="secretkey"><?php echo Text::_('JGLOBAL_SECRETKEY'); ?></label>
              <input type="text" name="secretkey" class="inputbox" size="18" alt="<?php echo Text::_('JGLOBAL_SECRETKEY'); ?>" id="secretkey" />
            </p>
          <?php endif; ?>

          <!-- Button Login -->
          <p id="submit-buton">
            <input type="submit" name="Submit" class="button login" value="<?php echo Text::_('JLOGIN'); ?>" />
          </p>

          <input type="hidden" name="option" value="com_users" />
          <input type="hidden" name="task" value="user.login" />
          <input type="hidden" name="return" value="<?php echo base64_encode(Uri::base()); ?>" />
          <?php echo HTMLHelper::_('form.token'); ?>
        </fieldset>
      </form>
    </div>
  </div>
</body>

</html>