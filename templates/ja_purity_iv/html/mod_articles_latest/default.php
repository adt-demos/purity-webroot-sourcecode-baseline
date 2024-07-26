<?php

/**
 * ------------------------------------------------------------------------
 * ja_justitia_tpl
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2021 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
<ul class="latestnews list-item <?php echo $params->get('moduleclass_sfx', ''); ?>">
  <?php foreach ($list as $item) :  ?>
    <li class="item clearfix">
      <div class="item-media">
        <?php if (json_decode($item->images)->image_intro) : ?>
          <img src="<?php echo json_decode($item->images)->image_intro; ?>" alt="<?php echo $item->title; ?>" />
        <?php endif; ?>
      </div>

      <div class="item-body">
        <h5 class="item-title"><a class="mod-articles-category-title" href="<?php echo $item->link; ?>" itemprop="url"><?php echo $item->title; ?></a></h5>
        <div class="item-meta">
          <?php $cat_link = Route::_(ContentHelperRoute::getCategoryRoute($item->catid, $item->category_language)); ?>
          <span class="item-category"><a href="<?php echo $cat_link ?>"><?php echo $item->category_title ?></a></span>
          <span class="item-date"><span><?php echo Text::sprintf('TPL_CONTENT_PUBLISHED_DATE_ON', HTMLHelper::_('date', $item->displayDate, Text::_('d.M'))); ?></span></span>
        </div>
      </div>

    </li>
  <?php endforeach; ?>
</ul>