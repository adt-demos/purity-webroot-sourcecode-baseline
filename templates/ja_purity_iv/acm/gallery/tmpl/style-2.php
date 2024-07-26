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

$count = $helper->count('item-desktop-image');
$col = $helper->get('number-cols');
?>
<div id="acm-gallery-<?php echo $module->id ;?>" class="ja-acm acm-gallery style-2">
  <div class="row <?php echo $helper->get('gutter-size'); ?>">
		<?php for ($i=0; $i < $count; $i++) : ?>
		<div class="col-12 col-md-6 col-lg-<?php echo (12 / $col); ?> gallery-item">
      <div class="item-inner <?php echo $helper->get('content-alignment'); ?>">
        <div class="item-media mb-3">

          <div class="item-desktop-image">
            <div class="browser-bar">
              <span></span><span></span><span></span>
            </div>
            <div class="item-view-port">
              <img src="<?php echo $helper->get('item-desktop-image', $i); ?>" alt="<?php echo $helper->get('item-title', $i);?>" />
            </div>
          </div>

          <?php if($helper->get('item-mobile-image', $i) !='') : ?>
          <div class="item-mobile-image">
            <img src="<?php echo $helper->get('item-mobile-image', $i); ?>" alt="<?php echo $helper->get('item-title', $i);?>" />
          </div>
          <?php endif; ?>
        </div>
        <h4 class="item-title mt-0 mb-2">
          <?php if($helper->get('item-link') != '') : ?>
            <a href="<?php echo $helper->get('item-link', $i);?>" target="_blank" title="<?php echo $helper->get('item-title', $i); ?>">
              <?php echo $helper->get('item-title', $i); ?>
            </a>
          <?php else : ?>
            <?php echo $helper->get('item-title', $i);?>
          <?php endif ?>
        </h4>
        <?php if($helper->get('item-desc', $i) !=''): ?>
          <p class="item-desc my-0"><?php echo $helper->get('item-desc', $i);?></p>
        <?php endif; ?>

      </div>
		</div>
		<?php endfor; ?>
  </div>
</div>