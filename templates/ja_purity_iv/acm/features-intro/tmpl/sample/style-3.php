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
$count = $helper->getRows('title');

// MODULE CONFIG
$moduleTitle = $module->title;
$moduleMain = $params->get('main-heading');
$moduleDesc = $params->get('mod-desc');

  // Sub Align
$moduleAli = $params->get('sub-align','left');

	// Main Color
$mainColor = $params->get('main-color', 'normal');

	// Sub Color
$titleColor = $params->get('title-color', 'normal');

	// Title Space
$titleSpace = $params->get('title-space', 'large');

$alignMedia = $helper->get('align-media');
$bgContent = $helper->get('bg-content');

$bgRatio = $helper->get('bg-ratio');
$colMedia = '6';
$colContent = '6';

if($bgRatio == '2') {
	$colMedia = '5';
	$colContent = '7';
}
?>

<div class="acm-features style-3 bg-ratio-<?php echo $bgRatio;?>">
	<div class="row g-0 align-<?php echo $alignMedia; ?>">
		<?php if($helper->get('intro-img')) : ?>
			<div class="col-12 col-lg-<?php echo $colMedia ;?> features-media">
				<div class="intro-img" data-aos="fade-up" data-aos-delay="600">
					<img src="<?php echo $helper->get('intro-img') ?>" alt="" />
				</div>				
			</div>
		<?php endif ; ?>

		<div class="col-12 col-lg-<?php echo $colContent ;?> features-desc">
			<div class="info-wrap bg-<?php echo $bgContent ;?>">
				<div class="inner">
					<?php if($moduleTitle || $moduleMain || $moduleDesc): ?>
						<div class="section-title-wrap text-<?php echo $moduleAli ;?> space-<?php echo $titleSpace ;?>" data-aos="fade-up" data-aos-delay="600">
							<?php if($moduleTitle && ($module->showtitle == '1')): ?>
								<h3 class="section-title h6 text-<?php echo $titleColor ;?>">
									<span><?php echo $moduleTitle; ?></span>
								</h3>
							<?php endif; ?>

							<?php if($moduleMain) : ?>
								<div class="main-heading mt-0 text-<?php echo $mainColor ;?> h2">
									<?php echo $moduleMain; ?>
								</div>
							<?php endif; ?>

							<?php if($moduleDesc) : ?>
								<div class="mod-desc lead text-<?php echo $mainColor ;?>">
									<?php echo $moduleDesc; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if($helper->get('info-desc')) :?>
						<div class="info-desc lead text-<?php echo $moduleAli ;?>" data-aos="fade-up" data-aos-delay="800">
							<?php echo HTMLHelper::_('content.prepare', $helper->get('info-desc')) ;?>
						</div>
					<?php endif ;?>

					<?php for ($i=0; $i<$count; $i++) : ?>
						<div class="item">
							<div class="features-item">
								<div class="item-inner" data-aos="fade-up" data-aos-delay="1000">
									<?php if($helper->get('icon', $i)) : ?>
										<div class="icon">
											<span class="<?php echo $helper->get('icon', $i) ?>"></span>
										</div>
									<?php endif ; ?>
									
									<div class="item-info">
										<?php if($helper->get('title', $i)) : ?>
											<span class="feature-title">
												<?php echo $helper->get('title', $i) ?>
											</span>
										<?php endif ; ?>
										
										<?php if($helper->get('description', $i)) : ?>
											<div class="desc"><?php echo $helper->get('description', $i) ?></div>
										<?php endif ; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endfor ?>

					<?php if($helper->get('button')): ?>
            <div class="acm-action" data-aos="fade-up" data-aos-delay="1200">
              <?php if($helper->get('button')): ?>
                <a href="<?php echo $helper->get('btn-link'); ?>" class="btn btn-<?php echo $helper->get('btn-type') ;?>">
                  <?php echo $helper->get('button') ?>    
                </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
