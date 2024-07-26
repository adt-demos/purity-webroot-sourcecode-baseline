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
$featuresStyle = $helper->get('features-style');
$featuresBg = $helper->get('features-bg');

$mediaAlignment = $helper->get('media-alignment');
$mediaSize = $helper->get('media-size');
?>

<div class="ja-acm acm-features style-2">
	<div class="container">

	<div class="features-list row v-gutters fd-<?php echo $featuresStyle; ?>">
	<?php for($i=0; $i<$countFeature; $i++) : ?>
		<div class="col-12 col-md-6 col-lg-<?php echo (12 / $featuresColumns); ?> fd-item media-<?php echo $mediaAlignment; ?>">
			<div class="fd-item-inner <?php echo $featuresBg; ?> <?php if($featuresBg != 'bg-default') echo 'has-bg-color'; ?> <?php echo ($featuresStyle=='border')?'p-4':''; ?>">

				<?php if($helper->get('feature-img', $i)) : ?>
				<div class="fd-item-media">
					<img src="<?php echo $helper->get('feature-img', $i);?>" title="<?php echo $helper->get('feature-title', $i); ?>" <?php if($mediaSize != '') : ?>style="max-width: <?php echo $mediaSize; ?>"<?php endif ?>>
				</div>
				<?php endif ?>
				<div class="fd-item-content">
					<h5 class="fd-item-title mt-0 mb-2"><?php echo $helper->get('feature-title', $i); ?></h5>
					<div class="fd-item-desc"><?php echo $helper->get('feature-desc', $i); ?></div>
				</div>
			</div>
		</div>
	<?php endfor ?>
	</div>
	</div>
</div>

