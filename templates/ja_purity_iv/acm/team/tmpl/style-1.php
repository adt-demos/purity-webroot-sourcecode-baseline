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
	$count = $helper->getRows('data.title');
	$column = $helper->get('columns');
	$colItem = 'col-12 col-sm-6 col-lg-'.(12/$column);

	if($column == 4) {
		$colItem = 'col-12 col-sm-6 col-xl-'.(12/$column);
	} elseif ($column == 3) {
		$colItem = 'col-12 col-md-12 col-lg-'.(12/$column);
	}
?>

<div class="ja-acm acm-team style-1">
	<div class="container">
		<?php if($helper->get('team-heading') || $helper->get('team-desc')) : ?>
		<div class="team-heading mb-5 row text-center justify-content-center">
			<div class="col-12 col-lg-6">
				<?php if($helper->get('team-heading')) : ?>
					<h2 class="mt-0 mb-4"><?php echo $helper->get('team-heading'); ?></h2>
				<?php endif ?>
				<?php if($helper->get('team-desc')) : ?>
					<p class="mt-0 mb-0 lead fw-normal"><?php echo $helper->get('team-desc'); ?></p>
				<?php endif ?>
			</div>
		</div>
		<?php endif ?>

		<div class="row v-gutters">
			<?php for ($i=0; $i<$count; $i++) : ?>
				<div class="<?php echo $colItem; ?> item text-center">
					<div class="picture mb-3"><img src="<?php echo $helper->get('data.image', $i) ?>" alt="<?php echo $helper->get('data.title', $i) ?>" /></div> 
					<h5 class="mt-0 mb-2"><?php echo $helper->get('data.title', $i) ?></h5>
					<span class="position"><?php echo $helper->get('data.position', $i) ?></span>
					<p class="mb-0"><?php echo $helper->get('data.desc-info', $i) ?></p> 
				</div>
			<?php endfor ?>
		</div>
	</div>
</div>

<script>
(function($){
  jQuery(document).ready(function($) {
    var bgColor = $('.acm-team.style-1').attr('data-bg');
   
    $('.acm-team.style-1').parents('.t4-section').addClass(bgColor);
  });
})(jQuery);
</script>