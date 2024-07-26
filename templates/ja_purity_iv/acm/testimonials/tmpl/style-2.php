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

	$count 					= $helper->getRows('name');
?>

<div id="acm-testimonial-<?php echo $module->id; ?>" class="acm-testimonial style-2">
	<div class="container">
		<div class="testimonial-wrap">
			<div class="owl-carousel owl-theme">
				<?php 
					for ($i=0; $i<$count; $i++) : 
				?>
					<div class="testimonial-item-wrap">
						<?php if($helper->get('img', $i)) : ?>
							<div class="testimonial-img">
								<img src="<?php echo $helper->get('img', $i) ?>" alt="" />
							</div>
						<?php endif ; ?>

						<?php if($helper->get('member-description', $i)) : ?>
							<div class="description h2"><?php echo $helper->get('member-description', $i) ?></div>
						<?php endif ; ?>

						<?php if($helper->get('name', $i)) : ?>
							<h5 class="testimonial-name"><?php echo $helper->get('name', $i) ?></h5>
						<?php endif ; ?>
							
						<?php if($helper->get('member-position', $i)) : ?>
							<div class="testimonial-position"><?php echo $helper->get('member-position', $i) ?></div>
						<?php endif ; ?>
					</div>
				<?php endfor ?>
			</div>
		</div>
	</div>
</div>

<script>
(function($){
  jQuery(document).ready(function($) {
    $("#acm-testimonial-<?php echo $module->id; ?> .owl-carousel").owlCarousel({
      items: 1,
      margin: 0,
      dots: true,
      loop: true,
			rtl: $('html').attr('dir') === 'rtl'
    });
  });
})(jQuery);
</script>