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
?>

<div class="ja-acm acm-features style-1">
	<?php for($i=0; $i<$countFeature; $i++) : ?>
	<div class="row media-<?php echo $helper->get('media-alignment', $i);?>">
		<div class="col-12 col-md-6">
			<div class="feature-ct">
				<h2><?php echo $helper->get('feature-title', $i); ?></h2>
				<p class="lead"><?php echo $helper->get('feature-desc'); ?></p>
				<div class="feature-actions">
					<a href="<?php echo $helper->get('feature-btn.btn-link'); ?>" class="btn <?php echo $helper->get('feature-btn.btn-type'); ?>"><?php echo $helper->get('feature-btn.btn-text'); ?></a>
				</div>
			</div>
		</div>

		<div class="col-12 col-md-6">
			<div class="feature-media">
				<img src="<?php echo $helper->get('feature-img');?>" title="<?php echo $helper->get('feature-title', $i); ?>">
			</div>
		</div>
	</div>
	<?php endfor ?>
</div>
