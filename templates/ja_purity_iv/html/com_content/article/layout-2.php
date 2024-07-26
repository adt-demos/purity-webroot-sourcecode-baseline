<?php

/**
T4 Overide
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
//use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use T4\Helper\J3J4;

if (!class_exists('ContentHelperRoute')) {
  if (version_compare(JVERSION, '4', 'ge')) {
    abstract class ContentHelperRoute extends \Joomla\Component\content\Site\Helper\RouteHelper
    {
    };
  } else {
    JLoader::register('ContentHelperRoute', $com_path . '/helpers/route.php');
  }
}

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = Factory::getUser();
$info    = $params->get('info_block_position', 0);
$og_iamge = $images->image_intro ?: $images->image_fulltext;
// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

// Rating
if (isset($this->item->rating_sum) && $this->item->rating_count > 0) {
  $this->item->rating = round($this->item->rating_sum / $this->item->rating_count, 1);
  $this->item->rating_percentage = $this->item->rating_sum / $this->item->rating_count * 20;
} else {
  if (!isset($this->item->rating)) $this->item->rating = 0;
  if (!isset($this->item->rating_count)) $this->item->rating_count = 0;
  $this->item->rating_percentage = $this->item->rating * 20;
}
$uri = Uri::getInstance();

?>
<div class="com-content-article item-page layout-2 <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
  <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? Factory::getApplication()->get('language') : $this->item->language; ?>">

  <div class="container">
    <?php if (!$this->print) : ?>
      <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
        <?php echo LayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
      <?php endif; ?>
    <?php else : ?>
      <?php if ($useDefList) : ?>
        <div id="pop-print" class="btn hidden-print">
          <?php echo HTMLHelper::_('icon.print_screen', $this->item, $params); ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="top-article-info">
      <div class="row v-gutters">
        <div class="col-12 col-xl-6 align-items-center d-flex">
          <div class="intro-article-info">
            <?php if ($this->params->get('show_page_heading')) : ?>
              <div class="page-header">
                <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
              </div>
            <?php endif; ?>

            <?php if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative) {
              echo $this->item->pagination;
            }  ?>

            <?php // Todo Not that elegant would be nice to group the params 
            ?>
            <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
              || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

            <?php if (!$useDefList && $this->print) : ?>
              <div id="pop-print" class="btn hidden-print clearfix">
                <?php echo HTMLHelper::_('icon.print_screen', $this->item, $params); ?>
              </div>
            <?php endif; ?>

            <div class="article-aside">
              <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
                <?php echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
              <?php endif; ?>
            </div>

            <?php if ($params->get('show_title') || $params->get('show_author')) : ?>
              <div class="page-header">
                <?php if ($params->get('show_title')) : ?>
                  <h2 itemprop="headline">
                    <?php echo $this->escape($this->item->title); ?>
                  </h2>
                <?php endif; ?>

                <?php // Content is generated by content plugin event "onContentAfterTitle" 
                ?>
                <?php echo $this->item->event->afterDisplayTitle; ?>

                <?php if (J3J4::checkUnpublishedContent($this->item)) : ?>
                  <span class="label label-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
                <?php endif; ?>

                <?php
                $timePublishUp = $this->item->publish_up != null
                  ? strtotime($this->item->publish_up) : '';
                if ($timePublishUp > strtotime(Factory::getDate())) : ?>
                  <span class="badge badge-warning"><?php echo Text::_('JNOTPUBLISHEDYET'); ?></span>
                <?php endif; ?>

                <?php
                $timePublishDown = $this->item->publish_down != null
                  ? strtotime($this->item->publish_down) : '';
                if ($this->item->publish_down && ($timePublishDown < strtotime(Factory::getDate())) && $this->item->publish_down != Factory::getDbo()->getNullDate()) : ?>
                  <span class="badge badge-warning"><?php echo Text::_('JEXPIRED'); ?></span>
                <?php endif; ?>

              </div>
            <?php endif; ?>

            <div class="desc-article">
              <?php echo HTMLHelper::_('content.prepare', $this->item->introtext); ?>
            </div>

            <div class="bottom-meta d-flex">
              <?php if ($info == 1 || $info == 2) : ?>
                <?php if ($useDefList) : ?>
                  <?php echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
                <?php endif; ?>
              <?php endif; ?>

              <!-- Show voting form -->
              <?php if ($params->get('show_vote')) : ?>
                <div class="review-item rating">
                  <div class="rating-info pd-rating-info">

                    <form class="rating-form action-vote" method="POST" action="<?php echo htmlspecialchars($uri->toString()) ?>">
                      <ul class="rating-list">
                        <li class="rating-current" style="width:<?php echo $this->item->rating_percentage; ?>%;"></li>
                        <li><a href="javascript:void(0)" title="<?php echo Text::_('JA_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
                        <li><a href="javascript:void(0)" title="<?php echo Text::_('JA_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
                        <li><a href="javascript:void(0)" title="<?php echo Text::_('JA_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
                        <li><a href="javascript:void(0)" title="<?php echo Text::_('JA_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
                        <li><a href="javascript:void(0)" title="<?php echo Text::_('JA_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
                      </ul>
                      <input type="hidden" name="task" value="article.vote" />
                      <input type="hidden" name="hitcount" value="0" />
                      <input type="hidden" name="user_rating" value="5" />
                      <input type="hidden" name="url" value="<?php echo htmlspecialchars($uri->toString()) ?>" />
                      <?php echo HTMLHelper::_('form.token') ?>
                    </form>
                  </div>
                  <!-- //Rating -->

                  <script type="text/javascript">
                    ! function($) {
                      $('.rating-form').each(function() {
                        var form = this;
                        $(this).find('.rating-list li a').click(function(event) {
                          event.preventDefault();
                          if (form.user_rating) {
                            form.user_rating.value = this.innerHTML;
                            form.submit();
                          }
                        });
                      });
                    }(window.jQuery);
                  </script>
                </div>
              <?php endif; ?>
              <!-- End showing -->
            </div>
          </div>
        </div>

        <div class="col-12 col-xl-6">
          <div class="full-image">
            <?php echo LayoutHelper::render('joomla.content.full_image', $this->item); ?>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="container">
    <div class="bottom-article-info">
      <div class="article-inner">
        <div class="row">
          <div class="col-12 col-md-3 order-2 order-md-1 mt-5 mt-md-0">
            <div class="siderbar-article">
              <?php echo $this->item->event->beforeDisplayContent; ?>

              <?php if (HTMLHelper::_('content.prepare', '{loadposition read-next}')) : ?>
                <div class="read-next">
                  <?php echo HTMLHelper::_('content.prepare', '{loadposition read-next}'); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-12 col-md-9 order-1 order-md-2">
            <?php if (
              isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position)))
              || (empty($urls->urls_position) && (!$params->get('urls_position')))
            ) : ?>
              <?php echo $this->loadTemplate('links'); ?>
            <?php endif; ?>

            <?php if ($params->get('access-view')) : ?>

              <?php if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative) :
                echo $this->item->pagination;
              endif; ?>

              <?php if (isset($this->item->toc)) : echo $this->item->toc;
              endif; ?>

              <div itemprop="articleBody" class="article-body">
                <?php if ($params->get('show_intro')) : ?>
                  <?php echo HTMLHelper::_('content.prepare', $this->item->fulltext); ?>
                <?php else : ?>
                  <?php echo HTMLHelper::_('content.prepare', $this->item->text); ?>
                <?php endif; ?>
                
                <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
                  <?php $this->item->tagLayout = new FileLayout('joomla.content.tags'); ?>
                  <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
                <?php endif; ?>
              </div>

              <?php // Content is generated by content plugin event "onContentAfterDisplay" 
              ?>
              <?php echo $this->item->event->afterDisplayContent; ?>

              <?php
              if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative) :
                echo $this->item->pagination;
              endif;
              ?>

              <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) : ?>
                <?php echo $this->loadTemplate('links'); ?>
              <?php endif; ?>

              <?php // Optional teaser intro text for guests 
              ?>
            <?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
              <?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
              <?php echo HTMLHelper::_('content.prepare', $this->item->introtext); ?>
              <?php // Optional link to let them register to see the whole article. 
              ?>

              <?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
                <?php $menu = Factory::getApplication()->getMenu(); ?>
                <?php $active = $menu->getActive(); ?>
                <?php $itemId = $active->id; ?>
                <?php $link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
                <?php $link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language))); ?>

                <p class="com-content-article__readmore readmore">
                  <a href="<?php echo $link; ?>" class="register">
                    <?php $attribs = json_decode($this->item->attribs); ?>
                    <?php
                    if ($attribs->alternative_readmore == null) :
                      echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE');
                    elseif ($readmore = $attribs->alternative_readmore) :
                      echo $readmore;
                      if ($params->get('show_readmore_title', 0) != 0) :
                        echo HTMLHelper::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
                      endif;
                    elseif ($params->get('show_readmore_title', 0) == 0) :
                      echo Text::sprintf('COM_CONTENT_READ_MORE_TITLE');
                    else :
                      echo Text::_('COM_CONTENT_READ_MORE');
                      echo HTMLHelper::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
                    endif; ?>
                  </a>
                </p>
              <?php endif; ?>
            <?php endif; ?>

            <?php
            if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
              echo $this->item->pagination;
            endif;
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  jQuery(document).ready(function($) {
    if ($('.sidebar-r').length > 0 || $('.sidebar-l').length > 0) {
      $('.item-page').addClass('has-sidebar');
    } else {
      $('.item-page').addClass('no-sidebar');
      $('#t4-main-body > .t4-section-inner').removeClass('container').addClass('container-fluid');
    }
  });
</script>