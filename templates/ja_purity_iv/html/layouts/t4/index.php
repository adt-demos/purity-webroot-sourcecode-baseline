<?php

defined('_JEXEC') or die();
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
$doc = Factory::getDocument();
$cookieId = 'jadark-' . md5(Uri::root());
$site_settings = $doc->params->get('site-settings');
$bodyClass = $site_settings->get('other_default_theme', 'light-active');

if ($site_settings->get('other_darkmode', true)) {
  $input = Factory::getApplication()->input;

  if ($input->cookie->get($cookieId) === 'isActive') {
    $bodyClass = 'dark-active';
  } else if ($input->cookie->get($cookieId) !== null) {
    $bodyClass = 'light-active';
  }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="j{t4post:jversion}" xml:lang="{t4:language}" lang="{t4:language}" dir="{t4:direction}">

<head>
  {t4:system_advancedCodeAfterHead}
  {t4post:head}

  <!--[if lt IE 9]>
    <script src="<?php echo Uri::root(true); ?>/media/jui/js/html5.js"></script>
  <![endif]-->
  <meta name="viewport"  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes"/>
  <style  type="text/css">
    @-webkit-viewport   { width: device-width; }
    @-moz-viewport      { width: device-width; }
    @-ms-viewport       { width: device-width; }
    @-o-viewport        { width: device-width; }
    @viewport           { width: device-width; }
  </style>
  <meta name="HandheldFriendly" content="true"/>
  <meta name="apple-mobile-web-app-capable" content="YES"/>
  <!-- //META FOR IOS & HANDHELD -->
  {t4:system_advancedCodeBeforeHead}
</head>

<body class="{t4post:bodyclass} <?php echo $bodyClass ; ?>" data-jver="{t4post:jversion}" jadark-cookie-id="<?php echo $cookieId ?>">
  {t4:system_advancedCodeAfterBody}
  {t4:offcanvas}
  <main>
    <div class="t4-wrapper">
      <div class="t4-content">
        <div class="t4-content-inner">
          {t4:body}
        </div>
      </div>
    </div>
  </main>
  {t4:system_advancedCodeBeforeBody}
</body>
</html>
