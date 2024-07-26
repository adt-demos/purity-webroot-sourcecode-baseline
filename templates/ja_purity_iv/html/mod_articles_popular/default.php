<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_popular
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

if (!isset($list)) {
  return;
}

?>
<ul class="mostread mod-list">
  <?php foreach ($list as $item) : ?>
    <li class="item mostread-item clearfix d-flex">
      <div class="item-media">
        <?php if (json_decode($item->images)->image_intro) : ?>
          <img src="<?php echo json_decode($item->images)->image_intro; ?>" alt="<?php echo $item->title; ?>" />
        <?php endif; ?>
      </div>
      <div class="item-body">
        <h6 class="item-title">
          <a href="<?php echo $item->link; ?>" itemprop="url">
            <?php echo $item->title; ?>
          </a>
        </h6>
        <div class="item-meta">
          <span class="item-date"><?php echo Text::sprintf('TPL_CONTENT_PUBLISHED_DATE_ON', HTMLHelper::_('date', $item->displayDate, Text::_('d.M'))) ?></span>
        </div>
      </div>
    </li>
  <?php endforeach; ?>
</ul>