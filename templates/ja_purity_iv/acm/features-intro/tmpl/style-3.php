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

$countSubFeature = $helper->getRows('sub-features.sub-feature-title');
$countBtn = $helper->getRows('feature-btn.btn-text');
$mediaAlign = $helper->get('media-alignment');

$colImg = 'col-12 col-lg-6';
$colContent = 'col-12 col-lg-6 col-xl-5 offset-xl-1';

if($mediaAlign == 'column' || $mediaAlign == 'column-reverse') {
	$colImg = 'col-12 text-center';
	$colContent = 'col-12 col-lg-6 mx-auto text-center';
} elseif ($mediaAlign == 'row-reverse') {
	$colImg = 'col-12 col-lg-6 offset-xl-1';
	$colContent = 'col-12 col-lg-5';
}
?>

<div class="ja-acm acm-features style-3">
	<div class="container">
		<div class="row flex-<?php echo $mediaAlign; ?> align-items-center justify-content-between v-gutters">
			<div class="<?php echo $colImg ;?>">
				<div class="feature-media">
					<img src="<?php echo $helper->get('feature-main-img');?>" title="<?php echo $helper->get('feature-title'); ?>">
				</div>
			</div>

			<div class="<?php echo $colContent ;?>">
				<div class="feature-ct">
					<?php if($helper->get('feature-title')) :?>
						<h2 class="mt-0 mb-4"><?php echo $helper->get('feature-title'); ?></h2>
					<?php endif ;?>

					<?php if($helper->get('feature-desc')) :?>
						<div class="lead"><?php echo $helper->get('feature-desc'); ?></div>
					<?php endif ;?>

					<?php if($countSubFeature > 1) :?>
					<div class="sub-features row mt-3 mt-xl-5 v-gutters">
						<?php for($i=0; $i<$countSubFeature; $i++) : ?>
							<div class="col-12 col-md-<?php echo (12 / $helper->get('sub-features-columns')); ?> fd-item  media-align-<?php echo $helper->get('sub-media-alignment'); ?>">
								
								<?php if($helper->get('sub-features.sub-feature-img', $i)) : ?>
								<div class="fd-item-media mb-3">
									<img src="<?php echo $helper->get('sub-features.sub-feature-img', $i);?>" title="<?php echo $helper->get('sub-features.sub-feature-title', $i); ?>" <?php if($helper->get('sub-feature-media-width') !='') :?>style="max-width: <?php echo $helper->get('sub-feature-media-width');?> "<?php endif ?>>
								</div>
								<?php endif ?>

								<div class="sub-content-detail">
									<?php if($helper->get('sub-features.sub-feature-text-icon', $i)): ?>
										<div class="fd-text-icon mb-3"><span class="h1 text-primary fw-bolder"><?php echo $helper->get('sub-features.sub-feature-text-icon', $i); ?></span></div>
									<?php endif ?>

									<?php if($helper->get('sub-features.sub-feature-title', $i)) :?>
										<h5 class="fd-item-title mb-3 mt-0"><?php echo $helper->get('sub-features.sub-feature-title', $i); ?></h5>
									<?php endif ?>

									<?php if($helper->get('sub-features.sub-feature-desc', $i)) :?>
										<div class="fd-item-desc"><?php echo $helper->get('sub-features.sub-feature-desc', $i); ?></div>	
									<?php endif ?>
								</div>			
							</div>
						<?php endfor ?>
					</div>
					<?php endif ;?>


					<?php if($countBtn > 1) : ?>
						<div class="feature-actions mt-5 d-flex flex-column flex-sm-row gap-3">
							<?php for($j=0; $j<$countBtn; $j++) { ?>
								<a href="<?php echo $helper->get('feature-btn.btn-link', $j);?>" class="btn <?php echo $helper->get('feature-btn.btn-type', $j); ?>"><?php echo $helper->get('feature-btn.btn-text', $j);?></a>
							<?php } ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
