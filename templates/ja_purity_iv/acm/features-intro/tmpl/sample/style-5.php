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

	$colItem = 'col-12 col-sm-6 col-lg-'.(12/$column);

	if($column == 4) {
		$colItem = 'col-12 col-lg-6 col-xl-'.(12/$column);
	} elseif ($column == 3) {
		$colItem = 'col-12 col-md-12 col-lg-'.(12/$column);
	}
?>

<div class="acm-features style-5">
	<div class="container">
		<?php for ($i=0; $i<$count; $i++) : ?>
			<?php if ($i%$column==0) :?>
				<div class="row text-<?php echo $ftAlign ;?> cols-<?php echo $column ;?> d-flex justify-content-center v-gutters">
			<?php endif ;?>

				<div class="<?php echo $colItem; ?>">
					<div class="features-item bg-<?php echo $helper->get('bg-content', $i) ?>" data-aos="fade-up" data-aos-delay="<?php echo $i+6?>00">
						<div class="item-inner">
						<?php if($helper->get('intro-img', $i)) : ?>
								<div class="intro-img">
									<img src="<?php echo $helper->get('intro-img', $i) ?>" alt="" />
								</div>				
							<?php endif ; ?>

							<?php if($helper->get('title', $i)) : ?>
								<div class="feature-title">
									<h3>
										<?php echo $helper->get('title', $i) ?>
									</h3>
								</div>
							<?php endif ; ?>
							
							<?php if($helper->get('description', $i)) : ?>
								<div class="description"><?php echo $helper->get('description', $i) ?></div>
							<?php endif ; ?>
						</div>
					</div>
				</div>

			<?php if ( ($i%$column==($column-1)) || $i==($count-1) )  echo '</div>'; ?>
		<?php endfor ?>
	</div>
</div>