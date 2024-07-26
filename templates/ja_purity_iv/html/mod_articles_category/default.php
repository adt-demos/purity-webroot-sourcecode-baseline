<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use T4\Helper\Author as Author;

$moduleclass_sfx = $params->get('moduleclass_sfx', '');
?>
<ul class="category-module<?php echo $moduleclass_sfx; ?> mod-list">
  <?php if ($grouped) : ?>
    <?php foreach ($list as $group_name => $group) : ?>
      <li class="list-group">

        <ul>
          <?php foreach ($group as $item) : ?>
            <li class="item">
              <!-- Item image -->
              <?php
              $images = "";
              if (isset($item->images)) {
                $images = json_decode($item->images);
              }

              $imgexists = (isset($images->image_intro) and !empty($images->image_intro)) || (isset($images->image_fulltext) and !empty($images->image_fulltext));

              if ($imgexists) {
                $images->image_intro = $images->image_intro ? $images->image_intro : $images->image_fulltext;
              ?>
                <div class="item-media">
                  <a href="<?php echo $item->link; ?>">
                    <img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>" />
                  </a>
                </div>
              <?php } ?>

              <div class="item-body">
                <?php if ($item->displayCategoryTitle) : ?>
                  <div class="item-category">
                    <?php echo Text::_($group_name); ?>
                  </div>
                <?php endif; ?>

                <?php if ($params->get('link_titles') == 1) : ?>
                  <h5 class="item-title"><a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h5>
                <?php else : ?>
                  <h5 class="item-title"><?php echo $item->title; ?></h5>
                <?php endif; ?>

                <?php if ($params->get('show_intro')) : ?>
                  <p class="item-introtext">
                    <?php echo $item->displayIntrotext; ?>
                  </p>
                <?php endif; ?>

                <div class="item-meta">
                  <?php
                  $author =  '<span class="name">' . $item->author . '</span>';

                  if (!empty($displayData['item']->contact_link) && $displayData['params']->get('link_author') == true) : ?>
                    <?php echo Text::sprintf('TPL_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url'))); ?>
                  <?php else : ?>
                    <?php echo Text::sprintf('TPL_CONTENT_WRITTEN_BY', $author); ?>
                  <?php endif; ?>

                  <?php if ($item->displayDate) : ?>
                    <span class="item-date">
                      <?php echo $item->displayDate; ?>
                    </span>
                  <?php endif; ?>

                  <?php if ($item->displayHits) : ?>
                    <span class="txt-hits">
                      <?php echo $item->displayHits; ?>
                    </span>
                  <?php endif; ?>
                </div>

                <?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
                  <div class="list-tags">
                    <?php echo JLayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
                  </div>
                <?php endif; ?>

                <?php if ($params->get('show_readmore')) : ?>
                  <p class="item-readmore">
                    <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
                      <?php if ($item->params->get('access-view') == false) : ?>
                        <?php echo Text::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
                      <?php elseif ($readmore = $item->alternative_readmore) : ?>
                        <?php echo $readmore; ?>
                        <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                      <?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
                        <?php echo Text::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
                      <?php else : ?>
                        <?php echo Text::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
                        <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                      <?php endif; ?>
                    </a>
                  </p>
                <?php endif; ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </li>
    <?php endforeach; ?>
  <?php else : ?>
    <?php foreach ($list as $item) : ?>

      <li class="item">
        <!-- Item image -->
        <?php
        $images = "";
        if (isset($item->images)) {
          $images = json_decode($item->images);
        }

        $imgexists = (isset($images->image_intro) and !empty($images->image_intro)) || (isset($images->image_fulltext) and !empty($images->image_fulltext));

        if ($imgexists) {
          $images->image_intro = $images->image_intro ? $images->image_intro : $images->image_fulltext;
        ?>
          <div class="item-media">
            <a href="<?php echo $item->link; ?>">
              <img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>" />
            </a>
          </div>
        <?php } ?>

        <div class="item-body">
          <!-- Title -->
          <?php if ($params->get('link_titles') == 1) : ?>
            <h5 class="item-title"><a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h5>
          <?php else : ?>
            <h5 class="item-title"><?php echo $item->title; ?></h5>
          <?php endif; ?>

          <div class="item-meta text-muted">
            <!-- Author -->
            <?php if ($item->displayAuthorName) : ?>
              <?php
              $author_info = Author::authorInfo($item);
              $author =  '<span class="name"><a href="' . $author_info->link . '">' . $item->author . '</a></span>';

              if (!empty($displayData['item']->contact_link) && $displayData['params']->get('link_author') == true) : ?>
                <?php echo Text::sprintf('TPL_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url'))); ?>
              <?php else : ?>
                <?php echo Text::sprintf('TPL_CONTENT_WRITTEN_BY', $author); ?>
              <?php endif; ?>
            <?php endif; ?>

            <!-- Category -->
            <?php if ($item->displayCategoryTitle) : ?>
              <span class="item-category">
                <?php echo $item->displayCategoryTitle; ?>
              </span>
            <?php endif; ?>

            <!-- Date -->
            <?php if ($item->displayDate) : ?>
              <span class="item-date">
                <?php echo $item->displayDate; ?>
              </span>
            <?php endif; ?>

            <!-- Hit -->
            <?php if ($item->displayHits) : ?>
              <span class="txt-hits">
                <?php echo $item->displayHits; ?>
              </span>
            <?php endif; ?>
          </div>

          <!-- Introtext -->
          <?php if ($params->get('show_intro')) : ?>
            <p class="item-introtext">
              <?php echo $item->displayIntrotext; ?>
            </p>
          <?php endif; ?>



          <?php if ($params->get('show_readmore')) : ?>
            <p class="item-readmore">
              <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
                <?php if ($item->params->get('access-view') == false) : ?>
                  <?php echo Text::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
                <?php elseif ($readmore = $item->alternative_readmore) : ?>
                  <?php echo $readmore; ?>
                  <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                <?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
                  <?php echo Text::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
                <?php else : ?>
                  <?php echo Text::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
                  <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                <?php endif; ?>
              </a>
            </p>
          <?php endif; ?>

          <!-- Tag -->
          <?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
            <div class="list-tags">
              <?php echo JLayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
            </div>
          <?php endif; ?>
        </div>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
</ul>