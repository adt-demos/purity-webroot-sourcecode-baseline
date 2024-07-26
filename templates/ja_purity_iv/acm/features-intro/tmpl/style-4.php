<?php

/**
 * ------------------------------------------------------------------------
 * ja_purity_iv_tpl
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2018 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;

PluginHelper::importPlugin('content');
$countFeature = $helper->getRows('feature-title');

$featuresColumns = $helper->get('features-columns');
$contentAlign = $helper->get('content-alignment');
?>

<div id="acm-features-<?php echo $module->id; ?>" class="ja-acm acm-features style-4">
  <div class="container">
    <div class="features-list">
      <div class="owl-carousel">
        <?php for ($i = 0; $i < $countFeature; $i++) : ?>
          <div class="fd-item <?php echo $contentAlign; ?>">
            <?php if ($helper->get('feature-img', $i)) : ?>
              <div class="fd-item-media">
                <img src="<?php echo $helper->get('feature-img', $i); ?>" title="<?php echo $helper->get('feature-title', $i); ?>">
              </div>
            <?php endif ?>

            <div class="fd-item-inner">
              <?php if ($helper->get('feature-title', $i)) : ?>
                <h5 class="fd-item-title mt-0 mb-3">
                  <?php echo $helper->get('feature-title', $i); ?>
                </h5>
              <?php endif; ?>

              <?php if ($helper->get('feature-desc', $i)) : ?>
                <div class="fd-item-desc">
                  <?php echo $helper->get('feature-desc', $i); ?>
                </div>
              <?php endif; ?>

              <?php if ($helper->get('btn-link', $i)) : ?>
                <div class="feature-actions mt-4">
                  <a href="<?php echo $helper->get('btn-link', $i); ?>" class="btn <?php echo $helper->get('btn-type', $i); ?>"><?php echo $helper->get('btn-text', $i); ?></a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endfor ?>
      </div>
    </div>
  </div>
</div>

<script>
  (function($) {
    jQuery(document).ready(function($) {
      $("#acm-features-<?php echo $module->id; ?> .owl-carousel").owlCarousel({
        addClassActive: true,
        animateOut: 'fadeOut',
        items: <?php echo $featuresColumns; ?>,
        margin: 32,
        loop: false,
        nav: <?php echo ($count < $countFeature) ? 'true' : 'false'; ?>,
        smartSpeed: 600,
        dots: false,
        autoplay: <?php echo $helper->get('autoplay'); ?>,
        autoplayTimeout: <?php echo $helper->get('auto-time'); ?>,
        rtl: $('html').attr('dir') === 'rtl',
        autoplaySpeed: false,
        responsive: {
          0: {
            items: 1
          },
          767: {
            items: 2
          },
          1200: {
            items: <?php echo $featuresColumns; ?>
          }
        }
      });
    });
  })(jQuery);
</script>