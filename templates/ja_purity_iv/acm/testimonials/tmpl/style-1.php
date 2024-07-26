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

$count = $helper->getRows('testimonial-heading');
?>

<div id="acm-testimonial-<?php echo $module->id; ?>" class="ja-acm acm-testimonial style-1">
	<div class="testimonial-wrap">
		<div class="<?php if($count > 1) { ?>owl-carousel owl-theme<?php } ?>">
			<?php for ($i=0; $i<$count; $i++) : ?>
				<div class="testimonial-item-wrap">
					<div class="row gx-0">
						<div class="col-12 col-lg-6 position-relative">
							<?php if($helper->get('testimonial-main-image', $i)) : ?>
								<div class="testimonial-media" style="background-image: url('<?php echo $helper->get('testimonial-main-image', $i) ?>'); background-size: <?php echo $helper->get('testimonial-media-fitsize', $i) ?>">
								</div>
							<?php endif ; ?>
						</div>

						<div class="col-12 col-lg-6">
							<div class="testimonial-content-wrap content-<?php echo $helper->get('testimonial-content-alignment') ?>">
								<div class="testimonial-content mb-4">
									<?php if($helper->get('testimonial-heading', $i)) : ?>
										<h2 class="mt-0 mb-4"><?php echo $helper->get('testimonial-heading', $i) ?></h2>
									<?php endif ; ?>

									<?php if($helper->get('testimonial-desc', $i)) : ?>
										<p class="my-0 lead"><?php echo $helper->get('testimonial-desc', $i) ?></p>
									<?php endif ; ?>
								</div>

								<div class="testimonial-author">
									<?php if($helper->get('author-image', $i)) : ?>
										<div class="author-image"><img src="<?php echo $helper->get('author-image', $i); ?>" alt="<?php echo $helper->get('author-name', $i); ?>"></div>
									<?php endif ; ?>

									<?php if($helper->get('author-name', $i)) : ?>
										<h6 class="author-name"><?php echo $helper->get('author-name', $i) ?></h6>
									<?php endif ; ?>

									<?php if($helper->get('author-position', $i)) : ?>
										<p class="my-0 author-position"><?php echo $helper->get('author-position', $i) ?></p>
									<?php endif ; ?>
								</div>
								
							</div>
						</div>
					</div>

				</div>
			<?php endfor ?>
		</div>
	</div>
</div>

<?php if($count > 1) { ?>
<script>
(function($){
  jQuery(document).ready(function($) {
    $("#acm-testimonial-<?php echo $module->id; ?> .owl-carousel").owlCarousel({
      items: 1,
      margin: 0,
      dots: true,
      loop: true,
			rtl: $('html').attr('dir') === 'rtl',
      responsive : {
				0 : {
			    items: 1,
			    autoHeight: true
				},
				767 : {
			    items: 1,
			    autoHeight: true
				},
				1200 : {
			    items: 1,
			    autoHeight: false
				}
			}
    });
  });
})(jQuery);
</script>
<?php } ?>