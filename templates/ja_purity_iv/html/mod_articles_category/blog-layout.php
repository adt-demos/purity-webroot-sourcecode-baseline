<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use T4\Helper\Author as Author;
use Joomla\CMS\Factory;
// load language t4
Factory::getLanguage()->load('plg_system_' . T4_PLUGIN, JPATH_ADMINISTRATOR);

$moduleclass_sfx = $params->get('moduleclass_sfx','');
?>

<ul class="blog-list<?php echo $moduleclass_sfx; ?> mod-list row row-cols-1 row-cols-3">
	<?php if ($grouped) : ?>

	<?php else : ?>
		<?php foreach ($list as $item) : ?>
			<li class="blog-item col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<!-- Item image -->
				<?php  
				$images = "";
				if (isset($item->images)) {
					$images = json_decode($item->images);
				}

				$imgexists = (isset($images->image_intro) and !empty($images->image_intro)) || (isset($images->image_fulltext) and !empty($images->image_fulltext));
				
				if ($imgexists) {			
					$images->image_intro = $images->image_intro?$images->image_intro:$images->image_fulltext;
				?>

				<a class="item-image" href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
					<img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>" />
				</a>
				<?php } ?>
				<!-- // Item image -->

				<?php if ($params->get('link_titles') == 1) : ?>
					<h3 class="item-title"><a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
				<?php else : ?>
					<h3><?php echo $item->title; ?></h3>
				<?php endif; ?>

				<div class="item-meta">
					<?php if ($params->get('show_author')) : 
						$author_info = Author::authorInfo($item);
					?>
					<span class="item-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
						<?php $author = $img_alt = ($item->created_by_alias ?: $item->author); ?>
						<?php $author = '<strong itemprop="name">' . $author . '</strong>'; ?>
						<?php if(isset($author_info->author_avatar)):?>
							<span  class="author-img">
							<?php if(!empty($author_info->link)): ?>
							<a href="<?php echo $author_info->link;?>" title="<?php echo $img_alt;?>">
							<?php endif; ?>
							<?php echo version_compare(JVERSION,'4.0', 'ge') ? JLayoutHelper::render('joomla.html.image',array('src'=>$author_info->author_avatar,'alt'=>$img_alt)) : "<img src=\"".$author_info->author_avatar."\" alt=\"".$img_alt."\"  />";  ?>
							<?php if(!empty($author_info->link)): ?>
							</a>
							<?php endif;?>
							</span>
						<?php endif;?>

						<?php if (!empty($author_info->link )) : ?>
							<?php echo Text::sprintf('TPL_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $author_info->link, $author, array('itemprop' => 'url'))); ?>
						<?php else : ?>
							<?php echo Text::sprintf('TPL_CONTENT_WRITTEN_BY', $author); ?>
						<?php endif; ?>
					</span>
					<?php endif; ?>

					<?php if ($item->displayDate) : ?>
						<span class="item-date">
							<?php echo $item->displayDate; ?>
						</span>
					<?php endif; ?>

					<?php if ($item->displayCategoryTitle) : ?>
					<span class="item-cat">
						<?php echo $item->displayCategoryTitle; ?>
					</span>
					<?php endif; ?>
				</div>

				<?php if ($params->get('show_introtext')) : ?>
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
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>