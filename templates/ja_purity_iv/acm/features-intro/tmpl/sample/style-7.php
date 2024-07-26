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
	$bgSct =  $helper->get('bg-section');

	$colItem = 'col-12 col-sm-6 col-lg-'.(12/$column);

	if($column == 4) {
		$colItem = 'col-12 col-lg-6 col-xl-'.(12/$column);
	} elseif ($column == 3) {
		$colItem = 'col-12 col-md-12 col-lg-'.(12/$column);
	}
?>

<div class="acm-features style-7 <?php echo $bgSct; ?>" data-bg="<?php echo $bgSct; ?>">
	<div class="container">
		<div class="row">
			<?php for ($i=0; $i<$count; $i++) : ?>
				<div class="<?php echo $colItem; ?> item" data-aos="fade-up" data-aos-delay="<?php echo $i+4?>00">
					<div class="picture"><img src="<?php echo $helper->get('data.image', $i) ?>" alt="" /></div> 
					<h3><?php echo $helper->get('data.title', $i) ?></h3>
					<p class="mb-0"><?php echo $helper->get('data.desc-info', $i) ?></p> 
				</div>
			<?php endfor ?>
		</div>
	</div>
</div>

<script>
(function($){
  jQuery(document).ready(function($) {
    var bgColor = $('.acm-features.style-7').attr('data-bg');
    
    $('.acm-features.style-7').parents('.t4-section').addClass(bgColor);
  });
})(jQuery);
</script>