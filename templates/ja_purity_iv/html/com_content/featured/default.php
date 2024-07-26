<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

if (!class_exists('ContentHelperRoute')) {
  if (version_compare(JVERSION, '4', 'ge')) {
    abstract class ContentHelperRoute extends RouteHelper
    {
    };
  } else {
    JLoader::register('ContentHelperRoute', $com_path . '/helpers/route.php');
  }
}
//compatible params on joomla 4
$this->columns = !empty($this->columns) ? $this->columns : $this->params->get('num_columns', 1);
if (!$this->columns) $this->columns = 1;
$this->blog_class_leading = $this->params->get('blog_class_leading', '');
$this->blog_class = $this->params->get('blog_class', '');
?>

<div class="blog-featured" itemscope itemtype="https://schema.org/Blog">
  <div class="view-masonry">
    <?php if ($this->params->get('show_page_heading') != 0) : ?>
      <div class="page-header">
        <h1>
          <?php echo $this->escape($this->params->get('page_heading')); ?>
        </h1>
      </div>
    <?php endif; ?>
    <?php if ($this->params->get('page_subheading')) : ?>
      <h2>
        <?php echo $this->escape($this->params->get('page_subheading')); ?>
      </h2>
    <?php endif; ?>

    <?php $leadingcount = 0; ?>
    <?php if (!empty($this->lead_items)) : ?>
      <div class="blog-items items-leading <?php echo $this->params->get('blog_class_leading'); ?>">
        <?php foreach ($this->lead_items as &$item) : ?>
          <div class="blog-item" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
            <div class="blog-item-content"><!-- Double divs required for IE11 grid fallback -->
              <?php
              $this->item = &$item;
              echo $this->loadTemplate('item');
              ?>
            </div>
          </div>
          <?php $leadingcount++; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($this->intro_items)) : ?>
      <?php
      $blogClass = $this->blog_class;
      $introcount = count($this->intro_items);
      $counter = 0;
      ?>
      <?php if ((int) $this->columns  > 1) : ?>
        <?php $blogClass .= (int) $this->params->get('multi_column_order', 0) === 0 ? ' masonry-' : ' columns-'; ?>
        <?php $blogClass .= (int) $this->columns; ?>
      <?php endif; ?>
      <div class="blog-items <?php echo $blogClass; ?>">
        <div id="item-container" class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?> row">
          <?php foreach ($this->intro_items as $key => &$item) : ?>
            <div class="item item-article col-12 col-md-<?php echo $this->columns > 2 ? '6' : round(12 / $this->columns); ?> col-lg-<?php echo round(12 / $this->columns); ?> column-<?php echo $this->columns; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
              <div class="item-inner item-default">
                <?php
                $this->item = &$item;
                echo $this->loadTemplate('item');
                ?>
              </div>
            </div>
            <?php $counter++; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- pagination -->
    <?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
      <div class="pagination-wrap">
        <?php echo $this->pagination->getPagesLinks(); ?>
      </div>
      <!-- Show load more use infinitive-scroll -->
      <?php
      HTMLHelper::_('jquery.framework');
      $app = Factory::getApplication();
      Factory::getDocument()->addScript(Uri::base() . 'templates/' . $app->getTemplate() . '/js/infinitive-paging.js');
      Factory::getDocument()->addScript(Uri::base() . 'templates/' . $app->getTemplate() . '/js/jquery.infinitescroll.js');
      $mode = 'manual';

      if ($this->pagination->pagesTotal > 1) : ?>
        <script>
          jQuery(".pagination-wrap").css('display', 'none');
        </script>
        <div class="infinity-wrap d-flex justify-content-center">
          <div id="infinity-next" class="btn btn-more btn-outline-dark" data-limit="<?php echo $this->pagination->limit; ?>" data-url="<?php echo Uri::current(); ?>" data-mode="<?php echo $mode ?>" data-pages="<?php echo $this->pagination->pagesTotal ?>" data-finishedmsg="<?php echo Text::_('TPL_LOADMORE_END_MSG'); ?>">
            <?php echo Text::_('TPL_LOAD_MORE') ?>
          </div>
        </div>
      <?php else :  ?>
        <div class="infinity-wrap d-flex justify-content-center">
          <div id="infinity-next" class="btn btn-more" data-pages="1" disabled>
            <?php echo Text::_('TPL_LOADMORE_END_MSG'); ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

</div>