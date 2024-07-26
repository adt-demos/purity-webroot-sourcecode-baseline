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

<div class="acm-features style-6">
	<div class="container">
		<?php for ($i=0; $i<$count; $i++) : ?>
			<?php if ($i%$column==0) :?>
				<div class="row text-<?php echo $ftAlign ;?> cols-<?php echo $column ;?> d-flex justify-content-center v-gutters">
			<?php endif ;?>

				<div class="<?php echo $colItem; ?>">
					<div class="features-item bg-<?php echo $helper->get('bg-content', $i) ?>" data-aos="fade-up" data-aos-delay="<?php echo $i+8?>00">
						<div class="item-inner">
						<?php if($helper->get('intro-img', $i)) : ?>
								<div class="intro-img">
									<?php if($helper->get('button', $i)): ?>
		                <a href="<?php echo $helper->get('btn-link', $i); ?>" class="link-headings">
		              <?php endif ;?>
										<img src="<?php echo $helper->get('intro-img', $i) ?>" alt="" />
									<?php if($helper->get('button', $i)): ?>
		                </a>
		              <?php endif ;?>
								</div>				
							<?php endif ; ?>

							<?php if($helper->get('title', $i)) : ?>
								<div class="feature-title">
									<h3>
										<?php if($helper->get('button', $i)): ?>
		                <a href="<?php echo $helper->get('btn-link', $i); ?>" class="link-headings">
		              	<?php endif ;?>
											<?php echo $helper->get('title', $i) ?>
										<?php if($helper->get('button', $i)): ?>
		                </a>
		              <?php endif ;?>
									</h3>
								</div>
							<?php endif ; ?>

							<?php if($helper->get('sub-title', $i)) : ?>
								<div class="sub-title"><?php echo $helper->get('sub-title', $i) ?></div>
							<?php endif ; ?>
							
							<?php if($helper->get('info-left', $i) || $helper->get('info-right', $i)) : ?>
								<div class="d-flex list-info">
									<?php if($helper->get('info-left', $i)) :?>
									<div class="item">
										<?php echo $helper->get('info-left', $i) ?>	
									</div>
									<?php endif ; ?>

									<?php if($helper->get('info-left', $i)) :?>
									<div class="item">
										<?php echo $helper->get('info-right', $i) ?>	
									</div>
									<?php endif ; ?>
								</div>
							<?php endif ; ?>

							<?php if($helper->get('button', $i)): ?>
		            <div class="acm-action">
		              <?php if($helper->get('button', $i)): ?>
		                <a href="<?php echo $helper->get('btn-link', $i); ?>" class="btn btn-<?php echo $helper->get('btn-type', $i) ;?>">
		                  <?php echo $helper->get('button', $i) ?>    
		                </a>
		              <?php endif; ?>
		            </div>
		          <?php endif; ?>
						</div>
					</div>
				</div>

			<?php if ( ($i%$column==($column-1)) || $i==($count-1) )  echo '</div>'; ?>
		<?php endfor ?>
	</div>
</div>