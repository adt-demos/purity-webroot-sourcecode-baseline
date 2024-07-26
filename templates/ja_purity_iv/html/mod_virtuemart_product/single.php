<?php // no direct access
defined('_JEXEC') or die('Restricted access');
vmJsApi::jPrice();
?>

<div class="vmgroup vmgroup<?php echo $params->get('moduleclass_sfx') ?> vm-signle-product">

	<?php if ($headerText) { ?>
		<div class="vm-header-text"><?php echo $headerText ?></div>
	<?php } ?>

	<div class="product-container vmproduct<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php foreach ($products as $product) { ?>
			<div class="vm-product-item">
				<div class="vm-product-media">
					<?php
						if (!empty($product->images[0]))
							$image = $product->images[0]->displayMediaThumb('class="featuredProductImage" ', false);
						else $image = '';

						echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));

						$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
						$product->virtuemart_category_id); ?>

						<?php if ($show_addtocart) echo shopFunctionsF::renderVmSubLayout('addtocart', array('product' => $product)); ?>
				</div>
				<div class="vm-product-content">
					<h4><a href="<?php echo $url ?>"><?php echo $product->product_name ?></a></h4>
					<?php // $product->prices is not set when show_prices in config is unchecked
					echo '<div class="productdetails">';
					if ($show_price and isset($product->prices)) {
						echo '<div class="product-price">';
						// 		echo $currency->priceDisplay($product->prices['salesPrice']);
						if (!empty($product->prices['salesPrice'])) echo $currency->createPriceDiv('salesPrice', '', $product->prices, true);
						// 		if ($product->prices['salesPriceWithDiscount']>0) echo $currency->priceDisplay($product->prices['salesPriceWithDiscount']);
						if (!empty($product->prices['salesPriceWithDiscount'])) echo $currency->createPriceDiv('salesPriceWithDiscount', '', $product->prices, true);
						echo '</div>';
					}
					echo '</div>';
					?>
				</div>
			</div>
			
		<?php } ?>
		<?php if ($footerText) { ?>
			<div class="vm-footer-text"><?php echo $footerText ?></div>
		<?php } ?>
	</div>
</div>