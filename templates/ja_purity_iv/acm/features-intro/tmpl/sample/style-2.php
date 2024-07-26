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
	$count = $helper->getRows('title');
	$column = $helper->get('columns');
	$ftAlign = $helper->get('align');

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

?>

<div id="acm-feature-wrap-<?php echo $module->id; ?>" class="acm-features style-2">
	<div class="row g-0">
		<div class="col-lg-6">
			<div class="feature-info">
				<div class="feature-inner">
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

					<?php if($helper->get('short-desc')) : ?>
						<div class="short-desc lead" data-aos="fade-up" data-aos-delay="700"><?php echo $helper->get('short-desc') ?></div>
					<?php endif ; ?>

					<div class="swiper-pagination-wrap" data-aos="fade-up" data-aos-delay="600">
						<div class="swiper-pagination"></div>
					</div>

					<div class="features-action" data-aos="fade-up" data-aos-delay="800">
						<div class="swiper-button swiper-button-prev btn-prev">
							<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M30.25 16H6.25" stroke="" stroke-linecap="square" stroke-linejoin="round"/>
							<path d="M8 11L2 16L8 21" fill=""/>
							</svg>

						</div>

						<div class="swiper-button swiper-button-next btn-next">
							<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.75 16H25.75" stroke="" stroke-linecap="square" stroke-linejoin="round"/>
								<path d="M24 11L30 16L24 21" fill=""/>
							</svg>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 slide-feature-intro">
			<div class="list-item" data-aos="fade-up" data-aos-delay="600">
			<div class="swiper swiper-wrapper-<?php echo $module->id ;?>">
				<div class="swiper-wrapper">
					<?php for ($i=0; $i<$count; $i++) : ?>
						<div class="swiper-slide bg-<?php echo $helper->get('bg-color', $i) ?>">
							<div class="features-item <?php if(!$helper->get('link', $i)) echo 'no-link' ?>">
								<div class="item-inner">
									<?php if($helper->get('img-icon', $i)) : ?>
										<div class="img-icon">
											<img src="<?php echo $helper->get('img-icon', $i) ?>" alt="" />
										</div>
									<?php endif ; ?>
									
									<?php if($helper->get('title', $i)) : ?>
										<h4 class="feature-title">
											<?php if($helper->get('link', $i)) : ?>
												<a href="<?php echo $helper->get('link', $i) ?>"class="link-headings">
											<?php endif ; ?>

											<?php echo $helper->get('title', $i) ?>

											<?php if($helper->get('link', $i)) : ?>
												</a>
											<?php endif ; ?>
										</h4>
									<?php endif ; ?>
									
									<?php if($helper->get('description', $i)) : ?>
										<div class="desc"><?php echo $helper->get('description', $i) ?></div>
									<?php endif ; ?>
								</div>
							</div>
						</div>
					<?php endfor ?>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>

<script>
  var swiper = new Swiper(".swiper-wrapper-<?php echo $module->id ;?>", {
  	slidesPerView: 2,
  	spaceBetween: 48,
  	freeMode: true,
    pagination: {
      el: ".swiper-pagination",
      type: "progressbar",
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
	    0: {
	      slidesPerView: 1,
	      spaceBetween: 24
	    },
	    480: {
	      slidesPerView: 2,
	      spaceBetween: 24
	    },
	    992: {
	      slidesPerView: 2,
	      spaceBetween: 24
	    },
	    1200: {
	    	slidesPerView: 1,
	      spaceBetween: 24
	    },
	    1400: {
	      slidesPerView: 2,
	      spaceBetween: 48
	    }
	  }
  });
</script>
