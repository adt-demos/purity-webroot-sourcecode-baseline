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
	$clientCount = $helper->getRows('data.client-image');

	$columns = (12 / $helper->get('columns'));
?>

<div class="ja-acm acm-clients style-1">
	<div class="container">
		<div class="row">
			<?php for ($i=0; $i < $clientCount; $i++) : ?>
				<div class="col-6 col-sm-4 col-lg-<?php echo $columns; ?> item d-flex pb-3 align-items-center justify-content-center">
					<a href="<?php echo $helper->get('data.client-link', $i); ?>" class="client-image opacity-<?php echo $helper->get('opacity') ;?>">
						<img src="<?php echo $helper->get('data.client-image', $i) ?>" alt="<?php echo $helper->get('data.client-name', $i); ?>" />
					</a> 
				</div>
			<?php endfor ?>
		</div>
	</div>
</div>