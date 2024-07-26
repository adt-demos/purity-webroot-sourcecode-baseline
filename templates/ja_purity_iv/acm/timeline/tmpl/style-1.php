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
	$count = $helper->getRows('timeline-title');
?>

<div class="ja-acm acm-timeline style-1">
	<div class="container">
		<div class="row justify-content-center">
			<div class="timeline-wrap col-12 col-lg-<?php echo $helper->get('timeline-content-width'); ?>">
				<?php for ($i=0; $i<$count; $i++) : ?>
					<div class="timeline-item">
						<?php if($helper->get('timeline-time', $i)) : ?>
							<span class="timeline-item-time"><?php echo $helper->get('timeline-time', $i) ?></span>
						<?php endif;?>

						<div class="timeline-item-info">
							<?php if($helper->get('timeline-image')) :?>
							<div class="timeline-item-image">
								<img src="<?php echo $helper->get('timeline-image', $i) ?>" alt="<?php echo $helper->get('timeline-title', $i) ?>" />
							</div> 
							<?php endif;?>
							
							<div class="timeline-ct">
								<h3 class="timeline-item-title mt-0 mb-2"><?php echo $helper->get('timeline-title', $i) ?></h3>
								<p class="timeline-item-desc"><?php echo $helper->get('timeline-desc', $i) ?></p>
							</div>
						</div>
					</div>
				<?php endfor ?>
			</div>
		</div>
	</div>
</div>

<script>
(function($){
  jQuery(document).ready(function($) {
    var bgColor = $('.acm-timeline.style-1').attr('data-bg');
   
    $('.acm-timeline.style-1').parents('.t4-section').addClass(bgColor);
  });
})(jQuery);
</script>