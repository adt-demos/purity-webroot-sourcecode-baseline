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
use Joomla\CMS\Uri\Uri;

	$count = $helper->getRows('title');
	$column = $helper->get('num-items');

	$colItem = 'col-12';

	$glTitle = $helper->get('gl-title');
	$glDesc = $helper->get('gl-desc');
	$glLink = $helper->get('gl-link');
	$glBg = $helper->get('gl-img');

	$bgPricing = '';

  if($glBg) {
		$bgPricing = 'style="background-image: url('.Uri::root().''.$helper->get('gl-img').');"';
	}

	if($column == 2) {
		$colItem = 'col-12 col-lg-6 col-xl-'.(12/$column);
		$colFeature = 'col-12 col-lg-6 col-xl-'.(12/$column);
	} elseif ($column == 3) {
		$colItem = 'col-12 col-md-6 col-lg-'.(12/$column);
		$colFeature = 'col-12 col-md-12 col-lg-'.(12/$column);
	}
?>

<div class="acm-pricing style-1">
	<div class="container">
		<div class="row cols-<?php echo $column ;?> v-gutters">
			<?php if($glTitle) :?>
			<div class="<?php echo $colFeature; ?>">
				<div class="pricing-features" <?php echo $bgPricing ;?>>
					<div class="feature-inner">
						<h2><?php echo $glTitle ;?></h2>

						<?php if($glDesc) :?>
							<div class="pricing-desc">
								<?php echo $glDesc ;?>
							</div>
						<?php endif ;?>

						<?php if($glLink) :?>
							<div class="pricing-action">
								<a href="<?php echo $glLink ;?>" title="<?php echo $glTitle ;?>">
									<i class="fas fa-arrow-right"></i>
								</a>
							</div>
						<?php endif ;?>
					</div>
				</div>
			</div>
			<?php endif ;?>

			<?php for ($i=0; $i<$count; $i++) : ?>
				<div class="<?php echo $colItem; ?>">
					<div class="pricing-item">
						<div class="item-inner">
							<div class="header-intro">
								<?php if($helper->get('img-intro', $i)) : ?>
								<div class="img-intro">
									<img src="<?php echo $helper->get('img-intro', $i) ?>" alt="" />
								</div>
								<?php endif ; ?>

								<div class="pricing-title-info">
									<h3><?php echo $helper->get('title', $i) ?></h3>
								</div>
							</div>

							<div class="pricing-content">
								<?php if($helper->get('desc', $i)) : ?>
								<div class="pricing-desc">
									<?php echo $helper->get('desc', $i) ?>
								</div>
								<?php endif ; ?>

								<?php if($helper->get('plan-list', $i)) : ?>
								<div class="pricing-plan-list">
									<?php echo $helper->get('plan-list', $i) ?>
								</div>
								<?php endif ; ?>

								<?php if($helper->get('price', $i)) : ?>
								<div class="pricing-plan-price h2">
									<?php echo $helper->get('price', $i) ?>
								</div>
								<?php endif ; ?>
							</div>
						</div>

						<div class="pricing-action">
							<?php if($helper->get('btn-link', $i)) :?>
								<a class="btn btn-<?php echo $helper->get('btn-type', $i) ?> w-100" href="<?php echo $helper->get('btn-link', $i) ?>" title="">
									<?php echo $helper->get('btn-title', $i) ?>
								</a>
							<?php endif ;?>
						</div>
					</div>
				</div>
			<?php endfor ?>
		</div>
	</div>
</div>