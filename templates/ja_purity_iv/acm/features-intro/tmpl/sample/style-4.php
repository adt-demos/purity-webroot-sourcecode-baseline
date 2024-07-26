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
	$count = $helper->getRows('info-title');
	$columns = 2;
?>

<div class="acm-features style-4">
	<div class="container">
	<?php 
	 	for ($i=0; $i<$count; $i++) :
	?>
		<div class="features-item">
			<div class="row align-<?php echo $helper->get('align-media', $i) ?>">
				<?php if($helper->get('intro-img', $i)) : ?>
					<div class="col-12 col-lg-6 features-media" data-aos="fade-up" data-aos-delay="<?php echo $i+8; ?>00">
						<div class="intro-img">
							<?php if($helper->get('btn-link', $i)) :?>
								<a href="<?php echo $helper->get('btn-link', $i) ?>" title="">
							<?php endif ; ?>
							<img src="<?php echo $helper->get('intro-img', $i) ?>" alt="" />
							<?php if($helper->get('btn-link', $i)) :?>
								</a>
							<?php endif ; ?>
						</div>				
					</div>
				<?php endif ; ?>

				<div class="col-12 col-lg-6 features-desc">
					<div class="info-wrap" data-aos="fade-up" data-aos-delay="<?php echo $i+9; ?>00">
						<div class="inner">
							<?php if($helper->get('info-title', $i)) : ?>
								<div class="info-title">
									<h3>
									<?php if($helper->get('btn-link', $i)) :?>
										<a href="<?php echo $helper->get('btn-link', $i) ?>" title="" class="link-headings">
									<?php endif ; ?>
										<?php echo $helper->get('info-title', $i) ?>
									<?php if($helper->get('btn-link', $i)) :?>
										</a>
									<?php endif ; ?>
									</h3>
								</div>
							<?php endif ; ?>

							<?php if($helper->get('sub-title', $i)) : ?>
								<div class="sub-title text-primary">
									<?php echo $helper->get('sub-title', $i) ?>
								</div>
							<?php endif ; ?>

							<?php if($helper->get('info-desc', $i)) : ?>
								<div class="info-desc">
									<?php echo $helper->get('info-desc', $i) ?>
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
			</div>
		</div>
		<?php endfor ?>
	</div>
</div>
